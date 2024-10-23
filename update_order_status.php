<?php
include 'db_connection.php'; // Include your database connection

function updateStockQuantity($conn, $orderID) {
    // Fetch the items and their quantities from the order
    $itemQuery = "SELECT itemID, order_quantity FROM orderitem WHERE OrderID = ?";
    $itemStmt = $conn->prepare($itemQuery);
    $itemStmt->bind_param("i", $orderID);
    $itemStmt->execute();
    $result = $itemStmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $itemID = $row['itemID'];
        $quantity = $row['order_quantity'];
        
        // Update the stock_quantity for each item in the items table
        $updateQuery = "UPDATE items SET stock_quantity = stock_quantity + ? WHERE ItemID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ii", $quantity, $itemID);
        $updateStmt->execute();
        $updateStmt->close();
    }
    
    $itemStmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderID = $_POST['OrderID'];
    $status = $_POST['Status'];

    // Check if the status is being updated to "Cancelled"
    if ($status === "Cancelled") {
        // If the order is being cancelled, first update the stock_quantity for the items
        updateStockQuantity($conn, $orderID);
    }

    // Then, update the order status
    $sql = "UPDATE orders SET Status = ? WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $orderID);

    if ($stmt->execute()) {
        echo "Order status updated successfully.";
        if ($status === "Cancelled") {
            echo " The stock quantity of the items has been updated.";
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>

<a href="admin5.php">Back to Orders</a>
