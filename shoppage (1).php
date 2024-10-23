

<?php
session_start();
include('db_connection.php');

$userLoggedIn = isset($_SESSION['email']);
// Verify if a user is logged in using the session email
if ($userLoggedIn) {
    $email = mysqli_real_escape_string($conn, $_SESSION['email']); // Sanitize the email

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc(); // Fetch the client data
        // Now you can use $client['username'], $client['email'], etc.
    } else {
        // Handle the case where no matching user is found
    }

    $stmt->close();
    
   }

// Handling login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Consider using password hashing and verification

    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ? AND password = ? LIMIT 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: shoppage.php");
        exit();
    } else {
        echo '<script>alert("Invalid email or password!");</script>';
    }
    $stmt->close();
}


//for counting cart items

$clientEmail = $_SESSION['email']; // Assuming the email is stored in the session

$stmt = $conn->prepare("SELECT clientid FROM client WHERE email = ?");
$stmt->bind_param("s", $clientEmail);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $clientID = $row['clientid'];
} else {
    echo "Client not found.";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close(); // Close the statement

// Corrected to use clientID
$stmt = $conn->prepare("
    SELECT SUM(ci.quantity) AS totalQuantity
    FROM cart_items ci
    JOIN cart c ON ci.CartID = c.CartID
    WHERE c.clientid = ?");
$stmt->bind_param("i", $clientID); // Use $clientID here instead of $clientEmail
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalQuantity = $row['totalQuantity'] ? $row['totalQuantity'] : 0; // Ensure we have a value
} else {
    // It's possible to have a cart but no items in it, so this message might be misleading.
    // You may want to handle this case differently, or ensure your logic accounts for empty carts.
    $totalQuantity = 0; // Assuming you want to set it to 0 if no items are found.
}



// Remember to close the statement and connection when you're done
$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina</title>
    <link rel="icon" href="pics/LuminaLogo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="shoppage (1).css">
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<body>
    
   <!--==================== HEADER ====================-->
 
   <header class="header" id="header">
   <marquee direction="right" direction="up">
      Sale Now! Limited Time Offer - Great Deals Await You. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sale Now! Limited Time Offer - Great Deals Await You.
      </marquee>
      <nav class="nav container">

         <a href="#" class="nav__logo">LUMINA</a>
      
         <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
               <li class="nav__item">
                  <a href="homelogedin.php" class="nav__link">Home</a>
               </li>

               <li class="nav__item">
                  <a href="shoppage (1).php" class="nav__link">Shop</a>
               </li>

               <li class="nav__item">
                  <a href="faq.php" class="nav__link">FAQ</a>
               </li>

               <li class="nav__item">
                  <a href="about.php" class="nav__link">About</a>
               </li>

               <li class="nav__item">
                  <a href="contactus.php" class="nav__link">Contacts</a>
               </li>
            </ul>

            <!-- Close button -->
            <div class="nav__close" id="nav-close">
               <i class="ri-close-line"></i>
            </div>
         </div>

         <div class="nav__actions">
    <!-- Search button -->
    <input type="text" id="searchInput" placeholder="Search">
<div id="searchResults"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script><script>
$(document).ready(function() {
    $('#searchInput').keyup(function() {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                url: "search.php",
                method: "GET",
                data: {searchQuery: query},
                success: function(data) {
                    $('#searchResults').html(data);
                }
            });
        } else {
            // Clear the search results if the input is empty
            $('#searchResults').html('');
        }
    });
});
</script>



    <!-- Dynamic login/logout button -->
    <?php if ($userLoggedIn): ?>
        <a href="logout.php" class="nav__link logout-link">
        <i class="ri-logout-box-r-line"></i>
        <span class="logout-text">Logout</span>
    </a>
        <a href="clientprofile.php" class="nav__link logout-link"><i class="ri-user-line"></i><span class="logout-text">Edit Profile</span></a>
    <?php endif; ?>

        <!-- Shopping cart -->

            <a href="cart.php">
        <i class="ri-shopping-cart-line nav__icon"></i>
        <span class="cart-item-count"><?php echo $totalQuantity;?></span>
        </a>


    <!-- Toggle button -->
    <div class="nav__toggle" id="nav-toggle">
       <i class="ri-menu-line"></i>
    </div>
</div>
      </nav>
   </header>

   <!--==================== SEARCH ====================-->
   <    


</div>

</body>
</html>

   <main>
   <?php
// Include your database connection file
include 'db_connection.php';

