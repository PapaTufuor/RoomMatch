<?php
include '../config/connection.php';
$userId = $_SESSION['UserID'];


// user_functions.php
function getUserDetails($userId) {
    global $conn; // Use the existing database connection

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT FirstName, LastName, Email, DateOfBirth, Country, Bio, PhoneNumber, ProfileImage FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $dob, $country, $bio, $PhoneNumber, $profileImage );

    // Fetch data
    if ($stmt->fetch()) {
        $userDetails = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'date_of_birth' => $dob,
            'Country' => $country,
            'bio' => $bio,
            'PhoneNumber' => $PhoneNumber,
            'profile_image' => $profileImage
        ];
    } else {
        $userDetails = null;
    }

    $stmt->close();
    return $userDetails;
}



function getUserPreferences($userId) {
    global $conn;

    // Fetch likes
    $result = $conn->query("SELECT LikeText FROM Likes WHERE LikeID IN (SELECT LikeID FROM UserLikes WHERE UserID = $userId)");
    $likes = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch dislikes
    $result = $conn->query("SELECT DislikeText FROM Dislikes WHERE DislikeID IN (SELECT DislikeID FROM UserDislikes WHERE UserID = $userId)");
    $dislikes = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch knows
    $result = $conn->query("SELECT KnowText FROM Knows WHERE KnowID IN (SELECT KnowID FROM UserKnows WHERE UserID = $userId)");
    $knows = $result->fetch_all(MYSQLI_ASSOC);

    return [
        'likes' => $likes,
        'dislikes' => $dislikes,
        'knows' => $knows,
    ];
}

function getRoomDetails($userId) {
    global $conn;

    // Query to get the room details
    $query = "
        SELECT h.HostelName, r.RoomNumber, COUNT(b.UserID) AS NumberOfRoommates
        FROM Bookings b
        JOIN Rooms r ON b.RoomID = r.RoomID
        JOIN Hostels h ON r.HostelID = h.HostelID
        WHERE b.UserID = ?
        GROUP BY r.RoomID, h.HostelName, r.RoomNumber
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function getRoommatesDetails($userId) {
    global $conn;

    // Query to get the roommates of the user
    $query = "
        SELECT u.UserID, u.FirstName, u.LastName, u.Bio, u.PhoneNumber, u.ProfileImage,
               (SELECT GROUP_CONCAT(LikeText) FROM Likes WHERE LikeID IN (SELECT LikeID FROM UserLikes WHERE UserID = u.UserID)) AS Likes,
               (SELECT GROUP_CONCAT(DislikeText) FROM Dislikes WHERE DislikeID IN (SELECT DislikeID FROM UserDislikes WHERE UserID = u.UserID)) AS Dislikes
        FROM Bookings b
        JOIN Rooms r ON b.RoomID = r.RoomID
        JOIN Bookings br ON r.RoomID = br.RoomID AND br.UserID != b.UserID
        JOIN Users u ON br.UserID = u.UserID
        WHERE b.UserID = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $roommates = [];

    while ($row = $result->fetch_assoc()) {
        $roommates[] = [
            'user_id' => $row['UserID'],
            'first_name' => $row['FirstName'],
            'last_name' => $row['LastName'],
            'bio' => $row['Bio'],
            'phone_number' => $row['PhoneNumber'],
            'profile_image' => $row['ProfileImage'],
            'likes' => explode(',', $row['Likes']),
            'dislikes' => explode(',', $row['Dislikes'])
        ];
    }

    $stmt->close();
    return $roommates;
}

?>
