<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include '../config/connection.php';

// Function to block a user
function blockUser($conn, $userID, $reason) {
    // Check if the user is already blocked
    $checkStmt = $conn->prepare("SELECT * FROM Blacklist WHERE UserID = ?");
    $checkStmt->bind_param("i", $userID);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $checkStmt->close();
        return "User with ID $userID is already blocked.";
    }

    $checkStmt->close();

    // If the user is not blocked, insert them into the Blacklist table
    $stmt = $conn->prepare("INSERT INTO Blacklist (UserID, Reason) VALUES (?, ?)");
    $stmt->bind_param("is", $userID, $reason);

    if ($stmt->execute()) {
        $stmt->close();
        return "User with ID $userID has been blocked successfully.";
    } else {
        $error = $stmt->error;
        $stmt->close();
        return "Error blocking user: " . $error;
    }
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID and reason from POST data
    $userID = $_POST['userID'];  // User ID to block
    $reason = $_POST['reason'];  // Reason for blocking the user

    // Validate input
    if (!empty($userID) && !empty($reason)) {
        // Call the blockUser function and capture the result message
        $message = blockUser($conn, $userID, $reason);
        $status = (strpos($message, 'successfully') !== false) ? 'success' : 'error';
    } else {
        $message = "User ID and reason for blocking are required.";
        $status = 'error';
    }

    // Redirect with message
    header("Location: block.php?msg=" . urlencode($message) . "&status=" . $status);
    exit();
}

// Close the database connection
$conn->close();
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Block User</title>
</head>
<body>
    <h1>Block User</h1>

  <?php //if (isset($_GET['msg'])): ?>
        <p style="color: <?php //echo ($_GET['status'] == 'success') ? 'green' : 'red'; ?>;">
            <?php //echo htmlspecialchars($_GET['msg']); ?>
        </p>
    <?php //endif; ?>

    <form method="POST" action="block.php">
        <label for="userID">User ID:</label>
        <input type="number" name="userID" id="userID" required><br><br>
        
        <label for="reason">Reason for Blocking:</label><br>
        <textarea name="reason" id="reason" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Block User">
    </form>
</body>
</html> -->
