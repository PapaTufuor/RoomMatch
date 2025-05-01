<?php

include '../config/connection.php';
include '../config/core.php';

// Check if user is logged in
checkLogin();

$userId = $_SESSION['UserID'];
$newBio = isset($_POST['bio']) ? trim($_POST['bio']) : '';

if (!empty($newBio)) {
    // Update the bio in the database
    $stmt = $conn->prepare("UPDATE Users SET Bio = ? WHERE UserID = ?");
    $stmt->bind_param("si", $newBio, $userId);

    if ($stmt->execute()) {
        header("Location: ../templates/profile.php?msg=Bio updated successfully.");
    } else {
        header("Location: ../templates/profile.php?msg=Error updating bio.");
    }

    $stmt->close();
} else {
    header("Location: ../templates/profile.php?msg=Bio cannot be empty.");
}

$conn->close();
?>
