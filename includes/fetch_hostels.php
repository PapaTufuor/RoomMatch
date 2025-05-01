<?php
include '../config/connection.php';

$query = "SELECT HostelID, HostelName FROM hostels";
$result = mysqli_query($conn, $query);

$hostels = [];
while ($row = mysqli_fetch_assoc($result)) {
    $hostels[] = ['id' => $row['HostelID'], 'name' => $row['HostelName']];
}

echo json_encode($hostels);

mysqli_close($conn);
?>
