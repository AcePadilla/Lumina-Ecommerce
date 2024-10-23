<?php 
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $otp = $_POST['forgot-otp'];
    $new_password = $_POST['new-password'];
    
    // Validate and sanitize input data (You might need additional validation)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $otp = filter_var($otp, FILTER_SANITIZE_STRING);
    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the password in the database
    $sql = "UPDATE client SET password='$hashed_password' WHERE email='$email' ";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="email" class="signup-label">Email</label>
        <input type="email" placeholder="Enter your email" id="signup-email" name="email" class="signup-input" required>

        <label for="new-password" class="signup-label">New Password</label>
        <input type="password" placeholder="New Password" id="new-password" name="new-password" class="newpass-input" required>

        <button type="submit">Reset Password</button>
    </form>
    <form action="">
</body>
</html>


















































<!-- <?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $otp = $_POST['forgot-otp'];
    
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the OTP into the database
    $sql = "INSERT INTO otp_code_forgot (otp) VALUES ('$otp')";

    if ($conn->query($sql) === TRUE) {
        echo "OTP inserted successfully";
    } else {
        echo "Error inserting OTP: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="forgot-otp" class="signup-label">OTP</label>
        <input type="text" placeholder="Enter OTP" id="forgot-otp" name="forgot-otp" class="forgot-input" required>
        <button type="submit">Submit OTP</button>
    </form>
</body>
</html>

 -->
