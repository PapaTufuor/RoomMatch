<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include database connection
include '../config/connection.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hostelID = $_POST['hostel-select'];
    $hostelStatus = $_POST['hostel-status'] === 'available' ? true : false; // true or false

    // Update the hostel availability in the database
    $query = "UPDATE Hostels SET Available = ? WHERE HostelID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $hostelStatus, $hostelID); // 'i' for integer
    
    if ($stmt->execute()) {
        $msg = "Hostel status updated successfully.";
        $status = "success";
    } else {
        $msg = "Error updating hostel status: " . $conn->error;
        $status = "error";
    }

    $stmt->close();
    $conn->close();

    // Redirect with feedback message
    header("Location: ../templates/add_room.php?status=$status&msg=" . urlencode($msg));
    exit();
}
?>
