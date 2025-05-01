<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    
    <title>Login</title>
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

    <div class="login-box">
        <div class="image-container">
            <img src="https://instructure-uploads-eu.s3.eu-west-1.amazonaws.com/account_153630000000000001/attachments/659/ashesiLogo%20long.png" alt="">
        </div>
        <div class="login-header">
            <header>Login</header>
        </div>
        <form id="loginForm" action="../actions/login_action.php" method="POST" onsubmit="return validateForm()">
            <div class="input-box">
                <input type="email" id="email" class="input-field" name="email" placeholder="Email" autocomplete="on" required pattern="[a-zA-Z0-9._%+-]+@ashesi\.edu\.gh" title="Email must end with @ashesi.edu.gh">
            </div>
            <div class="input-box">
                <input type="password" id="password" class="input-field" name="password" placeholder="Password" autocomplete="on" required pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" title="Password must be at least 8 characters long and include at least one number and one letter (uppercase or lowercase)">
            </div>
            <div class="forgot">
                <section>
                    <input type="checkbox" id="check">
                    <label for="check">Remember me</label>
                </section>
                <section>
                    <a href="forgotpassword.php">Forgot password</a>
                </section>
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit" type="submit">Sign In</button>
            </div>
        </form>
    </div>
    
    <script>
        function validateForm() {
            var email = document.getElementById('email').value;
            var emailPattern = /@ashesi\.edu\.gh$/;
            var snackbar = document.getElementById('snackbar');

            if (!emailPattern.test(email)) {
                snackbar.textContent = "Email must end with @ashesi.edu.gh";
                snackbar.className = "snackbar show";
                setTimeout(function() { snackbar.className = snackbar.className.replace("show", ""); }, 3000);
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>
</html>
