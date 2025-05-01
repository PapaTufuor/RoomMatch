<?php
include '../config/connection.php';
include '../config/core.php';

$senderUserId = $_SESSION['UserID']; // Get the logged-in user's ID from the session
$receiverUserId = isset($_POST['profileUserId']) ? intval($_POST['profileUserId']) : null; // Get the profile user ID from the form

if ($senderUserId && $receiverUserId) {
    // Insert the request into the Requests table
    $stmt = $conn->prepare("INSERT INTO Requests (SenderUserID, ReceiverUserID) VALUES (?, ?)");
    $stmt->bind_param("ii", $senderUserId, $receiverUserId);

    if ($stmt->execute()) {
        // Fetch sender's name
        $stmt = $conn->prepare("SELECT FirstName, LastName FROM Users WHERE UserID = ?");
        $stmt->bind_param("i", $senderUserId);
        $stmt->execute();
        $stmt->bind_result($firstName, $lastName);
        $stmt->fetch();
        $stmt->close();

        $senderName = $firstName . ' ' . $lastName;
        $notificationText = "You have received a new roommate request from $senderName.";

        // Add a notification for the receiver
        $stmt = $conn->prepare("INSERT INTO Notifications (UserID, NotificationText) VALUES (?, ?)");
        $stmt->bind_param("is", $receiverUserId, $notificationText);
        $stmt->execute();
        $stmt->close();

        // Redirect with success message
        header("Location: ../templates/bio.php?user_id=$receiverUserId&msg=Request sent successfully.");
    } else {
        // Redirect with error message
        header("Location: ../templates/bio.php?user_id=$receiverUserId&msg=Error sending request.");
    }
} else {
    // Redirect with invalid request message
    header("Location: ../templates/bio.php?user_id=$receiverUserId&msg=Invalid request.");
}

$conn->close();
exit(); // Make sure to call exit after a header redirect
?>
