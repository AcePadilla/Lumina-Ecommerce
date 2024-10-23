<?php
// Assuming the user's email is stored in a session or a similar persistent storage after login
session_start();
$clientEmail = $_SESSION['email']; // Replace 'user_email' with the actual session variable

// Include your database connection file here
include 'db_connection.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    
    // Fetch clientID based on the client's email
    $clientIDQuery = "SELECT clientid FROM client WHERE email = ?";
    if ($clientIDStmt = $conn->prepare($clientIDQuery)) {
        $clientIDStmt->bind_param("s", $clientEmail);
        $clientIDStmt->execute();
        $clientIDResult = $clientIDStmt->get_result();
        if ($clientIDRow = $clientIDResult->fetch_assoc()) {
            $clientID = $clientIDRow['clientid'];
        } else {
            echo "Client not found.";
            exit();
        }
        $clientIDStmt->close();
    }

    // Fetch CartID based on clientID
    $cartIDQuery = "SELECT CartID FROM cart WHERE clientid = ?";
    if ($cartIDStmt = $conn->prepare($cartIDQuery)) {
        $cartIDStmt->bind_param("i", $clientID);
        $cartIDStmt->execute();
        $cartIDResult = $cartIDStmt->get_result();
        if ($cartIDRow = $cartIDResult->fetch_assoc()) {
            $cartID = $cartIDRow['CartID'];
        } else {
            echo "Cart not found.";
            exit();
        }
        $cartIDStmt->close();
    }

    // Fetch OrderID based on CartID
    $orderIDQuery = "SELECT OrderID FROM orders WHERE CartID = ?";
    if ($orderIDStmt = $conn->prepare($orderIDQuery)) {
        $orderIDStmt->bind_param("i", $cartID);
        $orderIDStmt->execute();
        $orderIDResult = $orderIDStmt->get_result();
        if ($orderIDRow = $orderIDResult->fetch_assoc()) {
            $OrderID = $orderIDRow['OrderID'];
        } else {
            echo "Order not found.";
            exit();
        }
        $orderIDStmt->close();
    }
    
    // Proceed with file upload and data insertion
    
    // Handling file upload
    $target_dir = "payment/"; // Directory where files will be saved
    $file = $_FILES['payment_proof']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $temp_name = $_FILES['payment_proof']['tmp_name'];
    $path_filename_ext = $target_dir.$filename.".".$ext;
    
    // Move the uploaded file to the server's directory
    if (move_uploaded_file($temp_name, $path_filename_ext)) {
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file!";
    }

    // Insert data into the payment table
    $gcash_reference_no = $_POST['gcash_reference_no'];
    $sql = "INSERT INTO payment (OrderID, CartID, clientid, gcash_reference_no, paymentimageURL) VALUES (?, ?, ?, ?, ?)";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiiss", $OrderID, $cartID, $clientID, $gcash_reference_no, $path_filename_ext);
            if ($stmt->execute()) {
                echo "<script>
                alert('Payment recorded successfully.');
                window.location.href = 'receipt.php';
                </script>";
                exit();
                            
                
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
        $conn->close();
}
        ?>