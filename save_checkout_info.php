<?php
session_start();
include ('db_connection.php');

$existingData = false; // Flag to track existing data presence
$cartID = null; // Initialize CartID

if (isset($_SESSION['email'])) {
    $clientEmail = $_SESSION['email']; // Fetch client email from session

    // Fetch the CartID based on the client's email
    $cartIDQuery = "SELECT CartID FROM cart JOIN client ON cart.clientid = client.clientid WHERE client.email = ?";
    $cartIDStmt = $conn->prepare($cartIDQuery);
    $cartIDStmt->bind_param("s", $clientEmail);
    $cartIDStmt->execute();
    $cartIDResult = $cartIDStmt->get_result();

    if ($cartIDRow = $cartIDResult->fetch_assoc()) {
        $cartID = $cartIDRow['CartID'];
        
        // Check for existing address data
        $checkExistingQuery = "SELECT * FROM checkout_address WHERE CartID = ?";
        $checkExistingStmt = $conn->prepare($checkExistingQuery);
        $checkExistingStmt->bind_param("i", $cartID);
        $checkExistingStmt->execute();
        $existingResult = $checkExistingStmt->get_result();
        
        if ($existingRow = $existingResult->fetch_assoc()) {
            $existingData = true; // Existing data found
            // Here you can set variables to pre-populate the form, e.g., $existingFirstName = $existingRow['firstName'];
        }
        $checkExistingStmt->close();
    }
    $cartIDStmt->close();
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && $cartID !== null) {
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $country = $conn->real_escape_string($_POST['country']);
    $zipcode = $conn->real_escape_string($_POST['zipcode']);
    
    if ($existingData) {
        // Update existing record
        $updateSql = "UPDATE checkout_address SET firstName=?, lastName=?, address=?, city=?, country=?, zipcode=? WHERE CartID=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssssi", $firstName, $lastName, $address, $city, $country, $zipcode, $cartID);
    } else {
        // Insert new record
        $insertSql = "INSERT INTO checkout_address (CartID, firstName, lastName, address, city, country, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("issssss", $cartID, $firstName, $lastName, $address, $city, $country, $zipcode);
    }
    
    if (($existingData && $updateStmt->execute()) || (!$existingData && $insertStmt->execute())) {
        echo "Address saved successfully.";
        header("Location: checkoutshipping.php"); // Redirect on success
        exit();
    } else {
        echo "Error: " . ($existingData ? $updateStmt->error : $insertStmt->error);
    }
    
    if ($existingData) {
        $updateStmt->close();
    } else {
        $insertStmt->close();
    }
}

$conn->close();

// HTML form goes here
// You can now use the variables set from existing data (if any) to pre-populate the form fields
