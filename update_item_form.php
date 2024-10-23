<?php
include 'db_connection.php'; // Adjust the path as necessary

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = $_POST['ItemID'];
    $itemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);
    $price = mysqli_real_escape_string($conn, $_POST['Price']);
    $stockQuantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);
    $categoryId = mysqli_real_escape_string($conn, $_POST['CategoryID']);
    
    // Update item details in the 'items' table
    $sql = "UPDATE items SET ItemName='$itemName', Description='$description', Price='$price', stock_quantity='$stockQuantity', CategoryID='$categoryId' WHERE ItemID='$itemId'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Item updated successfully.\n";
    } else {
        echo "Error updating record: " . mysqli_error($conn) . "\n";
    }

    // Handle image uploads if images are provided
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDirectory = "uploads/"; // Specify your upload directory

        foreach ($_FILES['images']['name'] as $key => $name) {
            // Define a unique filename for the uploaded file
            $filePath = $uploadDirectory . basename($_FILES['images']['name'][$key]);
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // Move the uploaded file to your specified directory
            if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $filePath)) {
                // Insert image URL into 'productimages' table
                $insertImageSql = "INSERT INTO productimages (ItemID, ImageURL) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $insertImageSql);
                mysqli_stmt_bind_param($stmt, 'is', $itemId, $filePath);

                if (!mysqli_stmt_execute($stmt)) {
                    echo "Failed to insert image URL into the database: " . mysqli_error($conn) . "\n";
                } else {
                    echo "Image uploaded and URL inserted into the database successfully.\n";
                }
            } else {
                echo "Failed to move uploaded file.\n";
            }
        }
    }

    // Optionally redirect or handle the response further
    // header('Location: item_management_page.php'); // Adjust the redirect location as necessary
} else {
    echo "Invalid request.\n";
}

// Close the database connection
mysqli_close($conn);

?>
