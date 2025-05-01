<?php
include '../config/connection.php';

$sql = "SELECT UserID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userID = $row["UserID"];
        $fullName = $row["FullName"];
        echo '<div class="content-item">';
        echo '<span class="item-name">' . htmlspecialchars($fullName) . '</span>';
        echo '<button class="block-btn" onclick="openBlockModal(' . $userID . ')">Block</button>';
        echo '<button class="unblock-btn" onclick="unblockUser(' . $userID . ')">Unblock</button>';
        echo '</div>';
        //    <button class="unblock-btn" onclick="unblockUser(userId)">Unblock</button>

    }
} else {
    echo 'No users found.';
}

$conn->close();
?>
