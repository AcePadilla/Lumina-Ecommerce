
<?php
// Include database connection settings
require_once 'db_connection.php';

// Prepare the SQL statement to fetch categories
$sql = "SELECT CategoryID, CategoryName FROM categories ORDER BY CategoryName ASC";
$result = $conn->query($sql);

$categories = [];

// Check if there are results and populate the $categories array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    echo "No categories found";

}
$sortField = isset($_GET['sort']) && in_array($_GET['sort'], ['ItemID', 'CategoryName', 'ItemName', 'Description', 'Price', 'stock_quantity']) ? $_GET['sort'] : 'CategoryName';
$sortDirection = isset($_GET['direction']) && $_GET['direction'] === 'desc' ? 'desc' : 'asc';
$nextDirection = $sortDirection === 'asc' ? 'desc' : 'asc';
if (isset($_GET['view_items'])) {
 include 'db_connection.php'; // Adjust this path as necessary


 // Sorting parameters


 // SQL Query adjusted for sorting
 $sql = "SELECT items.ItemID, categories.CategoryName, items.ItemName, items.Description, items.Price, items.stock_quantity, GROUP_CONCAT(productimages.ImageURL) AS ImageURLs
         FROM items
         JOIN categories ON items.CategoryID = categories.CategoryID
         LEFT JOIN productimages ON items.ItemID = productimages.ItemID
         GROUP BY items.ItemID
         ORDER BY $sortField $sortDirection";

 $result = mysqli_query($conn, $sql);
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina Admin</title>
    <link rel="icon" href="pics/LuminaLogo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="admin5.css">
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>


    <div class="sidebar">
    <button class="calc" onclick="openCalculator()">Calculator</button>
        <div id="calculator-container">
            <!-- Close button -->
            <span class="close-button" onclick="closeCalculator()"><i class="fas fa-times"></i></span>
            <!-- I-frame para sa calculator.html -->
            <iframe src="calculator.html" width="400" height="600" frameborder="0"></iframe>
        </div>
        <img src="pics/luminalogo-removebg-preview.png" alt="">
        <ul class="nav__sidebar">
            <li class="nav__item"><a href="#cart-management">Shop Overview</a></li>
            <li class="nav__item"><a href="#category-management">Category Management</a></li>
            <li class="nav__item"><a href="#item-management">Item Management</a></li>
            <li class="nav__item"><a href="#order-management">Order Management</a></li>

           <!-- <li class="nav__item"><a href="#inventory-management">Inventory Management</a></li> -->
            <li class="nav__item"><a href="#review-management">Review Management</a></li>
             <li class="nav__item"><a href="#contact-management">Contact Management</a></li>
        </ul>
      
        <a href="adminlogin.php">Logout &nbsp;<i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
           
        
    </div>
    <div class="content">

        <section id="category-management">
            <h3>Category Management</h3>
            
            <form action="insert_category.php" method="post">
        <label for="CategoryName">Category Name:</label><br>
        <input type="text" id="CategoryName" name="CategoryName" required><br><br>
        <label for="Description">Description:</label><br>
        <textarea id="Description" name="Description"></textarea><br><br>
        <input type="submit" value="Submit">
    </form>


    
    <form action="" method="get">
        <input type="submit" name="view_categories" value="View Categories">
    </form>
    <?php
    if (isset($_GET['view_categories'])) {
        include 'db_connection.php'; // Adjust this path as necessary

        $sql = "SELECT CategoryID, CategoryName, Description FROM categories ORDER BY CategoryID ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Start table
            echo "<table border='1'><tr><th>ID</th><th>Category Name</th><th>Description</th><th colspan=2>Actions</th></tr>";
            // Output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row["CategoryID"]."</td>
                        <td>".$row["CategoryName"]."</td>
                        <td>".$row["Description"]."</td>
                        <td><a href='#' class='open-modal' data-id='".$row["CategoryID"]."'>Update</a></td>>
                        <td><a href='delete_category.php?CategoryID=".$row["CategoryID"]."' class='delete'>Delete</a></td>
                        </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results found";
        }

        // Close connection 
        mysqli_close($conn);
    }
    ?>

