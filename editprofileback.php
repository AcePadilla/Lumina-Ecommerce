<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['email'])) {
    echo "You must be logged in to edit your profile.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientEmail = $_SESSION['email'];
    // Retrieve and sanitize inputs
    $username = $conn->real_escape_string($_POST['username']);
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $address = $conn->real_escape_string($_POST['address']);
    $contactNumber = $conn->real_escape_string($_POST['contactNumber']);

    // Fetch clientid based on email
    $stmt = $conn->prepare("SELECT clientid FROM client WHERE email = ?");
    $stmt->bind_param("s", $clientEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $clientid = $row['clientid'];
    } else {
        echo "User not found.";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Update client table (username)
    $stmt = $conn->prepare("UPDATE client SET username = ? WHERE clientid = ?");
    $stmt->bind_param("si", $username, $clientid);
    $stmt->execute();
    $stmt->close();

    $profilePicUrl = null;
    // Handle profile picture upload if provided
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $uploadDir = 'profilepic/';
        $fileName = time() . "_" . basename($_FILES['profilePicture']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (getimagesize($_FILES['profilePicture']['tmp_name']) !== false) {
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
                $profilePicUrl = $targetPath; // Successfully uploaded the file
            } else {
                echo "There was an error uploading the file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    // Check if user_profiles entry exists for clientid
    $stmt = $conn->prepare("SELECT clientid FROM user_profiles WHERE clientid = ?");
    $stmt->bind_param("i", $clientid);
    $stmt->execute();
    $exists = $stmt->get_result()->num_rows > 0;
    $stmt->close();

    // Construct query based on whether a profile picture was uploaded
    if ($exists) {
        // If user_profiles entry exists, update it
        $query = "UPDATE user_profiles SET fullname = ?, birthday = ?, address = ?, contact_number = ?" . ($profilePicUrl ? ", PpicURL = ?" : "") . " WHERE clientid = ?";
        $stmt = $conn->prepare($query);
        if ($profilePicUrl) {
            $stmt->bind_param("sssssi", $fullName, $birthday, $address, $contactNumber, $profilePicUrl, $clientid);
        } else {
            $stmt->bind_param("ssssi", $fullName, $birthday, $address, $contactNumber, $clientid);
        }
    } else {
        // If no user_profiles entry exists, insert a new one
        $query = "INSERT INTO user_profiles (clientid, fullname, birthday, address, contact_number" . ($profilePicUrl ? ", PpicURL)" : ")") . " VALUES (?, ?, ?, ?, ?" . ($profilePicUrl ? ", ?)" : ")");
        $stmt = $conn->prepare($query);
        if ($profilePicUrl) {
            $stmt->bind_param("isssss", $clientid, $fullName, $birthday, $address, $contactNumber, $profilePicUrl);
        } else {
            $stmt->bind_param("issss", $clientid, $fullName, $birthday, $address, $contactNumber);
        }
    }

    if ($stmt->execute()) {
        echo '<script>alert("Profile updated successfully."); window.location.href="clientprofile.php";</script>';
    } else {
        echo "Error updating profile: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
