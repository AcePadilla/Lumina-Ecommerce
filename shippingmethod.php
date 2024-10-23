<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shippingmethod'])) {
    $clientEmail = $_SESSION['email']; // Assuming the user's email is stored in the session
    $shippingMethod = $conn->real_escape_string($_POST['shippingmethod']);

    // Fetch clientID based on the client's email
    $clientIDQuery = "SELECT clientid FROM client WHERE email = ?";
    $clientIDStmt = $conn->prepare($clientIDQuery);
    $clientIDStmt->bind_param("s", $clientEmail);
    $clientIDStmt->execute();
    $clientIDResult = $clientIDStmt->get_result();
    if ($clientIDRow = $clientIDResult->fetch_assoc()) {
        $clientID = $clientIDRow['clientid'];
    } else {
        echo "Client not found.";
        $conn->close();
        exit();
    }
    $clientIDStmt->close();

    // Fetch CartID based on clientID
    $cartIDQuery = "SELECT CartID FROM cart WHERE clientid = ?";
    $cartIDStmt = $conn->prepare($cartIDQuery);
    $cartIDStmt->bind_param("i", $clientID);
    $cartIDStmt->execute();
    $cartIDResult = $cartIDStmt->get_result();
    if ($cartIDRow = $cartIDResult->fetch_assoc()) {
        $cartID = $cartIDRow['CartID'];
    } else {
        echo "Cart not found for this user.";
        $conn->close();
        exit();
    }
    $cartIDStmt->close();

    // Pre-check stock quantity for each item in the cart
    $cartItemsQuery = "SELECT itemID, quantity FROM cart_items WHERE CartID = ?";
    $cartItemsStmt = $conn->prepare($cartItemsQuery);
    $cartItemsStmt->bind_param("i", $cartID);
    $cartItemsStmt->execute();
    $cartItemsResult = $cartItemsStmt->get_result();

    while ($itemRow = $cartItemsResult->fetch_assoc()) {
        $itemID = $itemRow['itemID'];
        $quantity = $itemRow['quantity'];

        // Fetch stock_quantity for the item
        $stockCheckQuery = "SELECT stock_quantity FROM items WHERE itemID = ?";
        $stockCheckStmt = $conn->prepare($stockCheckQuery);
        $stockCheckStmt->bind_param("i", $itemID);
        $stockCheckStmt->execute();
        $stockCheckResult = $stockCheckStmt->get_result();
        
        if ($stockRow = $stockCheckResult->fetch_assoc()) {
            if ($quantity > $stockRow['stock_quantity']) {
                // Alert the user and redirect if quantity exceeds stock
                $remainingStock = $stockRow['stock_quantity'];
                echo "<script>alert('Not enough stock for item ID $itemID. Only $remainingStock left in stock.'); window.location.href='cart.php';</script>";
                $conn->close();
                exit();
            }
        } else {
            echo "<script>alert('Item ID $itemID not found.'); window.location.href='cart.php';</script>";
            $conn->close();
            exit();
        }
        $stockCheckStmt->close();
    }
    $cartItemsStmt->close();

    $orderDate = date("Y-m-d H:i:s");
    $status = "Pending"; // Example status

    // Insert general order information into orders table
    $ordersInsertQuery = "INSERT INTO orders (CartID, clientid, OrderDate, Status, ShippingMethod) VALUES (?, ?, ?, ?, ?)";
    $ordersInsertStmt = $conn->prepare($ordersInsertQuery);
    $ordersInsertStmt->bind_param("iisss", $cartID, $clientID, $orderDate, $status, $shippingMethod);
    $ordersInsertStmt->execute();
    $orderID = $conn->insert_id; // Get the auto-generated OrderID
    $_SESSION['currentOrderID'] = $orderID; // Store the OrderID in the session

    $ordersInsertStmt->close();

    if ($orderID) {
        // Fetch cart items for the current CartID to insert into orderitems
        $cartItemsQuery = "SELECT Cart_Item_ID, itemID, quantity FROM cart_items WHERE CartID = ?";
        $cartItemsStmt = $conn->prepare($cartItemsQuery);
        $cartItemsStmt->bind_param("i", $cartID);
        $cartItemsStmt->execute();
        $cartItemsResult = $cartItemsStmt->get_result();

        while ($itemRow = $cartItemsResult->fetch_assoc()) {
            $cartItemID = $itemRow['Cart_Item_ID'];
            $itemID = $itemRow['itemID'];
            $quantity = $itemRow['quantity'];

            // Insert order items into orderitems table
            $orderItemsInsertQuery = "INSERT INTO orderitem (OrderID, Cart_Item_ID, itemID, order_quantity) VALUES (?, ?, ?, ?)";
            $orderItemsInsertStmt = $conn->prepare($orderItemsInsertQuery);
            $orderItemsInsertStmt->bind_param("iiii", $orderID, $cartItemID, $itemID, $quantity);
            if (!$orderItemsInsertStmt->execute()) {
                echo "Error inserting order item: " . $orderItemsInsertStmt->error;
            }
            $orderItemsInsertStmt->close();

            // Deduct the ordered quantity from stock_quantity in the items table
            $updateStockQuery = "UPDATE items SET stock_quantity = stock_quantity - ? WHERE itemID = ?";
            $updateStockStmt = $conn->prepare($updateStockQuery);
            $updateStockStmt->bind_param("ii", $quantity, $itemID);
            if (!$updateStockStmt->execute()) {
                echo "Error updating stock for itemID $itemID: " . $updateStockStmt->error;
            }
            $updateStockStmt->close();
        }
        $cartItemsStmt->close();

        // After successfully inserting all order items and updating stock, remove items from cart_items
        $deleteCartItemsQuery = "DELETE FROM cart_items WHERE CartID = ?";
        $deleteCartItemsStmt = $conn->prepare($deleteCartItemsQuery);
        $deleteCartItemsStmt->bind_param("i", $cartID);
        if (!$deleteCartItemsStmt->execute()) {
            echo "Error removing items from cart: " . $deleteCartItemsStmt->error;
        }
        $deleteCartItemsStmt->close();

        // Redirect on successful order creation and cleanup
        echo "<script>alert('Order processed successfully.'); window.location.href = 'checkoutpayment.php';</script>";
        exit();
    } else {
        echo "Error creating order.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
