<?php
include '../config/connection.php'; // Update the path to your database connection file

header('Content-Type: application/json');

// SQL query to fetch feedback from the Feedback table
$sql = "SELECT f.FeedbackID, u.username, f.FeedbackText 
        FROM Feedback f
        JOIN Users u ON f.UserID = u.UserID
        ORDER BY f.DateCreated DESC";

// Prepare and execute the SQL statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Database error: ' . $conn->error]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$feedbacks = [];
while ($row = $result->fetch_assoc()) {
    $feedbacks[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($feedbacks);
?>
