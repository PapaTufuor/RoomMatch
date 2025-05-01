<?php
// include '../config/connection.php';

// // Check if POST data exists
// if (!isset($_POST['user_id']) || !isset($_POST['reason'])) {
//     die('Required POST data missing.');
// }


// // Get POST data
// $user_id = intval($_POST['user_id']);
// $reason = $_POST['reason'];

// // Check for valid data
// if ($user_id <= 0 || empty($reason)) {
//     die('Invalid data provided.');
// }

// // Prepare SQL statement
// $stmt = $conn->prepare("INSERT INTO Blacklist (UserID, Reason) VALUES (?, ?)");
// if ($stmt === false) {
//     die('Prepare failed: ' . $conn->error);
// }

// $stmt->bind_param("is", $user_id, $reason);

// if ($stmt->execute()) {
//     echo 'User blocked successfully.';
// } else {
//     echo 'Error blocking user: ' . $stmt->error;
// }

// $stmt->close();
// $conn->close();



include '../config/connection.php';

// Check if POST data exists
if (!isset($_POST['user_id']) || !isset($_POST['reason'])) {
    die('Required POST data missing.');
}

// Get POST data
$user_id = intval($_POST['user_id']);
$reason = $_POST['reason'];

// Check for valid data
if ($user_id <= 0 || empty($reason)) {
    die('Invalid data provided.');
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO Blacklist (UserID, Reason) VALUES (?, ?)");
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param("is", $user_id, $reason);

if ($stmt->execute()) {
    echo 'User blocked successfully.';
} else {
    echo 'Error blocking user: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>

