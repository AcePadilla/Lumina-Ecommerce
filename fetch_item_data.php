<?php
include 'db_connection.php'; // Ensure this path is correct

if (isset($_GET['ItemID'])) {
    $itemID = mysqli_real_escape_string($conn, $_GET['ItemID']);
    
    // Query to fetch item details
    $sql = "SELECT items.ItemID, items.ItemName, items.Description, items.Price, items.stock_quantity, categories.CategoryID, categories.CategoryName, GROUP_CONCAT(productimages.ImageURL) AS ImageURLs FROM items LEFT JOIN categories ON items.CategoryID = categories.CategoryID LEFT JOIN productimages ON items.ItemID = productimages.ItemID WHERE items.ItemID = $itemID GROUP BY items.ItemID";
    
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Convert image URLs string to an array
        $row['ImageURLs'] = !empty($row['ImageURLs']) ? explode(',', $row['ImageURLs']) : [];
        echo json_encode($row);
       
    } else {
        echo json_encode(['error' => 'No data found for the provided ItemID']);
    }
} else {
    echo json_encode(['error' => 'No ItemID provided']);
}

mysqli_close($conn);
?>
