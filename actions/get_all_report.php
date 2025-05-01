<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include '../config/connection.php';

// Function to get all feedback with user names
function getFeedback($conn) {
    // SQL query to fetch all feedback along with the user's full name
    $sql = "SELECT Feedback.FeedbackID, Feedback.FeedbackText, Feedback.DateCreated, Users.FirstName, Users.LastName 
            FROM Feedback 
            JOIN Users ON Feedback.UserID = Users.UserID
            ORDER BY Feedback.DateCreated DESC";

    $result = $conn->query($sql);

    $feedbacks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $feedbacks[] = $row;
        }
    }
    
    return $feedbacks;
}

// Fetch the feedback
$feedbacks = getFeedback($conn);

// Handle the result
if (empty($feedbacks)) {
    // No feedback found
    header("Location: ../view/Profile.php?msg=No feedback found.");
} else {
    // Feedback found, you might want to pass this data back to a view or use it as needed
    header("Location: ../view/Profile.php?msg=Feedback retrieved successfully.");
}

// Close the database connection
$conn->close();
?>


?>