<?php


function checkUserRole($conn) {
        // Check if the user is logged in
        if (!isset($_SESSION['UserID'])) {
            // Redirect to login page if not logged in
            header("Location: ../templates/login.php?msg=Please log in.");
            exit();
        }
    
        // Fetch the user's role from the database
        $userID = $_SESSION['UserID'];
        $query = $conn->prepare("SELECT UserType FROM Users WHERE UserID = ?");
        $query->bind_param("i", $userID);
        $query->execute();
        $result = $query->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Check if the user is an admin
            if ($user['UserType'] == '1') {
                // Redirect to admin page if the user is an admin
                header("Location: ../templates/admin.php?msg=Welcome, Admin.");
                exit();
            }
        } else {
            // Redirect to login page if user not found
            header("Location: ../templates/login.php?msg=User not found.");
            exit();
        }
    }
    