<?php
include 'db_connection.php'; // Ensure this path is correct

if (isset($_GET['CategoryID'])) {
    $categoryID = mysqli_real_escape_string($conn, $_GET['CategoryID']);
    
    $sql = "SELECT CategoryName, Description FROM categories WHERE CategoryID = $categoryID";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} else {
    echo json_encode(['error' => 'No CategoryID provided']);
}

mysqli_close($conn);
?>
