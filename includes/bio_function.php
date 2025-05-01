<?php
include '../config/connection.php';
include '../config/core.php';
include 'userfunctions.php';

$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($userId) {
    $userDetails = getUserDetails($userId);

    if ($userDetails) {
        // Extract user details
        $firstName = htmlspecialchars($userDetails['first_name']);
        $lastName = htmlspecialchars($userDetails['last_name']);
        $fullName = $firstName . ' ' . $lastName;
        $email = htmlspecialchars($userDetails['email']);
        $dob = htmlspecialchars($userDetails['date_of_birth']);
        $profileImage = htmlspecialchars($userDetails['profile_image']);
    } else {
        // Redirect or show a message if user not found
        echo "<p>User not found.</p>";
        exit;
    }
} else {
    // Redirect or show a message if no user ID is provided
    echo "<p>No user ID provided.</p>";
    exit;
}
?>
