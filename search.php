
<?php
include ('db_connection.php');
$searchQuery = $_GET['searchQuery'] ?? '';

// Protect against SQL injection
$searchTerm = $conn->real_escape_string($searchQuery);

$sql = "SELECT items.*, productimages.imageURL FROM items 
        LEFT JOIN productimages ON items.itemID = productimages.itemID 
        WHERE items.ItemName LIKE '%$searchTerm%' OR items.Description LIKE '%$searchTerm%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Item Name</th><th>Description</th><th>Price</th><th>Image</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ItemName"]."</td><td>".$row["Description"]."</td><td>".$row["Price"]."</td>";
        echo "<td><img src='".$row["imageURL"]."' style='width:200px;'></td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results found";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>