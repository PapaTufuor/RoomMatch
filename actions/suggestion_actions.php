<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the core file for session handling
include '../config/core.php';

// Check if the user is logged in and session user ID is set
if (!isset($_SESSION['UserID'])) {
    die("Error: User is not logged in.");
}

// Get the target user ID from the session
$target_user_id = $_SESSION['UserID'];

// Include the database configuration
include '../config/connection.php';

// Function to calculate cosine similarity between two vectors
function cosineSimilarity($a, $b) {
    $dotProduct = 0;
    $normA = 0;
    $normB = 0;
    for ($i = 0; $i < count($a); $i++) {
        $dotProduct += $a[$i] * $b[$i];
        $normA += $a[$i] * $a[$i];
        $normB += $b[$i] * $b[$i];
    }
    $normA = sqrt($normA);
    $normB = sqrt($normB);
    
    if ($normA == 0 || $normB == 0) {
        return 0;
    }
    
    return $dotProduct / ($normA * $normB);
}

// Function to retrieve user likes, dislikes, and knows from the database
function getUserAttributes($conn, $table) {
    $sql = "SELECT UserID, {$table}ID FROM User{$table}s";
    $result = $conn->query($sql);
    
    $userAttributes = [];
    while ($row = $result->fetch_assoc()) {
        $userID = $row['UserID'];
        $attributeID = $row["{$table}ID"];
        if (!isset($userAttributes[$userID])) {
            $userAttributes[$userID] = [];
        }
        $userAttributes[$userID][] = $attributeID;
    }
    
    return $userAttributes;
}

// Function to create a matrix of user attributes
function createUserAttributeMatrix($userAttributes) {
    $allAttributes = [];
    foreach ($userAttributes as $attributes) {
        $allAttributes = array_merge($allAttributes, $attributes);
    }
    $allAttributes = array_unique($allAttributes);
    
    $matrix = [];
    foreach ($userAttributes as $userID => $attributes) {
        $matrix[$userID] = array_fill_keys($allAttributes, 0);
        foreach ($attributes as $attr) {
            $matrix[$userID][$attr] = 1;
        }
    }
    
    return $matrix;
}

// Function to find similar users based on cosine similarity
function findSimilarUsers($targetUserID, $matrix) {
    $similarities = [];
    $targetVector = $matrix[$targetUserID];
    
    foreach ($matrix as $userID => $vector) {
        if ($userID != $targetUserID) {
            $similarity = cosineSimilarity(array_values($targetVector), array_values($vector));
            $similarityPercentage = round($similarity * 100, 2);
            $similarities[] = ['UserID' => $userID, 'Similarity' => $similarityPercentage];
        }
    }

    usort($similarities, function($a, $b) {
        return $b['Similarity'] <=> $a['Similarity'];
    });

    return $similarities;
}

// Function to get user profile details
function get_user_profile($conn, $userID) {
    $sql = "SELECT UserID, FirstName, LastName, DateOfBirth, Gender, Email, PhoneNumber, UserType, ProfileImage, DisabilityStatus 
            FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_profile = $result->fetch_assoc();
    } else {
        $user_profile = ["error" => "User not found"];
    }

    $stmt->close();

    return $user_profile;
}

// Database connection
$conn = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user attributes from the database
$userLikes = getUserAttributes($conn, 'Like');
$userDislikes = getUserAttributes($conn, 'Dislike');
$userKnows = getUserAttributes($conn, 'Know');

// Create the user-attribute matrices
$likesMatrix = createUserAttributeMatrix($userLikes);
$dislikesMatrix = createUserAttributeMatrix($userDislikes);
$knowsMatrix = createUserAttributeMatrix($userKnows);

// Merge matrices to create a combined attribute matrix
$combinedMatrix = [];
$allUsers = array_unique(array_merge(array_keys($likesMatrix), array_keys($dislikesMatrix), array_keys($knowsMatrix)));

foreach ($allUsers as $userID) {
    $combinedMatrix[$userID] = array_merge(
        $likesMatrix[$userID] ?? [],
        $dislikesMatrix[$userID] ?? [],
        $knowsMatrix[$userID] ?? []
    );
}

// Check if the target user exists in the combined matrix
if (!isset($combinedMatrix[$target_user_id])) {
    die("Error: Target user not found in the attribute matrices.");
}

// Find similar users
$similarUsers = findSimilarUsers($target_user_id, $combinedMatrix);

// Filter out users with similarity above 30%
$filteredUsers = array_filter($similarUsers, function($pair) {
    return $pair['Similarity'] > 30;
});

// Output similar users in JSON format
$similarUsersData = [];

foreach ($filteredUsers as $pair) {
    $user_profile = get_user_profile($conn, $pair['UserID']);
    $similarity = $pair['Similarity'];

    if (isset($user_profile['error'])) {
        continue;
    }

    $similarUsersData[] = [
        'UserID' => $user_profile['UserID'],
        'FirstName' => $user_profile['FirstName'],
        'LastName' => $user_profile['LastName'],
        'ProfileImage' => $user_profile['ProfileImage'],
        'Similarity' => $similarity
    ];
}

// Close the database connection
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');

// Output the data as JSON
echo json_encode(['status' => 'success', 'data' => $similarUsersData]);

?>
