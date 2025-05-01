<?php
include '../includes/bio_function.php';
$profileUserId = isset($_GET['user_id']) ? intval($_GET['user_id']) : null; // Get the profile user ID from the URL
$userDetails = getUserDetails($userId);
// Get user preferences
$preferences = getUserPreferences($profileUserId);
$likes = $preferences['likes'];
$dislikes = $preferences['dislikes'];
$knows = $preferences['knows'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="../public/css/bio.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <title>Bio</title>
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
    <main class="wrapper">
       <section class="featured-box" id="home">
          <div class="featured-text">
            <div class="featured-text-card">
            </div>
            <div class="featured-name">
                <p>I'm <span ><?php echo $fullName; ?></span></p>
            </div>
            <div class="featured-text-info">
                <p><?php echo $userDetails['bio']; ?>
                
                </p>
            </div>
            <div class="featured-text-btn">
            <form action="../actions/request_roomate.php" method="POST">
    <input type="hidden" name="profileUserId" value="<?php echo $profileUserId; ?>">
    <button type="submit" class="btn blue-btn">Request As Roommate</button>
</form>


</div>

            
          </div>
          <div class="featured-image">
            <div class="image">
            <img src="<?php echo $profileImage; ?>" alt="<?php echo $fullName; ?>">
            </div>
          </div>
          <div class="scroll-icon-box">
            <a href="#about" class="scroll-btn">
                <i class="uil uil-mouse-alt"></i>
                <p>Know more</p>
            </a>
          </div>

       </section>
       <!-- -------------- ABOUT BOX ---------------- -->
       <section class="section" id="about">
          <div class="top-header">
            <h1>About Me</h1>
          </div>
          <div class="row">
            <div class="col">
                <div class="about-info">
                    <h3>My introduction</h3>
                    <p>                <p><?php echo $userDetails['bio']; ?>

                    </p>
                </div>
            </div>
            <div class="col">
                <div class="skills-box">
                    <div class="skills-header">
                        <h3>Likes</h3>
                    </div>
                    <div class="skills-list">
                        <?php if (empty($likes)): ?>
                            <p>No likes set.</p>
                        <?php else: ?>
                            <?php foreach ($likes as $like): ?>
                                <span><?php echo htmlspecialchars($like['LikeText']); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="skills-box">
                    <div class="skills-header">
                        <h3>Dislikes</h3>
                    </div>
                    <div class="skills-list">
                        <?php if (empty($dislikes)): ?>
                            <p>No dislikes set.</p>
                        <?php else: ?>
                            <?php foreach ($dislikes as $dislike): ?>
                                <span><?php echo htmlspecialchars($dislike['DislikeText']); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="skills-box">
                    <div class="skills-header">
                        <h3>Know</h3>
                    </div>
                    <div class="skills-list">
                        <?php if (empty($knows)): ?>
                            <p>No knows set.</p>
                        <?php else: ?>
                            <?php foreach ($knows as $know): ?>
                                <span><?php echo htmlspecialchars($know['KnowText']); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
          </div>
       </section>

       <!-- -------------- CONTACT BOX ---------------- -->

       <section class="section" id="contact">
          <div class="top-header">
            <h1>Get in touch</h1>
            <span>Do you want to be my roomate? , Send a request and drop a short reason</span>
          </div>
          <div class="row">
             <div class="col">
                <div class="contact-info">
                    <h2>Find Me <i class="uil uil-corner-right-down"></i></h2>
                    <p><i class="uil uil-envelope"></i> Email: <?php echo $email; ?></p>
                    <p><i class="uil uil-phone"></i> Tel: <?php echo $userDetails['PhoneNumber']; ?></p>
                    <p><i class="uil uil-message"></i> Ashesi</p>
                </div>
             </div>
             
          </div>
       </section>

    </main>
    </div>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../public/js/bio.js"></script>
</body>
</html>