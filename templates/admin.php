<?php
// Include the database connection
include '../config/connection.php';

// Include the statistics functions
include '../includes/get_all_stats.php';

// Fetch statistics
$totalUsers = getTotalUsers($conn);
$totalHostels = getTotalHostels($conn);
$totalRooms = getTotalRooms($conn);
$totalBookings = getTotalBookings($conn);
$availableSlots = getAvailableSlots($conn);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
	<link rel="stylesheet" href="../public/css/admin.css">

	<title>AdminSite</title>
</head>
<body>

	
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><i class='bx bxs-smile icon'></i> Roomrover</a>
		<ul class="side-menu">
			<li><a href="admin.php" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<li><a href="add_room.php"><i class='bx bxs-widget icon' ></i> Add Room</a></li>
			<li class="divider" data-text="table and forms">Block & Report</li>
			<li><a href="blocked_users.php"><i class='bx bx-block icon' ></i> Block Users</a></li>
			<li><a href="reports.php"><i class='bx bxs-notepad icon' ></i> Reports</a></li>
		</ul>
		<div class="ads">
			<div class="wrapper">
				<a href="#" class="btn-upgrade">Logout</a>
			</div>
		</div>
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#">
				<div class="form-group">
					<input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i>
				</div>
			</form>
			<a href="#" class="nav-link">
				<i class='bx bxs-bell icon' ></i>
				<span class="badge">5</span>
			</a>
			<a href="#" class="nav-link">
				<i class='bx bxs-message-square-dots icon' ></i>
				<span class="badge">8</span>
			</a>
			<span class="divider"></span>
			<div class="profile">
				<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
				<ul class="profile-link">
					<li><a href="#"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
					<li><a href="#"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Home</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Dashboard</a></li>
			</ul>
			<div class="info-data">
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalUsers; ?></h2>
							<p>Users</p>
						</div>
						<i class='bx bx-user icon' ></i>
					</div>
					<span class="progress" data-value="40%"></span>
					<span class="label">40%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalRooms; ?></h2>
							<p>Rooms</p>
						</div>
						<i class='bx bx-home icon' ></i>
					</div>
					<span class="progress" data-value="60%"></span>
					<span class="label">60%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalHostels; ?></h2>
							<p>Hostels</p>
						</div>
						<i class='bx bx-building icon' ></i>
					</div>
					<span class="progress" data-value="60%"></span>
					<span class="label">60%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $availableSlots; ?></h2>
							<p>Available Slots</p>
						</div>
						<i class='bx bx-calendar icon' ></i>
					</div>
					<span class="progress" data-value="30%"></span>
					<span class="label">30%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalBookings; ?></h2>
							<p>Total Bookings</p>
						</div>
						<i class='bx bx-book icon' ></i>
					</div>
					<span class="progress" data-value="80%"></span>
					<span class="label">80%</span>
				</div>
			</div>
			
			<div class="data">
				<div class="content-data">
					<div class="head">
						<h3>Stats</h3>
					</div>
					<div class="chart">
						<canvas id="myChart" style="width:100%;max-width:700px"></canvas>
					</div>
				</div>

				<div class="content-data">
					<div class="head">
						<h3>Set Booking Time</h3>
						<div class="menu">
							<i class='bx bx-dots-horizontal-rounded icon'></i>
							<ul class="menu-link">
								<li><a href="#">Edit</a></li>
								<li><a href="#">Save</a></li>
								<li><a href="#">Remove</a></li>
							</ul>
						</div>
					</div>
					<form action="#" id="booking-form">
						<div class="form-group">
							<label for="start-time">Start Time:</label>
							<input type="datetime-local" id="start-time" name="start-time" required>
						</div>
						<div class="form-group">
							<label for="end-time">End Time:</label>
							<input type="datetime-local" id="end-time" name="end-time" required>
						</div>
						<div class="form-group">
							<button type="submit" class="btn-set">Set</button>
						</div>
					</form>
				</div>
				<style>
					/* Updated CSS for the Booking Time Form */
					#booking-form {
						display: flex;
						flex-direction: column;
						gap: 15px;
					}

					#booking-form .form-group {
						display: flex;
						align-items: center;
						justify-content: space-between;
					}

					#booking-form label {
						flex-basis: 30%;
						font-weight: bold;
						color: #333;
					}

					#booking-form input[type="datetime-local"] {
						flex-basis: 65%;
						padding: 8px;
						border: 1px solid #ccc;
						border-radius: 5px;
						font-size: 16px;
					}

					#booking-form .btn-set {
						width: 100%;
						padding: 10px;
						border: none;
						border-radius: 5px;
						background-color: #923d41;
						color: white;
						font-size: 18px;
						cursor: pointer;
					}

					#booking-form .btn-set:hover {
						background-color: #333;
					}
				</style>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<!-- Scripts -->
	<script src="../public/js/admin.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

	<script>
		// Data from PHP
		const labels = <?php echo json_encode(["Users", "Rooms", "Hostels", "Available Slots", "Total Bookings"]); ?>;
		const data = <?php echo json_encode([$totalUsers, $totalRooms, $totalHostels, $availableSlots, $totalBookings]); ?>;

		new Chart("myChart", {
			type: "bar",
			data: {
				labels: labels,
				datasets: [{
					backgroundColor: ["red", "green", "blue", "orange", "brown"],
					data: data
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>
</body>
</html>
