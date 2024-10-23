<?php
require_once 'db_connection.php'; // Adjust the path as necessary

if (isset($_GET['ItemID'])) {
    $itemID = mysqli_real_escape_string($conn, $_GET['ItemID']);
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Step 1: Delete the images associated with the item
        $sqlDeleteImages = "DELETE FROM productimages WHERE ItemID = ?";
        $stmt = mysqli_prepare($conn, $sqlDeleteImages);
        mysqli_stmt_bind_param($stmt, 'i', $itemID);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to delete images: " . mysqli_error($conn));
        }
        
        // Optional: Remove the image files from the file system
        // You would need to fetch the image file paths before deleting them from the database
        // and then use unlink($filePath) to remove each file.

        // Step 2: Delete the item
        $sqlDeleteItem = "DELETE FROM items WHERE ItemID = ?";
        $stmt = mysqli_prepare($conn, $sqlDeleteItem);
        mysqli_stmt_bind_param($stmt, 'i', $itemID);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to delete item: " . mysqli_error($conn));
        }

        // Commit transaction
        mysqli_commit($conn);
        echo "Item and associated images deleted successfully.";
    } catch (Exception $e) {
        // An error occurred, rollback transaction
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No ItemID provided.";
}

// Close connection
mysqli_close($conn);
?>
