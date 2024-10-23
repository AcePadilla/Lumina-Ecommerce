<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connection.php'; // Make sure this path is correct

    $categoryID = $_POST['CategoryID'];
    $categoryName = mysqli_real_escape_string($conn, $_POST['CategoryName']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);

    $sql = "UPDATE categories SET CategoryName='$categoryName', Description='$description' WHERE CategoryID=$categoryID";

    if(mysqli_query($conn, $sql)){
        echo "Category updated successfully. <a href='index.php'>View Categories</a>";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
