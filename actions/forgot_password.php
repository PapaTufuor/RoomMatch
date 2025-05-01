<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include '../config/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    // Function to generate a password
    function generatePassword($length = 8) {
        $upper = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $lower = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $numbers = str_shuffle('0123456789');
        $special = str_shuffle('!@#$%^&*()_+?><:{}[]');
        
        // Combine all, shuffle and get a substring of the desired length
        $combined = str_shuffle($upper[0] . $lower[0] . $numbers[0] . $special[0] . substr(str_shuffle($upper . $lower . $numbers . $special), 0, $length - 4));
        return $combined;
    }

    $generated_password = generatePassword();
    $hashed_password = password_hash($generated_password, PASSWORD_BCRYPT);

    if ($result->num_rows > 0) {
        // User exists
        $user = $result->fetch_assoc();

        // Update the user's password in the database
        $update = $conn->prepare("UPDATE Users SET Password = ?, UserType = ? WHERE Email = ?");
        $update->bind_param("sis", $hashed_password, $usertype, $email);
        $usertype = 2; // Set usertype to 2
        $update->execute();
    } else {
        // User doesn't exist, generate password and insert user

        // Insert new user with generated password
        $insert = $conn->prepare("INSERT INTO Users (Email, Password, UserType) VALUES (?, ?, ?)");
        $insert->bind_param("ssi", $email, $hashed_password, $usertype);
        $usertype = 2; // Set usertype to 2
        $insert->execute();
    }

    // Send the email with the new password
    try {
        // Load Composer's autoloader
        require '../vendor/autoload.php';

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cliffco24@gmail.com';
        $mail->Password = 'nzqo jtlf kuau xtus';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('cliffco24@gmail.com', 'RoomRover');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your new password';
        $mail->Body = 'Dear user,<br><br>Your new password is: ' . $generated_password . '<br><br>Thank you for using our services.<br>Best regards,<br>RoomRover';

        // Send the email
        $mail->send();
        header("Location: ../templates/login.php?msg=An email with your new password has been sent.");
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        header("Location: ../templates/forgotpassword.php?msg=Failed to send email.");
    }
    exit();
}
