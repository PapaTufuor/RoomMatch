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
		/* CSS for the Search Box */
		.search-container {
			margin: 20px auto;
			max-width: 500px;
			position: relative;
		}

		.search-container input[type="text"] {
			width: 100%;
			padding: 10px 20px;
			border-radius: 20px;
			border: 1px solid #ccc;
			font-size: 16px;
			box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
		}

		.search-container input[type="text"]::placeholder {
			color: #888;
		}

		.search-container i {
			position: absolute;
			top: 50%;
			right: 20px;
			transform: translateY(-50%);
			color: #888;
		}

		/* CSS for Content Items */
		.content-item {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 10px;
			margin: 10px 0;
			background-color: #f5f5f5;
			border-radius: 8px;
		}

		.content-item .item-name {
			flex: 1;
		}

		.content-item button {
			margin-left: 10px;
			padding: 5px 10px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}

		.content-item button.block-btn {
			background-color: #ff4d4d;
			color: white;
		}

		.content-item button.unblock-btn {
			background-color: #4caf50;
			color: white;
		}

/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000; /* Ensures modal is on top of other elements */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Slightly darker background */
    padding-top: 60px;
}

.modal-content {
    background-color: #fff;
    margin: 5% auto; /* Centered horizontally */
    padding: 20px;
    border-radius: 8px;
    width: 80%; /* Adjust width as needed */
    max-width: 600px; /* Limit maximum width for large screens */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Add shadow for better visibility */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000; /* Change color on hover/focus */
    text-decoration: none;
    cursor: pointer;
}

textarea {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Ensures padding does not affect width */
}

button.block-btn {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

button.block-btn:hover {
    background-color: #e60000; /* Darker shade on hover */
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
			<!-- <li>
				<a href="#"><i class='bx bxs-inbox icon' ></i> Elements <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="#">Alert</a></li>
					<li><a href="#">Badges</a></li>
					<li><a href="#">Breadcrumbs</a></li>
					<li><a href="#">Button</a></li>
				</ul>
			</li>
			<li><a href="#"><i class='bx bxs-chart icon' ></i> Charts</a></li> -->
			<li><a href="add_room.php"><i class='bx bxs-widget icon' ></i> Add Room</a></li>
			<li class="divider" data-text="table and forms">Block & Report</li>
			<li><a href="#"><i class='bx bx-table icon' ></i> Block Users</a></li>
			<li>
				<a href="reports.php"><i class='bx bxs-notepad icon' ></i> Reports</a>
				<!-- <ul class="side-dropdown">
					<li><a href="#">Basic</a></li>
					<li><a href="#">Select</a></li>
					<li><a href="#">Checkbox</a></li>
					<li><a href="#">Radio</a></li>
				</ul> -->
			</li>
		</ul>
		<div class="ads">
			<div class="wrapper">
				<a href="#" class="btn-upgrade">Logout</a>
				<!-- <p>Become a <span>PRO</span> member and enjoy <span>All Features</span></p> -->
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
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="search-bar" placeholder="Search..." onkeyup="searchContent()">
                <i class='bx bx-search'></i>
            </div>

            <!-- Example Content -->
            <div id="content-list">
				<?php include '../actions/fetch_users.php'; ?>
                <!-- <div class="content-item">
                    <span class="item-name">Dashboard Overview</span>
                    <button class="block-btn">Block</button>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="content-item">
                    <span class="item-name">User Statistics</span>
                    <button class="block-btn">Block</button>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="content-item">
                    <span class="item-name">Room Management</span>
                    <button class="block-btn">Block</button>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="content-item">
                    <span class="item-name">Block Users</span>
                    <button class="block-btn">Block</button>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="content-item">
                    <span class="item-name">Financial Reports</span>
                    <button class="block-btn">Block</button>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="content-item">
                    <span class="item-name">System Settings</span>
                    <button class="block-btn">Block</button>
                    <button class="unblock-btn">Unblock</button>
                </div> -->
            </div>
        </main>

		<!-- Block User Modal -->
			<div id="block-modal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<h2>Block User</h2>
					<form id="block-form">
						<input type="hidden" id="block-user-id">
						<textarea id="block-reason" placeholder="Enter the reason for blocking..." required></textarea>
						<button type="submit" class="block-btn">Submit</button>
					</form>
				</div>
			</div>


		<script>
			function searchContent() {
				// Declare variables
				var input, filter, contentList, items, item, i, txtValue;
				input = document.getElementById('search-bar');
				filter = input.value.toLowerCase();
				contentList = document.getElementById('content-list');
				items = contentList.getElementsByClassName('content-item');

				// Loop through all content items and hide those that don't match the search query
				for (i = 0; i < items.length; i++) {
					item = items[i].getElementsByClassName('item-name')[0];
					txtValue = item.textContent || item.innerText;
					if (txtValue.toLowerCase().indexOf(filter) > -1) {
						items[i].style.display = "flex";
					} else {
						items[i].style.display = "none";
					}
				}
			}
		</script>

<script>
    function openBlockModal(userId) {
        document.getElementById('block-user-id').value = userId;
        document.getElementById('block-modal').style.display = 'block';
    }

    function closeBlockModal() {
        document.getElementById('block-modal').style.display = 'none';
    }

    document.querySelector('.modal .close').onclick = closeBlockModal;

    window.onclick = function(event) {
        if (event.target == document.getElementById('block-modal')) {
            closeBlockModal();
        }
    }

    document.getElementById('block-form').onsubmit = function(event) {
        event.preventDefault();

        var userId = document.getElementById('block-user-id').value;
        var reason = document.getElementById('block-reason').value;

        if (confirm('Are you sure you want to block this user?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../actions/block_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('User has been blocked successfully.');
                    closeBlockModal();
                    // Optionally, refresh the user list or update the UI
                } else {
                    alert('Error blocking the user.');
                }
            };
            xhr.send('user_id=' + encodeURIComponent(userId) + '&reason=' + encodeURIComponent(reason));
        }
    };
</script>

	<Script>
		function unblockUser(userId) {
			if (confirm('Are you sure you want to unblock this user?')) {
				var xhr = new XMLHttpRequest();
				xhr.open('POST', '../actions/unblock_user.php', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					if (xhr.status === 200) {
						alert('User has been unblocked successfully.');
						// Optionally, refresh the user list or update the UI
					} else {
						alert('Error unblocking the user.');
					}
				};
				xhr.send('user_id=' + encodeURIComponent(userId));
			}
		}	
	</Script>


    </body>
</html>
