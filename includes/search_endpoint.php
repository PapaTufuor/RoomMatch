
<?php
include '../config/connection.php';

$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($searchQuery)) {
    $stmt = $conn->prepare("
        SELECT UserID, FirstName, LastName 
        FROM Users 
        WHERE FirstName LIKE ? OR LastName LIKE ?
        LIMIT 10
    ");
    
    $searchTerm = '%' . $searchQuery . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'id' => $row['UserID'],
            'name' => $row['FirstName'] . ' ' . $row['LastName']
        ];
    }

    echo json_encode($users);
    $stmt->close();
}
?>
