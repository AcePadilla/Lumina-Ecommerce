


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receipt</title>
<link rel="stylesheet" href="path/to/your/css/if/external.css"> <!-- Optional para sa external CSS -->
<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        padding: 20px;
        background-color: #f0f0f0;
    }
    img{
        margin:10px auto;
        width:300px;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    h3{
        text-align:center;

    }
    .receipt-container {
        max-width: 500px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .itemcart {
        border-bottom: 1px dashed #ccc;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .receipt-footer {
        text-align: center;
        margin-top: 20px;
    }
    .btn-close, .btn-print {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-close {
        background-color: #dc3545;
    }
    .btn-print {
        margin-right: 10px;
    }
</style>
</head>
<body>

<div class="receipt-container">
    <img src="pics/luminalogo-removebg-preview.png" alt="">
    <h3>"
Thank you for shopping with us."</h3>
    <?php
session_start();
include('db_connection.php');

// Check if there is a currentOrderID stored in the session
if (!isset($_SESSION['currentOrderID'])) {
    echo "No current order available.";
    exit(); // Stop script execution if there is no current order ID
}

// Retrieve the currentOrderID from the session
$currentOrderID = $_SESSION['currentOrderID'];

// Prepare SQL query using the currentOrderID to fetch order details
$stmt = $conn->prepare("SELECT 
    it.itemID, 
    it.CategoryID, 
    it.ItemName, 
    it.Description, 
    it.Price, 
    oi.order_quantity, 
    pi.imageURL, 
    o.OrderID, 
    o.OrderDate,
    o.shippingmethod, 
    sm.shippingmethodprice,
    (it.Price * oi.order_quantity) AS itemTotal,

    ca.firstname, 
    ca.lastname, 
    CONCAT(ca.address, ', ', ca.city, ', ', ca.country, ' ', ca.zipcode) AS full_address
FROM items it
JOIN orderitem oi ON it.itemID = oi.itemID
JOIN orders o ON oi.OrderID = o.OrderID
JOIN productimages pi ON it.itemID = pi.itemID
LEFT JOIN shipmethod sm ON o.shippingmethod = sm.shippingmethod
LEFT JOIN checkout_address ca ON o.CartID = ca.CartID
WHERE o.OrderID = ?
GROUP BY it.itemID");

$stmt->bind_param("i", $currentOrderID);
$stmt->execute();
    $result = $stmt->get_result();

    $totalPrice = 0;
$shippingPrice = 0;
$fullAddress = '';
$shippingMethod = '';
$orderDate = '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Calculate and display item details
            $totalPrice += $row['itemTotal'];
            $shippingPrice = $row['shippingmethodprice'];
            $fullAddress = $row["full_address"]; // This assumes 'full_address' is part of the SELECT querye
            $shippingMethod = $row["shippingmethod"]; // This assumes 'shippingmethod' is part of the SELECT query
             // This will get updated with each item but should remain constant per order

            echo "<div class='itemcart'>";
            echo "Item Name: " . $row["ItemName"] . "<br>Order ID&nbsp;" . $row['OrderID']."<br>Price: P" . $row["Price"] . "<br>Quantity Ordered: " . $row["order_quantity"] . "<br>Total: P" . $row['itemTotal'] ;  

            echo "</div>";
        }
        
        // Display order summary
        echo "<br>Address: " . $fullAddress;  
        echo "<br>Shipping Method: " . $shippingMethod;
        echo "<br>Order Date: " . $orderDate;
        $grandTotal = $totalPrice + $shippingPrice;
        echo "<strong>Total Price: P" . $totalPrice . "</strong><br>";
        echo "<strong>Shipping Price: P" . $shippingPrice . "</strong><br>";
        echo "<strong>Grand Total: P" . $grandTotal . "</strong><br>";
    } else {
        echo "No items found for this order.";
    }
    


$stmt->close();
$conn->close();

?>

<div class="receipt-footer">
    <button class="btn-print" onclick="window.print();">Print Receipt</button>
    <button class="btn-close" onclick="window.location.href='shoppage (1).php';">Close</button>
</div>

</body>
</html>

