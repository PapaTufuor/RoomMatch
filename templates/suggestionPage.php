<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/core.php';
include '../config/connection.php';

if (!isset($_SESSION['UserID'])) {
    die("Error: User is not logged in.");
}

$target_user_id = $_SESSION['UserID'];

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

// Function to retrieve user attributes from the database
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

// Function to get user profile details including bio
function get_user_profile($conn, $userID) {
    $sql = "SELECT UserID, FirstName, LastName, ProfileImage, Bio FROM Users WHERE UserID = ?";
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

// Function to generate roommate suggestions
function generateRoommateSuggestions($conn, $target_user_id) {
    $userLikes = getUserAttributes($conn, 'Like');
    $userDislikes = getUserAttributes($conn, 'Dislike');
    $userKnows = getUserAttributes($conn, 'Know');

    $likesMatrix = createUserAttributeMatrix($userLikes);
    $dislikesMatrix = createUserAttributeMatrix($userDislikes);
    $knowsMatrix = createUserAttributeMatrix($userKnows);

    $combinedMatrix = [];
    $allUsers = array_unique(array_merge(array_keys($likesMatrix), array_keys($dislikesMatrix), array_keys($knowsMatrix)));

    foreach ($allUsers as $userID) {
        $combinedMatrix[$userID] = array_merge(
            $likesMatrix[$userID] ?? [],
            $dislikesMatrix[$userID] ?? [],
            $knowsMatrix[$userID] ?? []
        );
    }

    if (!isset($combinedMatrix[$target_user_id])) {
        return ["error" => "Target user not found in the attribute matrices."];
    }

    $similarUsers = findSimilarUsers($target_user_id, $combinedMatrix);

    $filteredUsers = array_filter($similarUsers, function($pair) {
        return $pair['Similarity'] > 30;
    });

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
            'Bio' => $user_profile['Bio'], // Include the user bio
            'Similarity' => $similarity
        ];
    }

    return $similarUsersData;
}

