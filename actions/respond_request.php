<?php
include '../config/connection.php';
include '../config/core.php';

$notificationId = isset($_POST['notificationId']) ? intval($_POST['notificationId']) : null;
$senderId = isset($_POST['senderId']) ? intval($_POST['senderId']) : null;
$isAccepted = isset($_POST['isAccepted']) ? intval($_POST['isAccepted']) : null;

if ($notificationId && $senderId && $isAccepted !== null) {
    // Update the Requests table based on user response
    $stmt = $conn->prepare("UPDATE Requests SET Accepted = ? WHERE SenderUserID = ? AND ReceiverUserID = ?");
    $stmt->bind_param("iii", $isAccepted, $senderId, $_SESSION['UserID']);
    
    if ($stmt->execute()) {
        if ($isAccepted === 1) {
            // Check if the sender already has a pairing with less than 4 members
            $stmt = $conn->prepare("
                SELECT p.PairingID, COUNT(pm.UserID) AS member_count
                FROM Pairings p
                LEFT JOIN PairingMembers pm ON p.PairingID = pm.PairingID
                WHERE pm.UserID = ? OR pm.UserID = ?
                GROUP BY p.PairingID
                HAVING member_count < 4
                LIMIT 1
            ");
            $stmt->bind_param("ii", $senderId, $_SESSION['UserID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                // Existing pairing found with space for more members
                $pairingId = $row['PairingID'];
            } else {
                // Create a new pairing with compatibility score of 100
                $stmt = $conn->prepare("INSERT INTO Pairings (CompatibilityScore) VALUES (100.00)");
                $stmt->execute();
                $pairingId = $stmt->insert_id;
            }

            // Add both sender and receiver to the pairing members if not already present
            $stmt = $conn->prepare("INSERT IGNORE INTO PairingMembers (PairingID, UserID) VALUES (?, ?), (?, ?)");
            $stmt->bind_param("iiii", $pairingId, $senderId, $pairingId, $_SESSION['UserID']);
            $stmt->execute();

            // Redirect with success message
            header('Location: ../templates/profile.php?msg=Request accepted and pairing updated successfully.');
        } else {
            // Redirect with rejection message
            header('Location: ../templates/profile.php?msg=Request rejected.');
        }

        // Optionally, mark the notification as read or delete it
        $stmt = $conn->prepare("DELETE FROM Notifications WHERE NotificationID = ?");
        $stmt->bind_param("i", $notificationId);
        $stmt->execute();

    } else {
        // Redirect with error message if the request update failed
        header('Location: ../templates/profile.php?msg=Failed to update the request.');
    }
} else {
    // Redirect with error message for invalid data
    header('Location: ../templates/profile.php?msg=Error: Invalid data.');
}

$conn->close();
exit();
?>
