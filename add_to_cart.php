<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    die("<script>alert('You must be logged in to add items to the cart.'); window.location.href='login.php';</script>");
}

$email = $conn->real_escape_string($_SESSION['email']);
$itemID = $conn->real_escape_string($_POST['item_id']);
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Default to 1 if not set

// Validate quantity
if ($quantity <= 0) {
    die("<script>alert('Invalid quantity.'); window.location.href='shoppage (1).php';</script>");
}

// Fetch the clientID based on the email
$clientIDQuery = $conn->prepare("SELECT clientID FROM client WHERE email = ? LIMIT 1");
$clientIDQuery->bind_param("s", $email);
$clientIDQuery->execute();
$clientIDResult = $clientIDQuery->get_result();

if ($clientIDResult->num_rows == 0) {
    die("<script>alert('Client not found.'); window.location.href='shoppage (1).php';</script>");
}
$clientIDRow = $clientIDResult->fetch_assoc();
$clientID = $clientIDRow['clientID'];

// Check if the client already has a cart
$cartQuery = $conn->prepare("SELECT CartID FROM cart WHERE clientID = ? LIMIT 1");
$cartQuery->bind_param("i", $clientID);
$cartQuery->execute();
$cartResult = $cartQuery->get_result();

if ($cartResult->num_rows == 0) {
    $insertCart = $conn->prepare("INSERT INTO cart (clientID) VALUES (?)");
    $insertCart->bind_param("i", $clientID);
    if (!$insertCart->execute()) {
        echo "<script>alert('Error creating new cart: " . $conn->error . "'); window.location.href='shoppage (1).php';</script>";
        $conn->close();
        exit;
    }
    $cartID = $conn->insert_id;
} else {
    $cartRow = $cartResult->fetch_assoc();
    $cartID = $cartRow['CartID'];
}

// Check stock_quantity and existing cart item quantity
$stockCheckQuery = $conn->prepare("SELECT stock_quantity FROM items WHERE itemID = ? LIMIT 1");
$stockCheckQuery->bind_param("i", $itemID);
$stockCheckQuery->execute();
$stockCheckResult = $stockCheckQuery->get_result();

if ($stockRow = $stockCheckResult->fetch_assoc()) {
    $stockQuantity = $stockRow['stock_quantity'];

    // Check existing quantity in cart for this item
    $cartItemCheckQuery = $conn->prepare("SELECT quantity FROM cart_items WHERE CartID = ? AND itemID = ? LIMIT 1");
    $cartItemCheckQuery->bind_param("ii", $cartID, $itemID);
    $cartItemCheckQuery->execute();
    $cartItemCheckResult = $cartItemCheckQuery->get_result();
    $currentQuantityInCart = 0;

    if ($cartItemRow = $cartItemCheckResult->fetch_assoc()) {
        $currentQuantityInCart = $cartItemRow['quantity'];
    }

    // Check if adding the new quantity exceeds stock quantity
    if (($currentQuantityInCart + $quantity) > $stockQuantity) {
        echo "<script>alert('Not enough stock available.'); window.location.href='shoppage (1).php';</script>";
        $conn->close();
        exit;
    }
} else {
    echo "<script>alert('Item not found.'); window.location.href='shoppage (1).php';</script>";
    $conn->close();
    exit;
}

// Proceed to add the item to the cart if stock checks pass
$addToCartSql = $conn->prepare("INSERT INTO cart_items (CartID, itemID, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
$addToCartSql->bind_param("iii", $cartID, $itemID, $quantity);
if ($addToCartSql->execute()) {
    echo "<script>alert('Item added to cart successfully'); window.location.href='shoppage (1).php';</script>";
} else {
    // If adding the item to the cart itself fails
    echo "<script>alert('Error adding item to cart: " . $conn->error . "'); window.location.href='shoppage (1).php';</script>";
}

$conn->close();
?>
