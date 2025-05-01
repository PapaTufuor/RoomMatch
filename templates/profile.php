<?php
include "../config/core.php";
include "../config/connection.php";
include '../includes/notifications.php';
// Fetch user details
$userDetails = getUserDetails($userId);
checkLogin();
include "../includes/checkUser.php";
checkUserRole($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../public/css/profile.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <link rel="stylesheet" href="../public/css/notification.css">
    <link rel="stylesheet" href="../public/css/preferences.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <link rel="stylesheet" href="../public/css/feedback.css">

    <script src="../public/js/snackbar.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

    <div class="sidebar">
        <nav>
            <!-- <a href="#" class="back"><i class="fas fa-arrow-left"></i></a> -->
            <a href="#" class="back" onclick="window.history.back(); return false;"><i class="fas fa-arrow-left"></i></a>
            <a href="roomates.php"><i class="fas fa-home"></i> Roomates</a>
            <a href="#" id="feedback-button"><i class="fas fa-comment"></i> Feedback</a>
            <a href="../templates/preferencesx.php"><i class="fas fa-cogs"></i> Preferences</a>
            <a href="#" id="notification-link"><i class="fas fa-bell"></i> Notifications</a>
        </nav>
        <div class="logout">
        <a href="../actions/logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Student details</h1>
            <div class="profile-pic">
            <img src="<?php echo '../uploads/' . $userDetails['profile_image']; ?>" alt="Profile Picture">
            </div>
        </div>
        <div class="student-details">
            <div class="profile-pic">
            <img src="<?php echo '../uploads/' . $userDetails['profile_image']; ?>" alt="Profile Picture">
            </div>
            <div class="details">
                <div>
                    <span>Full name</span>
                    <span class="i"><?php echo $userDetails['first_name'] . ' ' . $userDetails['last_name']; ?></span>
                    <a href="#"></a>
                </div>
                <div>
                    <span>Email</span>
                    <span class="i"><?php echo $userDetails['email']; ?></span>
                    <a href="#"></a>
                </div>
                <div>
                    <span>Nationality</span>
                    <span class="i"><?php echo $userDetails['Country']; ?></span>
                    <a href="#"></a>
                </div>
                <div>
                    <span>Date of birth</span>
                    <span class="i"><?php echo $userDetails['date_of_birth']; ?></span>
                    <a href="#"></a>
                </div>
                <!-- Bio Section -->
        <div>
        <span>Bio</span>
                <span class="i"><?php echo htmlspecialchars($userDetails['bio']); ?></span>
                <a href="#" id="edit-bio">Edit</a>
        </div>
            </div>
        </div>
    </div>
    

    <!-- Bio Edit Pop-Up -->
<div class="popup" id="edit-bio-popup">
    <div class="popup-content">
        <span class="close" id="close-bio-popup">&times;</span>
        <form id="bioForm" action="../actions/update_bio.php" method="POST">
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="4" required><?php echo htmlspecialchars($userDetails['bio']); ?></textarea>
            <button type="submit" id="submit-bio">Update Bio</button>
        </form>
    </div>
</div>
      <!-- Notification Popup -->
      <div class="popup" id="notification-popup">
        <div class="popup-content">
            <span class="close" id="close-popup">&times;</span>
            <div class="wrapper">
                <div class="top-bar">
                    <div class="title">
                        <p class="title-text">Notifications</p>
                    </div>
                </div>
                <div class="notifications">
    <?php getNotifications($_SESSION['UserID'], $conn); ?>
</div>
<!-- Bio Edit Popup -->
<div class="popup" id="edit-bio-popup">
    <div class="popup-content">
        <span class="close" id="close-bio-popup">&times;</span>
        <div class="feedback-form">
            <form id="bioForm" action="../actions/update_bio.php" method="POST">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" required></textarea>
                <button type="submit" id="submit-bio">Update Bio</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('edit-bio').onclick = function() {
        document.getElementById('edit-bio-popup').style.display = 'flex';
    };

    document.getElementById('close-bio-popup').onclick = function() {
        document.getElementById('edit-bio-popup').style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == document.getElementById('edit-bio-popup')) {
            document.getElementById('edit-bio-popup').style.display = 'none';
        }
    };
</script>
<script>
    document.getElementById('edit-bio').onclick = function() {
        document.getElementById('edit-bio-popup').style.display = 'flex';
    };

    document.getElementById('close-bio-popup').onclick = function() {
        document.getElementById('edit-bio-popup').style.display = 'none';
    };
</script>
<script>
    function respondToRequest(notificationId, senderId, isAccepted) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../actions/respond_request.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            location.reload(); // Reload the page to update the notifications
        }
    };
    xhr.send("notificationId=" + notificationId + "&senderId=" + senderId + "&isAccepted=" + isAccepted);
}

</script>
            </div>
        </div>
    </div>


    <!-- Feedback Popup -->
<div class="popup" id="feedback-popup">
    <div class="popup-content">
        <span class="close" id="close-feedback-popup">&times;</span>
        <div class="feedback-form">
        <form id="feedbackForm" action="../actions/feedback.php" method="POST">
        <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit" id="submit" >Submit</button>
            </form>
        </div>
    </div>
</div>

    <script src="../public/js/notification.js"></script>
    <script src="../public/js/feedback.js"></script>

</body>
</html>
