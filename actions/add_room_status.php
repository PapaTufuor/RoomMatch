<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include database connection
include '../config/connection.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomID = $_POST['room-select'];
    $roomStatus = $_POST['room-status'] === 'available' ? true : false; // true or false

    // Update the room availability in the database
    $query = "UPDATE Rooms SET Available = ? WHERE RoomID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $roomStatus, $roomID); // 'i' for integer
    
    if ($stmt->execute()) {
        $msg = "Room status updated successfully.";
        $status = "success";
    } else {
        $msg = "Error updating room status: " . $conn->error;
        $status = "error";
    }

    $stmt->close();
    $conn->close();

    // Redirect with feedback message
    header("Location: ../templates/add_room.php?status=$status&msg=" . urlencode($msg));
    exit();
}
?>
