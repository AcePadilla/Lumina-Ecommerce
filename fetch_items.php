<?php
session_start();
include 'db_connection.php'; // Ensure this points to your actual db connection script

$sort = $_GET['sort'] ?? 'name'; // Default sort by name
$sql = "SELECT i.ItemName, i.Description, i.Price, p.imageURL, i.itemID FROM items i JOIN productimages p ON i.itemID = p.itemID";

// Adjust the ORDER BY clause based on the sort parameter
if ($sort === 'price') {
    $sql .= " ORDER BY i.Price";
} elseif ($sort === 'name') {
    $sql .= " ORDER BY i.ItemName";
}

$result = $conn->query($sql);

$items = []; // Array to accumulate unique items with their images
    
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    // Check if this itemID has already been added
    if (!array_key_exists($row["itemID"], $items)) {
      $items[$row["itemID"]] = [
        "ItemName" => $row["ItemName"],
        "Description" => $row["Description"],
        "Price" => $row["Price"],
        "Images" => [$row["imageURL"]] // Initialize with the first image
      ];
    } else {
      // Just append additional images for this item
      $items[$row["itemID"]]["Images"][] = $row["imageURL"];
    }
  }

  // Now, output each item with its images
  foreach ($items as $itemID => $item) {
    echo "<div class='boxes'>";
    echo "<div class='image-container'>";
    // Always display the first image
    echo "<img src='" . $item["Images"][0] . "' alt='' class='primary-image'>";
    if (count($item["Images"]) > 1) {
      // Container for additional images, displayed only on hover
      echo "<div class='additional-images'>";
      foreach ($item["Images"] as $image) {
        echo "<img src='" . $image . "' alt='' class='hover-image'>";
      }
      echo "</div>"; // Close .additional-images
    }
    echo "</div>"; // Close .image-container
    echo "<h3>" . $item["ItemName"] . "</h3>";
    echo "<p>₱" . $item["Price"] . "</p>";
    // Like button
    echo "<div>";
    echo "<div class='heart-container' title='Like'>";
    
    echo "<form action='record_like.php' method='post' class='like-form'>";
    echo "<input type='hidden' name='ItemID' value='" . $itemID . "'>";
    echo "<input type='hidden' name='clientid' value='" . $_SESSION['email'] . "'>";
    echo "<button type='submit' name='like' class='heart-container' title='Like'>";
 // SVGs go here
    echo "<svg viewBox='0 0 24 24' class='svg-outline' xmlns='http://www.w3.org/2000/svg'><path d='M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Zm-3.585,18.4a2.973,2.973,0,0,1-3.83,0C4.947,16.006,2,11.87,2,8.967a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,8.967a1,1,0,0,0,2,0,4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,8.967C22,11.87,19.053,16.006,13.915,20.313Z'></path></svg>";
    "<svg viewBox='0 0 24 24' class='svg-outline' xmlns='http://www.w3.org/2000/svg'><path d='M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Zm-3.585,18.4a2.973,2.973,0,0,1-3.83,0C4.947,16.006,2,11.87,2,8.967a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,8.967a1,1,0,0,0,2,0,4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,8.967C22,11.87,19.053,16.006,13.915,20.313Z'></path></svg>";
    echo "<svg viewBox='0 0 24 24' class='svg-filled' xmlns='http://www.w3.org/2000/svg'><path d='M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Z'></path></svg>";
    // If the celebrate SVG is not used for the like button functionality, it might not be necessary to include it here.
    // However, it's provided for completeness.
    echo "<svg class='svg-celebrate' width='100' height='100' xmlns='http://www.w3.org/2000/svg'><polygon points='10,10 20,20'></polygon><polygon points='10,50 20,50'></polygon><polygon points='20,80 30,70'></polygon><polygon points='90,10 80,20'></polygon><polygon points='90,50 80,50'></polygon><polygon points='80,80 70,70'></polygon></svg>";
    echo "</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    // Add to cart form
    
    echo "<form action='add_to_cart.php' method='post'>";
    echo "<input type='hidden' name='item_id' value='" . $itemID . "'>";
    echo "<button type='submit' name='add_to_cart' class='cart-icon-btn'>";
    echo "<i class='fa-solid fa-cart-shopping fa-xl'></i>";
    echo "</button>";
    echo "</form>";
    

    echo "</div>"; // Close .boxes
}

} else {
  echo "0 results";
}
$conn->close();
?>
