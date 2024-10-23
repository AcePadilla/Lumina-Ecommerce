<?php
session_start();
session_start();
include('db_connection.php');

// Assuming you're using email to fetch the clientID
$email = $conn->real_escape_string($_SESSION['email']);
$itemID = $conn->real_escape_string($_POST['ItemID']);

// First, fetch the clientID based on the email stored in the session
$clientIDQuery = "SELECT clientid FROM client WHERE email = '$email' LIMIT 1";
$clientIDResult = $conn->query($clientIDQuery);

if ($clientIDResult->num_rows > 0) {
    $row = $clientIDResult->fetch_assoc();
    $clientID = $row['clientid'];

    // Check if this item is already liked by the user
    $checkExistsSql = "SELECT * FROM favorites WHERE clientid = '$clientID' AND ItemID = '$itemID'";
    $result = $conn->query($checkExistsSql);

    if ($result->num_rows > 0) {
        // Item is already liked, perform unlike action - delete the record
        $deleteSql = "DELETE FROM favorites WHERE clientid = '$clientID' AND ItemID = '$itemID'";
        if ($conn->query($deleteSql) === TRUE) {
            echo "<script>alert('Item unliked successfully'); window.location.href='shoppage (1).php';</script>";
        } else {
            echo "<script>alert('Error unliking item: " . addslashes($conn->error) . "'); window.location.href='shoppage (1).php';</script>";
        }
    } else {
        // Item not liked yet, insert new like
        $insertSql = "INSERT INTO favorites (clientID, itemID) VALUES ('$clientID', '$itemID')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<script>alert('Item liked successfully'); window.location.href='shoppage (1).php';</script>";
        } else {
            echo "<script>alert('Error liking item: " . addslashes($conn->error) . "'); window.location.href='shoppage (1).php';</script>";
        }
    }
} else {
    echo "<script>alert('Error: User not found.'); window.location.href='shoppage (1).php';</script>";
}

$conn->close();
?>