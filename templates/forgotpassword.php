<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <script src="../public/js/snackbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Forgot Password</title>
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
        <div class="login-header">
            <header>Forgot Password</header>
        </div>
        <form id="forgotPasswordForm" action="../actions/forgot_password.php" method="POST" onsubmit="return validateForgotPasswordForm()">
            <div class="input-box">
                <input type="email" id="email" class="input-field" name="email" placeholder="Enter your email" autocomplete="off" required pattern="[a-zA-Z0-9._%+-]+@ashesi\.edu\.gh" title="Email must end with @ashesi.edu.gh">
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit" type="submit">Send Password</button>
            </div>
        </form>
    </div>

    <script>
        function validateForgotPasswordForm() {
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