<!-- Update Category Modal -->
<div id="updateCategoryModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-button">×</span>
        <h2>Update Category</h2>
        <form id="updateCategoryForm" action="update_category_form.php" method="post">
            <!-- Hidden field for CategoryID -->
            <input type="hidden" id="updateCategoryID" name="CategoryID">
            
            <label for="updateCategoryName">Category Name:</label>
            <input type="text" id="updateCategoryName" name="CategoryName" required><br><br>
            
            <label for="updateDescription">Description:</label>
            <textarea id="updateDescription" name="Description" required></textarea><br><br>
            
            <input type="submit" value="Update Category" onclick="submitUpdateForm()">
        </form>
    </div>
</div>








</section>

        </section>

        <section id="item-management">
            <title>Add Item with Images</title>

            <form action="add_item.php" method="post" enctype="multipart/form-data">

                <label for="itemCategory">Category:</label><br>
                <select id="itemCategory" name="CategoryID" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['CategoryID']) ?>"><?= htmlspecialchars($category['CategoryName']) ?></option>
                <?php endforeach; ?>
                </select>

                <label for="itemName">Item Name:</label>
                <input type="text" id="itemName" name="itemName" required><br><br>
                
                <label for="itemDescription">Description:</label>
                <textarea id="itemDescription" name="itemDescription" required></textarea><br><br>
                
                <label for="itemPrice">Price:</label>
                <input type="number" step="0.01" id="itemPrice" name="itemPrice" required><br><br>
                
                <label for="stockQuantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" required><br><br>
                
                <label for="images">Item Images:</label>
                <input type="file" id="images" name="images[]" multiple><br><br>
                
                <input type="submit" value="Add Item">
            </form>

            <form action="" method="get">
        <input type="submit" name="view_items" value="View All Items">
            </form>



            <div>
            <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>
                    <tr>
                        <th><a href='?view_items&sort=ItemID&direction=$nextDirection'>ID</a></th>
                        <th><a href='?view_items&sort=CategoryName&direction=$nextDirection'>Category Name</a></th>
                        <th><a href='?view_items&sort=ItemName&direction=$nextDirection'>Item Name</a></th>
                        <th><a href='?view_items&sort=Description&direction=$nextDirection'>Description</a></th>
                        <th><a href='?view_items&sort=Price&direction=$nextDirection'>Price</a></th>
                        <th><a href='?view_items&sort=stock_quantity&direction=$nextDirection'>Stock Quantity</a></th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row["ItemID"]."</td>
                        <td>".$row["CategoryName"]."</td>
                        <td>".$row["ItemName"]."</td>
                        <td>".$row["Description"]."</td>
                        <td>".$row["Price"]."</td>
                        <td>".$row["stock_quantity"]."</td>
                        <td>";

                // Handle Image URLs
                if (!empty($row['ImageURLs'])) {
                    $imageURLs = explode(',', $row['ImageURLs']);
                    foreach ($imageURLs as $url) {
                        echo "<img src='$url' alt='Item Image' style='max-width: 100px; max-height: 100px; margin-right: 5px;'>";
                    }
                } else {
                    echo "No Image";
                }

                 
                        echo "<td>
                            <a href='#' class='open-item-modal-btn' data-item-id='".$row["ItemID"]."'>Update</a>|
                          <a href='delete_item.php?ItemID=".$row["ItemID"]."' class='delete'>Delete</a></td>
                      </tr>";
            }

            echo "</table>"; // Close the table tag
        } else {
            echo "0 results found";
        }

        // Close connection
       
        ?>
        <!-- Update Item Modal -->
