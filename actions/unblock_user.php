<?php
include '../config/connection.php';

// Check if POST data exists
if (!isset($_POST['user_id'])) {
    die('Required POST data missing.');
}

// Get POST data
$user_id = intval($_POST['user_id']);

// Check for valid data
if ($user_id <= 0) {
    die('Invalid data provided.');
}

// Prepare SQL statement to remove user from blacklist
$stmt = $conn->prepare("DELETE FROM Blacklist WHERE UserID = ?");
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo 'User unblocked successfully.';
} else {
    echo 'Error unblocking user: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>
