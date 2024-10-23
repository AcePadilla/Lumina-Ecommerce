<?php
session_start();
include('db_connection.php');

if (isset($_POST['Cart_Item_ID'])) {
    $cartItemID = $_POST['Cart_Item_ID'];

    // Prepare statement to remove the item from the cart
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE Cart_Item_ID= ?");
    $stmt->bind_param("i", $cartItemID);
    if ($stmt->execute()) {
        // If the item is successfully removed, redirect back to the cart page or display a success message
        header("Location: cart.php"); // Adjust 'cart_page.php' to the actual name of your cart page
        exit();
    } else {
        // If there was an error removing the item, you might want to display an error message
        echo "Error removing item from cart.";
    }
    $stmt->close();
} else {
    // If the cartItemID wasn't set in the POST request, redirect or display an error message
    echo "Invalid request.";
}

$conn->close();
?>
