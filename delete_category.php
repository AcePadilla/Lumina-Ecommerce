<?php
include 'db_connection.php'; // Ensure this path is correct

// Check if CategoryID is present
if(isset($_GET['CategoryID'])){
    $categoryID = mysqli_real_escape_string($conn, $_GET['CategoryID']);

    // Attempt delete query execution
    $sql = "DELETE FROM categories WHERE CategoryID = $categoryID";

    if(mysqli_query($conn, $sql)){
        echo  "<script type='text/javascript'>
        alert('Record Deleted Successfuly.');
        window.location = 'admin5.php';
    </script>";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
} else {
    // If no CategoryID is provided in the URL, print an error message
    echo "ERROR: No CategoryID provided for deletion.";
}

// Close connection
mysqli_close($conn);
?>
