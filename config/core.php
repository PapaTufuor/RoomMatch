<?php
// Starting a session

    session_start();

    function checkLogin() {
        if (!isset($_SESSION['UserID'])) {
            header("Location: ../templates/login.php");
            exit();
        }
    }


// Check if UserID is set in the session


    $user_id = ($_SESSION['UserID']);

    // Debugging: Print the UserID value from the session

    $userID = $_SESSION['UserID'];

    // Debugging: Print the UserID value

    // $userID = $_SESSION['UserID']


    
 