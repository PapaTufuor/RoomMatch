<?php
// Include your database connection file here
include '../config/connection.php'; // Adjust the path as necessary

if (isset($_POST['hostel_id'])) {
    $hostelId = $_POST['hostel_id'];

    // Query to select RoomID and RoomNumber based on HostelID
    $query = "SELECT RoomID, RoomNumber FROM Rooms WHERE HostelID = ?";
    
    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hostelId);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $rooms = [];
    
    // Fetch the results and store them in an array
    while ($row = $result->fetch_assoc()) {
        $rooms[] = [
            'id' => $row['RoomID'],
            'room_number' => $row['RoomNumber'] // Changed from 'name' to 'room_number'
        ];
    }
    
    // Return the result as a JSON array
    echo json_encode($rooms);
    
    $stmt->close();
    $conn->close();
}
?>
