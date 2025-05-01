<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to get the total number of users
function getTotalUsers($conn) {
    $sql = "SELECT COUNT(*) AS total_users FROM Users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_users'];
    }
    return 0;
}

// Function to get the total number of hostels
function getTotalHostels($conn) {
    $sql = "SELECT COUNT(*) AS total_hostels FROM Hostels";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_hostels'];
    }
    return 0;
}

// Function to get the total number of rooms
function getTotalRooms($conn) {
    $sql = "SELECT COUNT(*) AS total_rooms FROM Rooms";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_rooms'];
    }
    return 0;
}

// Function to get the total number of bookings
function getTotalBookings($conn) {
    $sql = "SELECT COUNT(*) AS total_bookings FROM Bookings";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_bookings'];
    }
    return 0;
}

// Function to get the number of available slots
function getAvailableSlots($conn) {
    $sql = "SELECT COUNT(*) AS available_slots FROM Slots WHERE IsAvailable = TRUE";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['available_slots'];
    }
    return 0;
}

// Function to get all statistics
function getStats($conn) {
    $stats = [];
    $stats['total_users'] = getTotalUsers($conn);
    $stats['total_hostels'] = getTotalHostels($conn);
    $stats['total_rooms'] = getTotalRooms($conn);
    $stats['total_bookings'] = getTotalBookings($conn);
    $stats['available_slots'] = getAvailableSlots($conn);
    
    return $stats;
}

?>
