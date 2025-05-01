<?php
include '../config/core.php';
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data
    $query = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['Password'])) {
            echo "User ID: " . $user['UserID'] . "<br>";

            $_SESSION['UserID'] = $user['UserID'];
            print_r($user);

            // Debugging: Check if UserID is stored in the session
            if (isset($_SESSION['UserID'])) {
                echo "Session UserID is set: " . $_SESSION['UserID'] . "<br>";
            } else {
                echo "Failed to set Session UserID<br>";
            }

            // Check if the user is an admin
            if ($user['UserType'] == '1') {
                // Redirect to admin page
                header("Location: ../templates/admin.php?msg=Welcome, Admin.");
            } else {
                // Check if other user details are set to determine if it's a new user
                if (empty($user['FirstName']) || empty($user['LastName']) || empty($user['DateOfBirth'])) {
                    // Redirect to preferences page for new user
                    header("Location: ../templates/preferences.php?msg=Please set your preferences.");
                } else {
                    // Redirect to home page for existing user
                    header("Location: ../templates/home.php?msg=Login successful.");
                }
            }
        } else {
            header("Location: ../templates/login.php?msg=Invalid password.");
        }
    } else {
        header("Location: ../templates/login.php?msg=No account found with that email.");
    }
    exit();
}
