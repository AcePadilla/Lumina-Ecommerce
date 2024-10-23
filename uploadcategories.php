<?php
include 'db_connection.php'; // Include the database connection

$action = $_POST['action'] ?? '';

if ($action == 'addCategory') {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? ''); // Assuming you're passing a description now
    $sql = "INSERT INTO categories (CategoryName, Description) VALUES ('$categoryName', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "Category added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>
