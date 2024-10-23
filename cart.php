<?php
session_start();
include('db_connection.php');

$userLoggedIn = isset($_SESSION['email']); // Check if user is logged in

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina</title>
    <link rel="icon" href="pics/LuminaLogo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="cart.css">
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
         <a href="about.html" class="nav__link">About</a>
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

<!-- Dynamic login/logout button -->
<?php if ($userLoggedIn): ?>
<a href="logout.php" class="nav__link logout-link">
<i class="ri-logout-box-r-line"></i>
<span class="logout-text">Logout</span>
</a>
<a href="clientprofile.php" class="nav__link logout-link"><i class="ri-user-line"></i><span class="logout-text">Profile</span></a>
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
<div class="search" id="search">
<form action="" class="search__form" method="get">
<i class="ri-search-line search__icon"></i>
<input type="search" name="search" placeholder="What are you looking for?" class="search__input" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
<button type="submit">Search</button>

</form>
<?php if (!empty($searchResults)): ?>
<div class="search-results">
<?php foreach ($searchResults as $item): ?>
   <div class="item">
       <?php if (!empty($item['imageURL'])): ?>
           <img src="<?php echo htmlspecialchars($item['imageURL']); ?>" alt="<?php echo htmlspecialchars($item['ItemName']); ?>">
       <?php endif; ?>
       <h3><?php echo htmlspecialchars($item['ItemName']); ?></h3>
       <p><?php echo htmlspecialchars($item['Description']); ?></p>
       <p>Price: $<?php echo htmlspecialchars($item['Price']); ?></p>
       <p>Stock Quantity: <?php echo htmlspecialchars($item['stock_quantity']); ?></p>
   </div>
<?php endforeach; ?>
</div>
<?php elseif (isset($_GET['search'])): ?>
<p>No results found for "<?php echo htmlspecialchars($_GET['search']); ?>".</p>
<?php endif; ?>
<i class="ri-close-line search__close" id="search-close"></i>


</div>

   
   <main>
    
   <?php

$email = $_SESSION['email']; // Example client ID from session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jra";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to include productimages and calculate total price
$stmt = $conn->prepare("
    SELECT it.itemID, it.CategoryID, it.ItemName, it.Description, it.Price, it.stock_quantity, ci.quantity, pi.imageURL, ci.Cart_Item_ID
    FROM items it
    JOIN cart_items ci ON it.itemID = ci.itemID
    JOIN Cart c ON ci.CartID = c.CartID
    JOIN productimages pi ON it.itemID = pi.itemID
    WHERE c.clientid = ?
    GROUP BY it.itemID");

$stmt->bind_param("i", $clientID);
$stmt->execute();
$result = $stmt->get_result();

$totalPrice = 0; // Initialize total price

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Calculate the total price for each item (price * quantity)
        $itemTotal = $row["Price"] * $row["quantity"];
        $totalPrice += $itemTotal; // Add to total price
        
        echo "<div class='itemcart'>";
        echo "<img src='" . $row["imageURL"] . "' alt='" . $row["ItemName"] . "' style='width:100px;'><br>"; // Adjust image size as needed
        echo "Item Name: " . $row["ItemName"] . "<br>Price: P" . $row["Price"] . "<br>Quantity in Cart: " . $row["quantity"] . "<br>Total: P" . $itemTotal . "<br>";
        // Buy Now Button
      
       
        echo "<form action='remove_from_cart.php' method='post'>";
        echo "<input type='hidden' name='Cart_Item_ID' value='" . $row['Cart_Item_ID'] . "'>";
        echo "<input type='submit' value='Remove from Cart'>";
        echo "</form>";

        echo "</div>";
        echo "</div>";
    }
    // Display total price
    echo "<div class='pricebutton'>";
    echo "<strong>Total Price: P" . $totalPrice . "</strong>";
    echo "<button onclick=\"location.href='checkout.php'\" class=\"buyNowButton\">Buy Now</button>";
  } else {
    echo "No items in cart";
}
echo "</div>";

$stmt->close();
$conn->close();
?>


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
                      <li><a href="homelogedin.php">home</a></li>
                      <li><a href="shoppage (1).php">shop</a></li>
                      <li><a href="faq.php">faq</a></li>
                      <li><a href="about.php">about</a></li>
                      <li><a href="contactus.php">contacts</a></li>
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
</body>
</html>
  <!-- Include JavaScript for loader functionality -->
  <script>window.addEventListener('load', () => {
    // Hide the loader when the page is fully loaded
    const loaderContainer = document.querySelector('.loader-container');
    loaderContainer.style.display = 'none';
});
</script>
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
/*---------------hover change-------------*/
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
</script>
</body>
</html>