$query = "SELECT CategoryName, Description FROM categories";
$result = $conn->query($query);

if (!$result) {
    echo "Error fetching categories: " . $conn->error;
    exit;
}

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}
$result->free();

// Close the connection
$conn->close();

// Set default values for the first category
$firstCategoryName = $categories[0]['CategoryName'] ?? 'Select a Category';
$firstCategoryDescription = $categories[0]['Description'] ?? 'Please select a category to see items and description.';
?>

<div class="title">
    <h1 id="categoryTitle"><?php echo htmlspecialchars($firstCategoryName); ?></h1>
    <p id="categoryDescription"><?php echo htmlspecialchars($firstCategoryDescription); ?></p>
</div>
<div class="categoriescontainer">
    <div class="categories">
                <ol>
                    <?php foreach ($categories as $category): ?>
                        <li class="category-item" data-category="<?php echo htmlspecialchars($category['CategoryName']); ?>" data-title="<?php echo htmlspecialchars($category['CategoryName']); ?>" data-description="<?php echo htmlspecialchars($category['Description']); ?>" onclick="updateCategoryTitleAndDescription(this.getAttribute('data-title'), this.getAttribute('data-description'))">
                            <?php echo htmlspecialchars($category['CategoryName']); ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Sort By <b>Price</b>&nbsp;<i class="fa-solid fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <a href="#" onclick="sortItems('price')">Price</a>
                    <a href="#" onclick="sortItems('name')">Name</a>
                </div>
            </div>
</div>


        <div class="items" id= "categoryItems">
            
            <?php
   include ('db_connection.php');
    
    // Check conn
    if ($conn->connect_error) {
      die("conn failed: " . $conn->connect_error);
    }
    
    // SQL to fetch all images along with their items
    $sql = "SELECT i.ItemName, i.Description, i.Price, i.stock_quantity, p.imageURL, i.itemID
            FROM items i
            JOIN productimages p ON i.itemID = p.itemID
            ORDER BY i.itemID, p.imageID"; // Assuming 'imageID' is a unique identifier for images
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
            "stock_quantity" => $row["stock_quantity"],
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
        echo "<div class='quantity-controls'>";

        echo "</div>";
        echo "<div class='heartcart'>";
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
        echo "<form action='add_to_cart.php' method='post'>";
        echo "<input type='hidden' name='item_id' value='" . $itemID . "'>";

        echo "<button type='submit' name='add_to_cart' class='cart-icon-btn'>";
        echo "<i class='fa-solid fa-cart-shopping fa-xl'></i>";
        echo "</button>";
        echo ("Quantity: ")."<input type='number' name='quantity' id='quantity_" . $itemID . "' value='1' min='1' max='" . $item["stock_quantity"] . "' data-stock-quantity='" . $item["stock_quantity"] . "' class='quantity-input'>";

        echo "</form>";
        echo "</div>";
        // Add to cart form
        

        
    
        echo "</div>"; // Close .boxes

    }
    
    } else {
      echo "0 results";
    }
    $conn->close();
    ?>
    
</div>

   </main>
  

  
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
                  <h4>follow us</h4>
                  <div class="social-links">
                  <a href="https://www.facebook.com/profile.php?id=61557223593248&mibextid=ZbWKwL" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.tiktok.com%2F%40lumina709%3F_t%3D8kc4GXRGjTu%26_r%3D1%26fbclid%3DIwAR2oLsD6n7riF7SpHY52qjH4VFRZiY165ZHE3IDkTv7y67RUlF7iZxnrOQE&h=AT3e0D4yO_v4HrD53zTblAqC-omfimEI_500LIeoywQYavsgjT-sOE6KGhv9LmhB_iJ6c9Z2KQKRvq2r9oowWDcw5XhZBGGN_Zr5ahaOt69HvCulUL-P7FGidQNLKRxfW-nBoA"  target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                  <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.instagram.com%2Flumi.naaaaaa%3Figsh%3DbmkyOHh2eXU3eGdn%26fbclid%3DIwAR3-VEFjNp2eaQiSbgbS4fHLhuLuAHIJl14KHzwqwsmPhiGyqtW5BVWMm_Y&h=AT3e0D4yO_v4HrD53zTblAqC-omfimEI_500LIeoywQYavsgjT-sOE6KGhv9LmhB_iJ6c9Z2KQKRvq2r9oowWDcw5XhZBGGN_Zr5ahaOt69HvCulUL-P7FGidQNLKRxfW-nBoA"  target="_blank"><i class="fab fa-instagram"></i></a>
              </div>
              </div>
          </div>
      </div>
 </footer>