<div id="updateItemModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-button">×</span>
        <h2>Update Item</h2>
        <form id="updateItemForm" action="update_item_form.php" method="post" enctype="multipart/form-data">
            <!-- Hidden field for ItemID -->
            <input type="hidden" id="updateItemID" name="ItemID">
            
            <select id="updateItemCategory" name="CategoryID" required>
            <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['CategoryID']) ?>">
             <?= htmlspecialchars($category['CategoryName']) ?>
            </option>
            <?php endforeach; ?>
            </select>

            
            <label for="updateItemName">Item Name:</label>
            <input type="text" id="updateItemName" name="ItemName" required><br><br>
            
            <label for="updateItemDescription">Description:</label>
            <textarea id="updateItemDescription" name="Description" required></textarea><br><br>
            
            <label for="updateItemPrice">Price:</label>
            <input type="number" step="0.01" id="updateItemPrice" name="Price" required><br><br>
            
            <label for="updateStockQuantity">Stock Quantity:</label>
            <input type="number" id="updateStockQuantity" name="stock_quantity" required><br><br>
            
            <label for="updateImages">Item Images:</label>
            <input type="file" id="updateImages" name="images[]" multiple><br><br>
            <!-- Placeholder for existing images display and management -->
            <div id="existingImages"></div>
            
            <input type="submit" value="Update Item">
        </form>
    </div>
</div>

        
    </div>
                          
           

                

            

        </section>

        <section id="cart-management">
        <h3 style="color: #333; text-align:left; border-bottom: 2px solid #eee; padding-bottom: 10px;">Overview</h3>
        <p style="font-size: 16px; margin-bottom: 20px;  text-align:left;">View Shop Statistics and Important Information</p>

            <?php
// Start the session and include database connection
include('db_connection.php');

// Most Ordered Items
$mostOrderedQuery = "
SELECT 
    it.itemID, 
    it.ItemName, 
    COUNT(oi.itemID) AS orderCount
FROM 
    orderitem oi
JOIN 
    items it ON oi.itemID = it.itemID
GROUP BY 
    oi.itemID
ORDER BY 
    orderCount DESC
LIMIT 10;
";

// Items Low on Stocks
$lowStockQuery = "
SELECT 
    itemID, 
    ItemName, 
    stock_quantity
FROM 
    items
WHERE 
    stock_quantity <= 10
ORDER BY 
    stock_quantity ASC;
";

// Assuming you have a 'favorites' table for Most Favorite Item
$favoriteQuery = "
SELECT 
    it.itemID, 
    it.ItemName, 
    COUNT(f.itemID) AS favoriteCount
FROM 
    favorites f
JOIN 
    items it ON f.itemID = it.itemID
GROUP BY 
    f.itemID
ORDER BY 
    favoriteCount DESC
LIMIT 10;
";

// Function to execute any query and return result
function executeQuery($conn, $query) {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

// Display Most Ordered Items within a table with inline styling
echo "<h2 style='color: #444;text-align: left; font-family: Arial, sans-serif;'>Most Ordered Items</h2>";
$result = executeQuery($conn, $mostOrderedQuery);
if ($result->num_rows > 0) {
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr style='background-color: #f2f2f2;'><th style='padding: 8px; border: 1px solid #ddd;'>Item Name</th><th style='padding: 8px; border: 1px solid #ddd;'>Orders</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td style='padding: 8px; border: 1px solid #ddd;'>" . $row["ItemName"] . "</td><td style='padding: 8px; border: 1px solid #ddd; text-align: right;'>" . $row["orderCount"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='font-size: 14px; color: red;'>No data found.</p>";
}

// Display Items Low on Stock within a table with inline styling
echo "<h2 style='color: #444; text-align: left;font-family: Arial, sans-serif;'>Items Low on Stock</h2>";
$result = executeQuery($conn, $lowStockQuery);
if ($result->num_rows > 0) {
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr style='background-color: #f2f2f2;'><th style='padding: 8px; border: 1px solid #ddd;'>Item Name</th><th style='padding: 8px; border: 1px solid #ddd;'>Stock</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td style='padding: 8px; border: 1px solid #ddd;'>" . $row["ItemName"] . "</td><td style='padding: 8px; border: 1px solid #ddd; text-align: right;'>" . $row["stock_quantity"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='font-size: 14px; color: red;'>No data found.</p>";
}

// Display Most Favorite Items within a table with inline styling
echo "<h2 style='color: #444;text-align: left;  font-family: Arial, sans-serif;'>Most Favorite Items</h2>";
$result = executeQuery($conn, $favoriteQuery);
if ($result->num_rows > 0) {
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr style='background-color: #f2f2f2;'><th style='padding: 8px; border: 1px solid #ddd;'>Item Name</th><th style='padding: 8px; border: 1px solid #ddd;'>Favorites</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td style='padding: 8px; border: 1px solid #ddd;'>" . $row["ItemName"] . "</td><td style='padding: 8px; border: 1px solid #ddd; text-align: right;'>" . $row["favoriteCount"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='font-size: 14px; color: red;'>No data found.</p>";
}


// Close connection
$conn->close();
?>
<?php

include('db_connection.php');

// Total Price of Sales
$totalSalesQuery = "
SELECT SUM(it.Price * oi.order_quantity) AS totalSales
FROM orders o
JOIN orderitem oi ON o.OrderID = oi.OrderID
JOIN items it ON oi.itemID = it.itemID
";

// Price of Pending Orders
$pendingSalesQuery = "
SELECT SUM(it.Price * oi.order_quantity) AS pendingSales
FROM orders o
JOIN orderitem oi ON o.OrderID = oi.OrderID
JOIN items it ON oi.itemID = it.itemID
WHERE o.Status = 'Pending'
";

// Price of Completed Orders
$completedSalesQuery = "
SELECT SUM(it.Price * oi.order_quantity) AS completedSales
FROM orders o
JOIN orderitem oi ON o.OrderID = oi.OrderID
JOIN items it ON oi.itemID = it.itemID
WHERE o.Status = 'Completed'
";

// Function to execute query and return the sum result
function getSalesSum($conn, $query) {
    $result = $conn->query($query);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['totalSales'] ?? $row['pendingSales'] ?? $row['completedSales'] ?? 0;
    }
    return 0;
}

