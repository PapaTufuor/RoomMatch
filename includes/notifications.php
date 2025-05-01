<?php
include '../config/connection.php';
include '../includes/userfunctions.php';
function getNotifications($userId, $conn) {
    // Fetch notifications for the logged-in user
    $stmt = $conn->prepare("SELECT Notifications.NotificationID, Notifications.NotificationText, Notifications.UserID, Requests.SenderUserID
                            FROM Notifications 
                            JOIN Requests ON Notifications.UserID = Requests.ReceiverUserID
                            WHERE Notifications.UserID = ? AND Requests.Accepted = 0");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through each notification and display it
    while ($notification = $result->fetch_assoc()) {
        $senderId = $notification['SenderUserID'];
        $senderDetails = getUserDetails($senderId); // Assuming you have a function to fetch user details

        echo '<div class="single-box unseen">';
        echo '<div class="avatar"><img src="../uploads/' . $senderDetails['profile_image'] . '" alt="Avatar"></div>';
        echo '<div class="message">' . htmlspecialchars($notification['NotificationText']) . '</div>';
        echo '<div class="actions">';
        echo '<a href="#" class="accept" onclick="respondToRequest(' . $notification['NotificationID'] . ', ' . $senderId . ', 1)">✔️</a>';
        echo '<a href="#" class="decline" onclick="respondToRequest(' . $notification['NotificationID'] . ', ' . $senderId . ', 0)">❌</a>';
        echo '</div>';
        echo '</div>';
    }
    $stmt->close();
}
