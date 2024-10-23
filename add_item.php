<?php
include 'db_connection.php'; // Make sure this points to your database connection file

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form data to variables
    $CategoryID = mysqli_real_escape_string($conn, $_POST['CategoryID']);
    $itemName = mysqli_real_escape_string($conn, $_POST['itemName']);
    $itemDescription = mysqli_real_escape_string($conn, $_POST['itemDescription']);
    $itemPrice = mysqli_real_escape_string($conn, $_POST['itemPrice']);
    $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);

    // SQL query to insert item details
    $sql = "INSERT INTO items (CategoryID, ItemName, Description, Price, stock_quantity) VALUES ('$CategoryID', '$itemName', '$itemDescription', '$itemPrice', '$stock_quantity')";

    // Execute the query
    if(mysqli_query($conn, $sql)) {
        $itemId = mysqli_insert_id($conn); // Get the ID of the inserted item

        // Handle file uploads
        $uploadDirectory = "uploads/"; // Ensure this directory exists and is writable
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['images']['error'][$key] == 0 && is_uploaded_file($tmpName)) {
                $fileName = mysqli_real_escape_string($conn, basename($_FILES['images']['name'][$key]));
                $targetFilePath = $uploadDirectory . $fileName;

                // Move the file to the upload directory
                if(move_uploaded_file($tmpName, $targetFilePath)) {
                    // SQL query to insert image file path into the productimages table
                    $insertImageSql = "INSERT INTO productimages (ItemID, ImageURL) VALUES ('$itemId', '$targetFilePath')";

                    // Execute the query
                    mysqli_query($conn, $insertImageSql);
                }
            }
        }

      echo  "<script type='text/javascript'>
        alert('Item and images uploaded successfully.');
        window.location = 'admin5.php';
    </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