// Display Total Sales
$totalSales = getSalesSum($conn, $totalSalesQuery);
echo "<h2>Total Sales: P" . number_format($totalSales, 2) . "</h2>";

// Display Pending Sales
$pendingSales = getSalesSum($conn, $pendingSalesQuery);
echo "<h2>Pending Sales: P" . number_format($pendingSales, 2) . "</h2>";

// Display Completed Sales
$completedSales = getSalesSum($conn, $completedSalesQuery);
echo "<h2>Completed Sales: P" . number_format($completedSales, 2) . "</h2>";

// Fetch Sales Data
$totalSales = getSalesSum($conn, $totalSalesQuery);
$pendingSales = getSalesSum($conn, $pendingSalesQuery);
$completedSales = getSalesSum($conn, $completedSalesQuery);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Sales Overview</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f7f7f7;">
   

<h2 style="color: #444; margin-top: 20px;">Sales Overview</h2>
        <div style="width: 100%; max-width: 1200px; margin: 20px auto; padding: 10px; background-color: #ececec; border-radius: 5px;">
            <canvas id="salesChart"></canvas>
        </div>

    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Sales', 'Pending Sales', 'Completed Sales'],
                datasets: [{
                    label: 'Sales Data',
                    data: [<?php echo $totalSales; ?>, <?php echo $pendingSales; ?>, <?php echo $completedSales; ?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)', // Blue for total sales
                        'rgba(255, 206, 86, 0.6)', // Yellow for pending sales
                        'rgba(75, 192, 192, 0.6)'  // Green for completed sales
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Sales Data'
                    }
                }
            }
        });
    </script>






        </section>





        </section>

        <section id="inventory-management">
            <h3>Inventory Management</h3>
            <p>Keep your inventory up-to-date. Track stock levels, set up notifications for low inventory, and update product availability.</p>
        </section>

        <section id="review-management">
            <h3>Review Management</h3>
            <p>Manage customer reviews here. Approve, reply to, or delete reviews to maintain a positive and engaging shopping experience.</p>

            <?php
            // Include database connection
            include 'db_connection.php';

            // SQL to fetch clientid and rating from reviews
            $sql = "SELECT clientid, rating FROM reviews";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
    // Output data of each row
            echo "<table></th><th>Rating</th></tr>";
            while($row = $result->fetch_assoc()) {
            echo "</td><td>".$row["rating"]."</td></tr>";
            }
            echo "</table>";
            } else {
            echo "0 results";
            }

