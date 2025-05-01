<?php
include '../config/connection.php';
include '../config/core.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['UserID']; // Assuming the user's ID is stored in session after login
    $feedbackText = trim($_POST['message']);

    if (!empty($feedbackText)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO Feedback (UserID, FeedbackText) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $feedbackText);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect with a success message
            header("Location: ../templates/profile.php?msg=Feedback submitted successfully!");
        } else {
            // Redirect with an error message
            header("Location: ../templates/profile.php?msg=Error: " . urlencode($stmt->error));
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect with a validation message
        header("Location: ../templates/profile.php?msg=Feedback text cannot be empty.");
    }
} else {
    // Redirect with an invalid request message
    header("Location: ../templates/profile.php?msg=Invalid request method.");
}

// Close the database connection
$conn->close();
?>
