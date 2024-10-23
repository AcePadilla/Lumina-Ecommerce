<?php
 
    if (isset($_POST["verify_email"]))
    {
        $email = $_POST["email"];
        $verification_code = $_POST["verification_code"];
 
        // connect with database
        $conn = mysqli_connect("localhost", "root", "", "jra");
 
        // mark email as verified
        $sql = "UPDATE client SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);
 
        if (mysqli_affected_rows($conn) == 0)
        {
            // die("Verification code failed.");
            echo "Verification code failed.";
        }
 
      
        exit();
    }
 
?>
