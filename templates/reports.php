<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../public/css/admin.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
	<title>AdminSite</title>
	<style>
		/* Additional CSS for the Table */
		table {
			width: 100%;
			border-collapse: collapse;
			margin: 20px 0;
			font-size: 16px;
			text-align: left;
		}

		th, td {
			padding: 12px;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #f4f4f4;
			font-weight: bold;
		}

		tr:nth-child(even) {
			background-color: #f9f9f9;
		}

		tr:hover {
			background-color: #f1f1f1;
		}
	</style>
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
			<li><a href="blocked_users.php"><i class='bx bx-table icon' ></i> Block Users</a></li>
			<li>
				<a href="#"><i class='bx bxs-notepad icon' ></i> Reports</a>
			</li>
		</ul>
		<div class="ads">
			<div class="wrapper">
				<a href="../actions/logout.php" class="btn-upgrade">Logout</a>
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
				<!-- <div class="form-group">
					<input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i>
				</div> -->
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
			<table>
				<thead>
					<tr>
						<th>User</th>
						<th>Report Message</th>
					</tr>
				</thead>
				<tbody>
					<?php
					include '../config/connection.php'; // Update the path to your database connection file

					// Query to fetch feedback
					$sql = "SELECT Feedback.FeedbackText, CONCAT(Users.FirstName, ' ', Users.LastName) AS UserName 
					        FROM Feedback 
					        INNER JOIN Users ON Feedback.UserID = Users.UserID";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
					    // Output data of each row
					    while($row = $result->fetch_assoc()) {
					        echo "<tr>";
					        echo "<td>" . htmlspecialchars($row['UserName']) . "</td>";
					        echo "<td>" . htmlspecialchars($row['FeedbackText']) . "</td>";
					        echo "</tr>";
					    }
					} else {
					    echo "<tr><td colspan='2'>No feedback reports found.</td></tr>";
					}

					$conn->close();
					?>
				</tbody>
			</table>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../public/js/admin.js"></script>
</body>
</html>
