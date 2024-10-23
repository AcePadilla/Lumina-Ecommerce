
<?php
include 'db_connection.php'; // Ensure this path is correct

// Escape user inputs for security
$categoryName = mysqli_real_escape_string($conn, $_POST['CategoryName']);
$description = mysqli_real_escape_string($conn, $_POST['Description']);

// Attempt insert query execution
$sql = "INSERT INTO categories (CategoryName, Description) VALUES ('$categoryName', '$description')";

if(mysqli_query($conn, $sql)){
  echo  "<script type='text/javascript'>
    alert('New record created successfully.');
    window.location = 'admin5.php';
</script>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
