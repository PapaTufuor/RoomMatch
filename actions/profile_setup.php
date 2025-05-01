<?php
include '../config/core.php';
include '../config/connection.php';

// Ensure the session is started


$userId = $_SESSION['UserID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $firstname = trim($_POST['FirstName']);
    $lastname = trim($_POST['LastName']);
    $dob = trim($_POST['DateOfBirth']);
    $gender = trim($_POST['Gender']);
    $phone = trim($_POST['PhoneNumber']);
    $country = trim($_POST['Country']);
    $disabilityStatus = isset($_POST['DisabilityStatus']) ? 1 : 0;
    
    // Debugging: Print input values
    echo "Firstname: $firstname<br>";
    echo "Lastname: $lastname<br>";
    echo "DateOfBirth: $dob<br>";
    echo "Gender: $gender<br>";
    echo "PhoneNumber: $phone<br>";
    echo "DisabilityStatus: $disabilityStatus<br>";

    $errors = [];

    // Validate form inputs
    if (empty($firstname) || !preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
        $errors[] = "Invalid first name";
    }

    if (empty($lastname) || !preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
        $errors[] = "Invalid last name";
    }

    if (empty($dob) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
        $errors[] = "Invalid date of birth";
    }

    if (empty($gender) || !in_array($gender, ['male', 'female', 'other'])) {
        $errors[] = "Invalid gender";
    }

    if (empty($phone) || !preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors[] = "Invalid phone number";
    }

    if (!empty($errors)) {
        // Print error messages
        echo "Errors: " . implode(", ", $errors) . "<br>";
        header("Location: ../templates/profile_setup.php?msg=" . urlencode(implode(", ", $errors)));
        exit();
    }

    // Handle file upload
    $profileImage = NULL;
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == 0) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["imageUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Debugging: Print file upload details
        echo "Target File: $targetFile<br>";
        echo "File Size: " . $_FILES["imageUpload"]["size"] . "<br>";
        echo "File Error: " . $_FILES["imageUpload"]["error"] . "<br>";
        echo "File Type: $imageFileType<br>";

        // Check file size (5MB max)
        if ($_FILES["imageUpload"]["size"] > 5000000) {
            header("Location: ../templates/profile_setup.php?msg=Sorry, your file is too large.");
            exit();
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: ../templates/profile_setup.php?msg=Sorry, only JPG, JPEG, & PNG files are allowed.");
            exit();
        }

        // Move file to target directory
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFile)) {
            $profileImage = $targetFile;
        } else {
            echo "Error moving file<br>";
            header("Location: ../templates/profile_setup.php?msg=Sorry, there was an error uploading your file.");
            exit();
        }
    } else {
        echo "No file uploaded or error occurred<br>";
    }

    // Debugging: Print the final profile image path
    echo "Profile Image Path: " . ($profileImage ?: 'NULL') . "<br>";

    // Update user profile
    $query = $conn->prepare("UPDATE Users SET FirstName = ?, LastName = ?, DateOfBirth = ?, Gender = ?, PhoneNumber = ?, DisabilityStatus = ?, Country = ?, ProfileImage = ? WHERE UserID = ?");
    $query->bind_param("ssssssssi", $firstname, $lastname, $dob, $gender, $phone, $disabilityStatus,$country, $profileImage, $userId);
    
    // Debugging: Print SQL query execution status
    if ($query->execute()) {
        echo "Profile updated successfully.<br>";
        header("Location: ../templates/home.php?msg=Profile updated successfully.");
    } else {
        echo "Failed to update profile: " . $query->error . "<br>";
        header("Location: ../templates/profile_setup.php?msg=Failed to update profile. Please try again.");
    }
    exit();
}