</body>
</html>

<script>
   /*=============== SHOW MENU ===============*/
   const navMenu = document.getElementById('nav-menu'),
       navToggle = document.getElementById('nav-toggle'),
       navClose = document.getElementById('nav-close')

   /* Menu show */
   navToggle.addEventListener('click', () => {
       navMenu.classList.add('show-menu')
   })

   /* Menu hidden */
   navClose.addEventListener('click', () => {
       navMenu.classList.remove('show-menu')
   })

   /*=============== SEARCH ===============*/
   const search = document.getElementById('search'),
       searchBtn = document.getElementById('search-btn'),
       searchClose = document.getElementById('search-close')

   /* Search show */
   searchBtn.addEventListener('click', () => {
       search.classList.add('show-search')
   })

   /* Search hidden */
   searchClose.addEventListener('click', () => {
       search.classList.remove('show-search')
   })


   
function updateCategoryTitleAndDescription(title, description) {
    document.getElementById('categoryTitle').innerText = title;
    document.getElementById('categoryDescription').innerText = description;
}

function sortItems(sortBy) {
    fetch(`fetch_items.php?sort=${sortBy}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('categoryItems').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
}



/*---------------hover change-
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            const category = this.dataset.category;
            const title = this.dataset.title;
            const description = this.dataset.description;

            document.getElementById('categoryTitle').textContent = title;
            document.getElementById('categoryDescription').textContent = description;

            fetch(`fetch_image_categories.php?category=${category}`)
                .then(response => response.json())
                .then(images => {
                    const itemsContainer = document.getElementById('categoryItems');
                    itemsContainer.innerHTML = ''; // Clear current items
                    images.forEach(image => {
                        // Create the boxes div
                        const boxDiv = document.createElement('div');
                        boxDiv.className = 'boxes'; // Apply the same class as your current structure

                        // Create the img element
                        const imgElement = document.createElement('img');
                        imgElement.src = image;
                        imgElement.alt = 'Image'; // Consider extracting a more meaningful alt text if possible
                        imgElement.className = 'yourImageClass'; // Add your CSS class for images here

                        // Extract a human-readable title from the image filename
                        const imageName = image.substring(image.lastIndexOf('/') + 1).split('.')[0].replace(/-/g, ' ').replace(/_/g, ' ');
                        const imageTitle = imageName.charAt(0).toUpperCase() + imageName.slice(1);

                        // Create the h4 element for the image title
                        const titleElement = document.createElement('h4');
                        titleElement.textContent = imageTitle;

                        // Optionally, create a paragraph for additional details (e.g., price or description)
                        // This example uses the filename as a description; adjust as needed
                        const descElement = document.createElement('p');
                        

                        // Append the img and h4 elements to the boxDiv
                        boxDiv.appendChild(imgElement);
                        boxDiv.appendChild(titleElement);
                        boxDiv.appendChild(descElement); // If you're using a description or price

                        // Append the boxDiv to the items container
                        itemsContainer.appendChild(boxDiv);
                    });
                })
                .catch(error => console.error('Error fetching images:', error));
        });
    });
});
------------

document.addEventListener('DOMContentLoaded', function() {
    var minusButtons = document.querySelectorAll('.minusBtn');
    var plusButtons = document.querySelectorAll('.plusBtn');
    var numberElements = document.querySelectorAll('.number');

    minusButtons.forEach(function(minusButton, index) {
        minusButton.addEventListener('click', function() {
            var number = parseInt(numberElements[index].textContent);
            // Surin kung ang bilang ay mas mababa sa 1 bago bawasan
            if (number > 0) {
                number--;
                numberElements[index].textContent = number;
            }
        });
    });

    plusButtons.forEach(function(plusButton, index) {
        plusButton.addEventListener('click', function() {
            var number = parseInt(numberElements[index].textContent);
            // Pahintulutan ang pagdaragdag kahit anong bilang
            number++;
            numberElements[index].textContent = number;
        });
    });
});
   */

   function incrementQuantity(quantityId) {
    var input = document.getElementById(quantityId);
    var currentValue = parseInt(input.value, 10);
    input.value = currentValue + 1;
}

function decrementQuantity(quantityId) {
    var input = document.getElementById(quantityId);
    var currentValue = parseInt(input.value, 10);
    if (currentValue > 1) { // Prevent quantity from going below 1
        input.value = currentValue - 1;
    }
}

</script>
</body>
</html>