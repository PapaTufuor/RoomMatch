<?php
// Include configuration and start session
include "../config/connection.php";
include "../config/core.php";



$userID = $_SESSION['UserID'];
$roomID = isset($_GET['roomID']) ? intval($_GET['roomID']) : 0;

// Get pairing information for the user
$sql = "SELECT PairingID FROM PairingMembers WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$pairingID = null;
$otherUserIDs = [];

if ($result->num_rows > 0) {
    $pairing = $result->fetch_assoc();
    $pairingID = $pairing['PairingID'];

    // Get all users in the pairing
    $sql = "SELECT UserID FROM PairingMembers WHERE PairingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pairingID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if ($row['UserID'] != $userID) {
            $otherUserIDs[] = $row['UserID'];
        }
    }
}

// Ensure the number of users is valid (1, 2, or 4)
$totalUsers = count($otherUserIDs) + 1; // +1 for the current user
if ($totalUsers != 1 && $totalUsers != 2 && $totalUsers != 4) {
    header("Location: ../templates/affrimamu.php?msg=Invalid number of users for booking.");
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    // Check if the user or any paired users are already booked in any room
    $allUserIDs = array_merge([$userID], $otherUserIDs);
    foreach ($allUserIDs as $uID) {
        $sql = "SELECT RoomID, SlotID FROM Bookings WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $existingBooking = $result->fetch_assoc();
            $existingRoomID = $existingBooking['RoomID'];
            $existingSlotID = $existingBooking['SlotID'];

            // Delete the existing booking and make the slot available
            $sql = "DELETE FROM Bookings WHERE UserID = ? AND RoomID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $uID, $existingRoomID);
            $stmt->execute();

            $sql = "UPDATE Slots SET IsAvailable = TRUE WHERE SlotID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $existingSlotID);
            $stmt->execute();
        }
    }

    // Check if the room and hostel are available
    $sql = "SELECT Available FROM Rooms WHERE RoomID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $roomAvailable = $stmt->get_result()->fetch_assoc()['Available'];

    if (!$roomAvailable) {
        throw new Exception("The selected room is not available.");
    }

    $sql = "SELECT Hostels.Available FROM Rooms
            INNER JOIN Hostels ON Rooms.HostelID = Hostels.HostelID
            WHERE Rooms.RoomID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $hostelAvailable = $stmt->get_result()->fetch_assoc()['Available'];

    if (!$hostelAvailable) {
        throw new Exception("The selected hostel is not available.");
    }

    // Check if any user is blacklisted
    foreach ($allUserIDs as $uID) {
        $sql = "SELECT COUNT(*) as Count FROM Blacklist WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $uID);
        $stmt->execute();
        $userBlacklisted = $stmt->get_result()->fetch_assoc()['Count'] > 0;

        if ($userBlacklisted) {
            throw new Exception("One or more users are blacklisted and cannot book a room.");
        }
    }

    // Check slot availability for the current room
    $sql = "SELECT SlotID FROM Slots WHERE RoomID = ? AND IsAvailable = TRUE ORDER BY SlotNumber";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $availableSlots = $stmt->get_result();

    // Ensure the room has enough available slots
    if ($availableSlots->num_rows < $totalUsers) {
        throw new Exception("Not enough available slots in the selected room.");
    }

    $slots = [];
    while ($row = $availableSlots->fetch_assoc()) {
        $slots[] = $row['SlotID'];
    }

    // Insert new booking for the current user and paired users
    foreach ($allUserIDs as $index => $uID) {
        $slotID = $slots[$index];

        $sql = "INSERT INTO Bookings (UserID, RoomID, SlotID, BookingDate) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $uID, $roomID, $slotID);
        $stmt->execute();

        $sql = "UPDATE Slots SET IsAvailable = FALSE WHERE SlotID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $slotID);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    header("Location: ../templates/affrimamu.php?msg=You have successfully booked the room.");
    exit();
} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    header("Location: ../templates/affrimamu.php?msg=" . urlencode($e->getMessage()));
    exit();
}

$stmt->close();
$conn->close();
?>
