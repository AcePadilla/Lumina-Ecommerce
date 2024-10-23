<?php
include 'db_connection.php'; // Include your database connection script

// Ensure itemId is set in the request
if(isset($_GET['itemID'])) {
    $itemId = $_GET['itemID']; // Retrieve the item ID from the request

    // Initialize an array to hold the item details and images
    $itemDetails = [];

    // Fetch item details from the database based on the item ID
    $query = "
    SELECT 
        i.ItemID, 
        i.Name AS ItemName, 
        i.Description, 
        i.Price, 
        c.CategoryName,  // Fetching CategoryName
        s.SubcategoryName  // Fetching SubcategoryName
    FROM 
        items i
        INNER JOIN subcategories s ON i.SubcategoryID = s.SubcategoryID
        INNER JOIN categories c ON s.CategoryID = c.CategoryID
    WHERE 
        i.ItemID = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if item details were fetched
    if($result->num_rows > 0) {
        $itemDetails = $result->fetch_assoc();

        // Now, fetch the associated images for the item
        $imagesQuery = "SELECT ImageURL FROM productimages WHERE ItemID = ?";
        $imagesStmt = $conn->prepare($imagesQuery);
        $imagesStmt->bind_param("i", $itemId);
        $imagesStmt->execute();
        $imagesResult = $imagesStmt->get_result();
        
        // Initialize an array to hold the image URLs
        $imageURLs = [];
        
        while($row = $imagesResult->fetch_assoc()) {
            $imageURLs[] = $row['ImageURL'];
        }
        
        // Append image URLs to the item details array
        $itemDetails['ImageURLs'] = $imageURLs;

        // Output item details as JSON
        header('Content-Type: application/json');
        echo json_encode($itemDetails);
    } else {
        // Item not found, return an error message
        echo json_encode(array("error" => "Item not found"));
    }
} else {
    // itemId parameter not provided in the request, return an error message
    echo json_encode(array("error" => "No item ID provided"));
}

$conn->close();
?>
