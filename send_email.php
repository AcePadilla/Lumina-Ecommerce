<?php
include ('db_connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['message_id'], $_POST['customMessage'])) {
    $to = $_POST['email']; // The sender's email address
    $subject = "Response to Your Message";
    $body = $_POST['customMessage']; // Use the custom message composed by the user
    $headers = "From: romark7bayan.gmail.com"; // Adjust this to your email

    // Make sure to sanitize the $body for security reasons
    // This is a basic example; consider more robust sanitization based on your needs
    $body = htmlspecialchars($body);

    if (mail($to, $subject, $body, $headers)) {
        // Success: Redirect back to the messages management page
        header('Location: admin5.php?status=success');
        exit();
    } else {
        // Failure: Redirect back to the messages management page with an error
        header('Location: admin5.php?status=error');
        exit();
    }
} else {
    // Invalid request
    echo "Invalid request.";
}
?>