// Close connection
$conn->close();
?>

        </section>

        <section id="contact-management">
            <h3>Contact Management</h3>
            <p>This section allows you to view and manage customer inquiries. Respond to questions, provide support, and maintain customer satisfaction.</p>
            <?php
include('db_connection.php'); // Ensure this file properly opens a connection to your database

// Fetch messages from the database
$query = "SELECT message_id, fullname, email, msg FROM messages ORDER BY message_id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages Management</title>
</head>
<body>
    <h2>Messages Overview</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Message ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['message_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['msg']); ?></td>
                    <td>
                        <!-- Email Sending Form -->
                        <form action="send_email.php" method="post">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
    <input type="hidden" name="message_id" value="<?php echo htmlspecialchars($row['message_id']); ?>">
    <textarea name="customMessage" placeholder="Type your message here..."></textarea>
    <input type="submit" value="Send Email">
</form>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>

       
        </section>

        <section id="order-management">
            <h3>Order Management</h3>
            <p>Manage all customer orders from this panel. View order details, update order status, and handle returns and refunds efficiently.</p>

            <?php
// Include your database connection
include 'db_connection.php';

// SQL query to fetch orders and related information
$sql = "SELECT o.OrderID, o.OrderDate, o.Status, o.shippingmethod, ca.CartID,  
i.ItemName, pi.ImageURL, oi.order_quantity, 
(oi.order_quantity * i.Price) AS TotalPrice, 
CONCAT(ca.firstname, ' ', ca.lastname, ' ', ca.address, ' ', ca.City, ' ', ca.zipcode, ' ', ca.Country) AS CheckoutAddress 
FROM orders o
JOIN orderitem oi ON o.OrderID = oi.OrderID
JOIN items i ON oi.ItemID = i.ItemID
JOIN productimages pi ON i.ItemID = pi.ItemID
JOIN checkout_address ca ON o.CartID = ca.CartID
"; // Example condition, adjust as needed

$result = $conn->query($sql);
?>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Item Name</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Checkout Address</th>
            <th>Shipping Method</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["OrderID"]."</td>
                        <td>".$row["ItemName"]."</td>
                        <td><img src='".$row["ImageURL"]."' alt='Item Image'></td>
                        <td>".$row["order_quantity"]."</td>
                        <td>".$row["TotalPrice"]."</td>
                        <td>".$row["CheckoutAddress"]."</td>
                        <td>".$row["shippingmethod"]."</td>
                        <td>".$row["OrderDate"]."</td>
                        <td>".$row["Status"]."</td>
                        <td>
                            <form action='update_order_status.php' method='post'>
                                <input type='hidden' name='OrderID' value='".$row["OrderID"]."'>
                                <select name='Status'>
                                    <option value='Pending'>Pending</option>
                                    <option value='Completed'>Completed</option>
                                    <option value='Cancelled'>Cancelled</option>
                                    <option value='Awaiting Payment'>Awaiting Payment</option>
                                </select>
                                <input type='submit' value='Update'>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No orders found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    </section>
    </div>


   <!--==================== FOOTER ====================-->
   <footer class="footer">
      <div class="container">
          <div class="row">
              <div class="footer-col">
                  <h4>shop</h4>
                  <ul>
                      <li><a href="#">women's</a></li>
                      <li><a href="#">Men’s</a></li>
                      <li><a href="#">Kids</a></li>
                      <li><a href="#">Shoes</a></li>
                      <li><a href="#">Equipment</a></li>
                      <li><a href="#">Sale</a></li>
                  </ul>
              </div>
  
              <div class="footer-col">
                  <h4>online shop</h4>
                  <ul>
                      <li><a href="index.php">home</a></li>
                      <li><a href="shoppageNU.php">shop</a></li>
                      <li><a href="faqNU.php">faq</a></li>
                      <li><a href="aboutNU.php">about</a></li>
                      <li><a href="contactusNU.php">contacts</a></li>
                  </ul>
              </div>
              <div class="footer-col">
                  <h4>Our Socials</h4>
                  <div class="social-links">
                  <a href="https://www.facebook.com/profile.php?id=61557223593248&mibextid=ZbWKwL" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.tiktok.com%2F%40lumina709%3F_t%3D8kc4GXRGjTu%26_r%3D1%26fbclid%3DIwAR2oLsD6n7riF7SpHY52qjH4VFRZiY165ZHE3IDkTv7y67RUlF7iZxnrOQE&h=AT3e0D4yO_v4HrD53zTblAqC-omfimEI_500LIeoywQYavsgjT-sOE6KGhv9LmhB_iJ6c9Z2KQKRvq2r9oowWDcw5XhZBGGN_Zr5ahaOt69HvCulUL-P7FGidQNLKRxfW-nBoA"  target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                  <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.instagram.com%2Flumi.naaaaaa%3Figsh%3DbmkyOHh2eXU3eGdn%26fbclid%3DIwAR3-VEFjNp2eaQiSbgbS4fHLhuLuAHIJl14KHzwqwsmPhiGyqtW5BVWMm_Y&h=AT3e0D4yO_v4HrD53zTblAqC-omfimEI_500LIeoywQYavsgjT-sOE6KGhv9LmhB_iJ6c9Z2KQKRvq2r9oowWDcw5XhZBGGN_Zr5ahaOt69HvCulUL-P7FGidQNLKRxfW-nBoA"  target="_blank"><i class="fab fa-instagram"></i></a>
              </div>
              </div>
          </div>
      </div>
 </footer>
 
 <div class="loader-container">
        <div class="loader">
            <div class="truckWrapper">
              <div class="truckBody">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 198 93"
                  class="trucksvg"
                >
                  <path
                    stroke-width="3"
                    stroke="#282828"
                    fill="#F83D3D"
                    d="M135 22.5H177.264C178.295 22.5 179.22 23.133 179.594 24.0939L192.33 56.8443C192.442 57.1332 192.5 57.4404 192.5 57.7504V89C192.5 90.3807 191.381 91.5 190 91.5H135C133.619 91.5 132.5 90.3807 132.5 89V25C132.5 23.6193 133.619 22.5 135 22.5Z"
                  ></path>
                  <path
                    stroke-width="3"
                    stroke="#282828"
                    fill="#7D7C7C"
                    d="M146 33.5H181.741C182.779 33.5 183.709 34.1415 184.078 35.112L190.538 52.112C191.16 53.748 189.951 55.5 188.201 55.5H146C144.619 55.5 143.5 54.3807 143.5 53V36C143.5 34.6193 144.619 33.5 146 33.5Z"
                  ></path>
                  <path
                    stroke-width="2"
                    stroke="#282828"
                    fill="#282828"
                    d="M150 65C150 65.39 149.763 65.8656 149.127 66.2893C148.499 66.7083 147.573 67 146.5 67C145.427 67 144.501 66.7083 143.873 66.2893C143.237 65.8656 143 65.39 143 65C143 64.61 143.237 64.1344 143.873 63.7107C144.501 63.2917 145.427 63 146.5 63C147.573 63 148.499 63.2917 149.127 63.7107C149.763 64.1344 150 64.61 150 65Z"
                  ></path>
                  <rect
                    stroke-width="2"
                    stroke="#282828"
                    fill="#FFFCAB"
                    rx="1"
                    height="7"
                    width="5"
                    y="63"
                    x="187"
                  ></rect>
                  <rect
                    stroke-width="2"
                    stroke="#282828"
                    fill="#282828"
                    rx="1"
                    height="11"
                    width="4"
                    y="81"
                    x="193"
                  ></rect>
                  <rect
                    stroke-width="3"
                    stroke="#282828"
                    fill="#DFDFDF"
                    rx="2.5"
                    height="90"
                    width="121"
                    y="1.5"
                    x="6.5"
                  ></rect>
                  <rect
                    stroke-width="2"
                    stroke="#282828"
                    fill="#DFDFDF"
                    rx="2"
                    height="4"
                    width="6"
                    y="84"
                    x="1"
                  ></rect>
                </svg>
              </div>
              <div class="truckTires">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 30 30"
                  class="tiresvg"
                >
                  <circle
                    stroke-width="3"
                    stroke="#282828"
                    fill="#282828"
                    r="13.5"
                    cy="15"
                    cx="15"
                  ></circle>
                  <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
                </svg>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 30 30"
                  class="tiresvg"
                >
                  <circle
                    stroke-width="3"
                    stroke="#282828"
                    fill="#282828"
                    r="13.5"
                    cy="15"
                    cx="15"
                  ></circle>
                  <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
                </svg>
              </div>
              <div class="road"></div>
          
              <svg
                xml:space="preserve"
                viewBox="0 0 453.459 453.459"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns="http://www.w3.org/2000/svg"
                id="Capa_1"
                version="1.1"
                fill="#000000"
                class="lampPost"
              >
                <path
                  d="M252.882,0c-37.781,0-68.686,29.953-70.245,67.358h-6.917v8.954c-26.109,2.163-45.463,10.011-45.463,19.366h9.993
          c-1.65,5.146-2.507,10.54-2.507,16.017c0,28.956,23.558,52.514,52.514,52.514c28.956,0,52.514-23.558,52.514-52.514
          c0-5.478-0.856-10.872-2.506-16.017h9.992c0-9.354-19.352-17.204-45.463-19.366v-8.954h-6.149C200.189,38.779,223.924,16,252.882,16
          c29.952,0,54.32,24.368,54.32,54.32c0,28.774-11.078,37.009-25.105,47.437c-17.444,12.968-37.216,27.667-37.216,78.884v113.914
          h-0.797c-5.068,0-9.174,4.108-9.174,9.177c0,2.844,1.293,5.383,3.321,7.066c-3.432,27.933-26.851,95.744-8.226,115.459v11.202h45.75
          v-11.202c18.625-19.715-4.794-87.527-8.227-115.459c2.029-1.683,3.322-4.223,3.322-7.066c0-5.068-4.107-9.177-9.176-9.177h-0.795
          V196.641c0-43.174,14.942-54.283,30.762-66.043c14.793-10.997,31.559-23.461,31.559-60.277C323.202,31.545,291.656,0,252.882,0z
          M232.77,111.694c0,23.442-19.071,42.514-42.514,42.514c-23.442,0-42.514-19.072-42.514-42.514c0-5.531,1.078-10.957,3.141-16.017
          h78.747C231.693,100.736,232.77,106.162,232.77,111.694z"
                ></path>
              </svg>
            </div>
          </div>
          
    </div>
    
  <!-- Include JavaScript for loader functionality -->
  <script>window.addEventListener('load', () => {
        // Hide the loader when the page is fully loaded
        const loaderContainer = document.querySelector('.loader-container');
        loaderContainer.style.display = 'none';
    });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const navItems = document.querySelectorAll('.nav__item a');
    const contentSections = document.querySelectorAll('.content section');
    
    function hideAllSections() {
        contentSections.forEach(section => section.style.display = 'none');
    }

    function removeActiveClass() {
        navItems.forEach(item => item.parentElement.classList.remove('active'));
    }

    function setActiveSectionFromHash() {
        const hash = window.location.hash;
        if (hash) {
            const matchingNavItem = Array.from(navItems).find(item => item.getAttribute('href') === hash);
            if (matchingNavItem) {
                hideAllSections();
                removeActiveClass();
                document.querySelector(hash).style.display = 'block';
                matchingNavItem.parentElement.classList.add('active');
            } else {
                contentSections[0].style.display = 'block';
                navItems[0].parentElement.classList.add('active');
            }
        } else {
            contentSections[0].style.display = 'block';
            navItems[0].parentElement.classList.add('active');
        }
    }

    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.hash = e.target.getAttribute('href');
            setActiveSectionFromHash();
        });
    });

    document.querySelectorAll('.open-modal').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const categoryId = e.target.getAttribute('data-id');
            fetchCategoryData(categoryId);
        });
    });

    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('open-item-modal-btn')) {
            event.preventDefault();
            const itemId = event.target.getAttribute('data-item-id');
            fetchItemDetailsAndOpenModal(itemId);
        }
    });


    document.querySelectorAll('.open-item-modal-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const itemId = this.getAttribute('data-item-id'); // Get the item ID
            fetchItemDetailsAndOpenModal(itemId); // Fetch item details and open the modal
        });
    });

    // Close modal when the close button is clicked
    document.querySelector('#updateItemModal .close-button').addEventListener('click', function() {
        document.getElementById('updateItemModal').style.display = 'none';
    });

    // Function to fetch item details and open the modal
    function fetchItemDetailsAndOpenModal(itemId) {
        fetch(`fetch_item_data.php?ItemID=${itemId}`)
            .then(response => response.json())
            .then(data => {
                // Populate the modal fields with the fetched data
                document.getElementById('updateItemID').value = itemId;
                document.getElementById('updateItemName').value = data.ItemName;
                document.getElementById('updateItemDescription').value = data.Description;
                document.getElementById('updateItemPrice').value = data.Price;
                document.getElementById('updateStockQuantity').value = data.stock_quantity;
                // Set the category select box
                document.getElementById('updateItemCategory').value = data.CategoryID;
                // Handle existing images display...
                const existingImagesContainer = document.getElementById('existingImages');
                existingImagesContainer.innerHTML = ''; // Clear current images
                if (data.ImageURLs && data.ImageURLs.length > 0) {
                    data.ImageURLs.forEach((imageUrl, index) => {
                        // Display each image and a delete button
                        const imageWrapper = document.createElement('div');
                        imageWrapper.innerHTML = `
                            <img src="${imageUrl}" style="max-width: 100px; max-height: 100px; margin-right: 5px;" />
                        `;
                        existingImagesContainer.appendChild(imageWrapper);
                    });
                }
                // Show the modal
                document.getElementById('updateItemModal').style.display = 'block';
            })
            .catch(error => console.error('Error fetching item details:', error));
    }



    function fetchCategoryData(categoryId) {
        fetch(`fetch_category_data.php?CategoryID=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('updateCategoryID').value = categoryId;
                document.getElementById('updateCategoryName').value = data.CategoryName;
                document.getElementById('updateDescription').value = data.Description;
                showModal('updateCategoryModal');
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
        const closeButton = modal.querySelector('.close-button');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }
        window.addEventListener('click', (event) => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    }

    document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-image-btn')) {
        event.preventDefault(); // Prevent the default form submission
        const button = event.target;
        const itemId = button.getAttribute('data-item-id');
        const imageId = button.getAttribute('data-image-id');
        deleteImage(itemId, imageId);
    }
});

function deleteImage(itemId, imageId) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }

    fetch('delete_image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ItemID: itemId, ImageID: imageId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Image deleted successfully.');
            location.reload(); // Or better, remove the image from the DOM
        } else {
            alert('Failed to delete image.');
        }
    })
    .catch(error => console.error('Error:', error));
}


    document.getElementById('updateCategoryForm').addEventListener('submit', submitUpdateForm);

    function submitUpdateForm(event) {
        event.preventDefault();
        const form = document.getElementById('updateCategoryForm');
        const formData = new FormData(form);
        fetch('update_category_form.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            alert("Category updated successfully.");
            const modal = document.getElementById('updateCategoryModal');
            modal.style.display = 'none';
        })
        .catch((error) => {
            console.error('Error:', error);
            alert("There was a problem with the update request.");
        });
    }


    fetch('fetch_category.php')
    .then(response => response.json())
    .then(categories => {
        const select = document.getElementById('itemCategory');
        categories.forEach(category => {
            const option = new Option(category.CategoryName, category.CategoryID);
            select.add(option);
        });
    })
    .catch(error => console.error('Error fetching categories:', error));

    window.addEventListener('hashchange', setActiveSectionFromHash);
    setActiveSectionFromHash();

    // Enhance sorting links to include the current hash when clicked
    document.querySelectorAll('th a').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            const href = this.getAttribute('href');
            const currentHash = window.location.hash;
            const newHref = `${href}${currentHash}`;
            window.location.href = newHref;
        });
    });
});
  // Function para magbukas ng iframe
  function openCalculator() {
        document.getElementById('calculator-container').style.display = 'block';
    }

    // Function para isara ang iframe
    function closeCalculator() {
        document.getElementById('calculator-container').style.display = 'none';
    }
console.log('Button clicked, item ID:', itemId);
</script>



</body>
</html>
