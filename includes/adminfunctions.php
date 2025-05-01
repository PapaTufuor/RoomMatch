<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include '../config/connection.php';

// Function to add a new hostel
function addHostel($conn, $hostelName) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Hostels (HostelName) VALUES (?)");
    $stmt->bind_param("s", $hostelName);

    if ($stmt->execute()) {
        echo "New hostel created successfully: $hostelName<br>";
        return $stmt->insert_id; // Return the ID of the newly created hostel
    } else {
        echo "Error: " . $stmt->error . "<br>";
        return false;
    }

    $stmt->close();
}

// Function to add a new room to a hostel
function addRoom($conn, $hostelID, $roomNumber, $capacity, $roomImage) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Rooms (HostelID, RoomNumber, Capacity, RoomImage) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $hostelID, $roomNumber, $capacity, $roomImage);

    if ($stmt->execute()) {
        echo "New room created successfully: Room $roomNumber in Hostel ID $hostelID<br>";
        return $stmt->insert_id; // Return the ID of the newly created room
    } else {
        echo "Error: " . $stmt->error . "<br>";
        return false;
    }

    $stmt->close();
}

// Function to add slots for a room
function addRoomSlots($conn, $roomID, $slotCount) {
    $stmt = $conn->prepare("INSERT INTO Slots (RoomID, SlotNumber, IsAvailable) VALUES (?, ?, TRUE)");

    for ($i = 1; $i <= $slotCount; $i++) {
        $stmt->bind_param("ii", $roomID, $i);

        if ($stmt->execute()) {
            echo "Slot $i added successfully to Room ID $roomID<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    $stmt->close();
}

// Example usage
// Assuming the connection to the database ($conn) has already been established
$hostelName = "Hostel H"; // Example hostel name
$roomNumber = "501"; // Example room number
$capacity = 4; // Example room capacity
$roomImage = "../templates/img/banner/banner.png"; // Example room image path

// Add a new hostel
$hostelID = addHostel($conn, $hostelName);
if ($hostelID) {
    // Add a new room to the newly created hostel
    $roomID = addRoom($conn, $hostelID, $roomNumber, $capacity, $roomImage);
    if ($roomID) {
        // Add slots to the newly created room
        addRoomSlots($conn, $roomID, $capacity);
    }
}

// Close the database connection
$conn->close();
?>
