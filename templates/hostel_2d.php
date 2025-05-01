<?php
include "../includes/room_selection_2d.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Times New Roman:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../public/css/roomates.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
	

	<title>Hostels</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body>
<?php if (isset($_GET['msg'])): ?>
        <div id="snackbar"><?php echo htmlspecialchars($_GET['msg']); ?></div>
        <script>
            window.onload = function() {
                var snackbar = document.getElementById('snackbar');
                snackbar.className = "show";
                setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
            };
        </script>
    <?php endif; ?>
    
    <!-- Snackbar for validation errors -->
    <div id="snackbar" class="snackbar"></div>


<div class="wrapper">
    <div class="band">
        <h1>HOSTEL 2D'S ROOMS</h1>
    </div>
        <?php displayRooms(6); ?>
    </div>

    <script src="../public/js/roomates.js"></script>
</body>
</html>