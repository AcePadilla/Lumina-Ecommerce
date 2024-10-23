<?php
session_start(); // Start the session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload file

// Function to check if email exists in the database
function isEmailExists($email) {
    // Your database connection code here
    // Replace 'your_database_host', 'your_database_name', 'your_database_user', and 'your_database_password' with your actual database credentials
    $conn = new mysqli('localhost', 'root', '', 'jra');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if email exists in the database
    if ($result->num_rows > 0) {
        // Email exists
        return true;
    } else {
        // Email does not exist
        return false;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted Gmail address
    $gmail = $_POST['gmail'];

    // Check if email exists in the database
    if (isEmailExists($gmail)) {
        // Instantiate PHPMailer
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jmjonatas4@gmail.com'; // Your Gmail address
            $mail->Password   = 'fikc fvzd xtti qpjd'; // Your Gmail password or app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Sender and recipient details
            $mail->setFrom('jmjonatas4@gmail.com', 'lumina');
            $mail->addAddress($gmail, 'Client');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body    = '<p>Click the link below to reset your password:</p><br><a href="http://localhost/nonuser/forgotpassword.php">Reset Password</a>';

            // Send email
            $mail->send();

            // Terminate the script and end the session
            session_destroy();
            header("Location: home.php");
            exit;
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email does not exist in the database
        echo "<script>alert('Email does not exist in the database.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
    
    @import url("https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600&display=swap");

    :root {
  --header-height: 3.5rem;

  /*========== Colors ==========*/
  /*Color mode HSL(hue, saturation, lightness)*/
  --first-color: hsl(230, 75%, 56%);
  --title-color: hsl(230, 75%, 15%);
  --text-color: hsl(230, 12%, 40%);
  --body-color: hsl(230, 100%, 98%);
  --container-color: hsl(230, 100%, 97%);
  --border-color: hsl(230, 25%, 80%);

  /*========== Font and typography ==========*/
  /*.5rem = 8px | 1rem = 16px ...*/
  --body-font: "Syne", sans-serif;
  --h2-font-size: 1.25rem;
  --normal-font-size: .938rem;

  /*========== Font weight ==========*/
  --font-regular: 400;
  --font-medium: 500;
  --font-semi-bold: 600;

  /*========== z index ==========*/
  --z-fixed: 100;
  --z-modal: 1000;
}
        form {
            background-color:  hsl(230, 100%, 97%);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: var(--body-font);
        }
        
        h2 {
            color: #333;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: #666;
            margin-bottom: 5px;
        }
        
        input[type=email] {
            width: 100%;
            background-color: hsl(230, 100%, 97%);
            margin-bottom: 20px;
            border: 2px solid  hsl(230, 25%, 80%);
            border-radius: 4px;
            padding:15px 0px;
            border-radius:5px;
        }
        
        button[type=submit] {
            width: 100%;
            background-color: #113e67;
            color: #ffffff;
            padding: 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }
        
        button[type=submit]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input placeholder="Gmail Address" type="email" id="gmail" name="gmail" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