// Generate roommate suggestions
$suggestions = generateRoommateSuggestions($conn, $target_user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../public/css/roomates_new.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <title>RoomRover - Find Your Perfect Match</title>
    <style>
        .filters {
            padding: 20px;
            background: #f5f5f5;
            border-radius: 8px;
            margin: 20px 0;
        }
        .filter-group {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 15px;
        }
        .compatibility-score {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin: 10px 0;
        }
        .match-details {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .preference-match {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .sort-options {
            margin: 10px 0;
        }
        .match-strength {
            width: 100%;
            height: 8px;
            background: #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .match-strength-bar {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="band">
        <h1>SUGGESTED ROOMMATES</h1>
    </div>

    <!-- New Filter and Sort Section -->
    <div class="filters">
        <div class="filter-group">
            <label for="compatibility-filter">Minimum Compatibility:</label>
            <input type="range" id="compatibility-filter" min="30" max="100" value="30" 
                   onchange="document.getElementById('comp-value').textContent = this.value + '%'">
            <span id="comp-value">30%</span>
        </div>
        
        <div class="filter-group">
            <label for="hostel-filter">Preferred Hostel:</label>
            <select id="hostel-filter">
                <option value="">All Hostels</option>
                <option value="kofi">Kofi Tawiah</option>
                <option value="wangari">Wangari Mathai</option>
                <option value="walter">Walter Sisulu</option>
            </select>

            <label for="sort-by">Sort By:</label>
            <select id="sort-by" onchange="sortMatches(this.value)">
                <option value="compatibility">Compatibility (High to Low)</option>
                <option value="name">Name (A-Z)</option>
                <option value="recent">Most Recent</option>
            </select>
        </div>
    </div>

    <div id="suggestions-container">
        <?php if (isset($suggestions['error'])): ?>
            <p><?php echo $suggestions['error']; ?></p>
        <?php else: ?>
            <?php foreach ($suggestions as $user): ?>
                <div class="card" data-compatibility="<?php echo $user['Similarity']; ?>">
                    <input type="checkbox" id="card<?php echo $user['UserID']; ?>" class="more" aria-hidden="true">
                    <div class="content">
                        <div class="front" style="background-image: url('<?php echo $user['ProfileImage']; ?>');">
                            <div class="inner">
                                <h2><?php echo $user['FirstName'] . ' ' . $user['LastName']; ?></h2>
                                <!-- Enhanced Compatibility Score Display -->
                                <div class="compatibility-score">
                                    <?php echo $user['Similarity']; ?>% Match
                                </div>
                                <div class="match-strength">
                                    <div class="match-strength-bar" style="width: <?php echo $user['Similarity']; ?>%"></div>
                                </div>
                                <label for="card<?php echo $user['UserID']; ?>" class="button" aria-hidden="true">
                                    View Full Profile
                                </label>
                            </div>
                        </div>
                        <div class="back">
                            <div class="inner">
                                <!-- Detailed Match Breakdown -->
                                <div class="match-details">
                                    <h3>Compatibility Breakdown</h3>
                                    <?php
                                    // Get matching preferences
                                    $matchingLikes = array_intersect(
                                        getUserAttributes($conn, 'Like')[$target_user_id] ?? [],
                                        getUserAttributes($conn, 'Like')[$user['UserID']] ?? []
                                    );
                                    $matchingDislikes = array_intersect(
                                        getUserAttributes($conn, 'Dislike')[$target_user_id] ?? [],
                                        getUserAttributes($conn, 'Dislike')[$user['UserID']] ?? []
                                    );
                                    ?>
                                    <div class="preference-match">
                                        <span>Shared Interests:</span>
                                        <span><?php echo count($matchingLikes); ?> matches</span>
                                    </div>
                                    <div class="preference-match">
                                        <span>Similar Dislikes:</span>
                                        <span><?php echo count($matchingDislikes); ?> matches</span>
                                    </div>
                                </div>

                                <div class="description">
                                    <p><?php echo $user['Bio']; ?></p>
                                </div>

                                <form action="../templates/bio.php?user_id=<?php echo $user['UserID']; ?>" method="POST">
                                    <input type="hidden" name="userID" value="<?php echo $user['UserID']; ?>">
                                    <button type="submit" class="button">View Full Profile</button>
                                </form>

                                <label for="card<?php echo $user['UserID']; ?>" class="button return" aria-hidden="true">
                                    <i class="fas fa-arrow-left"></i> Back
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Filter and sort functionality
function filterAndSortMatches() {
    const minCompatibility = document.getElementById('compatibility-filter').value;
    const hostelFilter = document.getElementById('hostel-filter').value;
    const sortBy = document.getElementById('sort-by').value;
    const container = document.getElementById('suggestions-container');
    const cards = Array.from(container.getElementsByClassName('card'));

    cards.forEach(card => {
        const compatibility = parseInt(card.dataset.compatibility);
        const hostel = card.dataset.hostel;
        
        // Apply filters
        const matchesCompatibility = compatibility >= minCompatibility;
        const matchesHostel = !hostelFilter || hostel === hostelFilter;
        
        card.style.display = (matchesCompatibility && matchesHostel) ? 'block' : 'none';
    });

    // Sort cards
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'compatibility':
                return parseInt(b.dataset.compatibility) - parseInt(a.dataset.compatibility);
            case 'name':
                return a.querySelector('h2').textContent.localeCompare(b.querySelector('h2').textContent);
            case 'recent':
                return parseInt(b.dataset.timestamp) - parseInt(a.dataset.timestamp);
            default:
                return 0;
        }
    });

    // Reorder cards in the container
    cards.forEach(card => container.appendChild(card));
}

// Add event listeners
document.getElementById('compatibility-filter').addEventListener('input', filterAndSortMatches);
document.getElementById('hostel-filter').addEventListener('change', filterAndSortMatches);
document.getElementById('sort-by').addEventListener('change', filterAndSortMatches);

// Initial sort
filterAndSortMatches();
</script>

</body>
</html>
