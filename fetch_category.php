<?php
    include 'db_connection.php'; // Ensure this points to your database connection script

    // Fetch all categories from the database
    $categoriesQuery = "SELECT CategoryID, CategoryName FROM categories ORDER BY CategoryName ASC";
    $categoriesResult = $conn->query($categoriesQuery);
    $categories = [];

    if ($categoriesResult !== FALSE && $categoriesResult->num_rows > 0) {
        while($row = $categoriesResult->fetch_assoc()) {
            $categories[] = $row;
        
        }
    } else {
        echo "No categories found";
    }
?>