<?php
include "../config/connection.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../config/core.php";
include "../includes/checkUser.php";
include "../includes/userfunctions.php";
checkUserRole($conn);
checkLogin();
$roommates = getRoommatesDetails($userId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../public/css/roomates.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <title>Roommates</title>

</head>
<body>
<div class="wrapper">
    <div class="band">
        <h1>YOUR ROOM MEMBERS</h1>
    </div>

    <?php if (!empty($roommates)): ?>
        <?php foreach ($roommates as $index => $roommate): ?>
            <div class="card">
                <input type="checkbox" id="card<?= $index + 1 ?>" class="more" aria-hidden="true">
                <div class="content">
                    <div class="front" style="background-image: url('../assets/images/<?= !empty($roommate['ProfileImage']) ? htmlspecialchars($roommate['ProfileImage']) : 'default-profile.jpg' ?>');">
                        <div class="inner">
                            <h2><?= htmlspecialchars(!empty($roommate['FirstName']) ? $roommate['FirstName'] : 'No Name Available') ?></h2>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <label for="card<?= $index + 1 ?>" class="button" aria-hidden="true">
                                Details
                            </label>
                        </div>
                    </div>
                    <div class="back">
                        <div class="inner">
                            <div class="info">
                                <span><?= htmlspecialchars(!empty($roommate['RoomNumber']) ? $roommate['RoomNumber'] : 'No Room Number Available') ?></span>
                                <div class="icon">
                                    <i class="fas fa-door-open"></i>
                                    <span>Room Number</span>
                                </div>
                            </div>
                            <div class="info">
                                <span><?= htmlspecialchars(!empty($roommate['HostelName']) ? $roommate['HostelName'] : 'No Hostel Name Available') ?></span>
                                <div class="icon">
                                    <i class="fas fa-building"></i>
                                    <span>Hostel</span>
                                </div>
                            </div>
                            
                            <label for="card<?= $index + 1 ?>" class="button return" aria-hidden="true">
                                <i class="fas fa-arrow-left">Back</i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No roommates found.</p>
    <?php endif; ?>
</div>

<script src="../public/js/roomates.js"></script>
</body>
</html>
