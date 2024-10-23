<?php
include('db_connection.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Login
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password']; // This will be verified against the hash

        $query = "SELECT clientid, password FROM client WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify password against hash stored in database
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['clientid'] = $row['clientid'];

                header("Location: shoppage (1).php");
                exit();
            } else {
                echo '<script>alert("Invalid email or password!");</script>';
            }
        } else {
            echo '<script>alert("Invalid email or password!");</script>';
        }
    }
    // Registration
    elseif (isset($_POST['register'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); // Not recommended: Storing plaintext passwords

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO client (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Registration successful!");</script>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } 
    // Insert message
    elseif (isset($_POST['full_name']) && isset($_POST['email']) && isset($_POST['msg'])) {
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $msg = mysqli_real_escape_string($conn, $_POST['msg']);

        $sql = "INSERT INTO messages (fullname, email, msg) VALUES ('$full_name', '$email', '$msg')";

        if (mysqli_query($conn, $sql)) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina</title>
    <link rel="icon" href="pics/LuminaLogo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="shoppageNU.css">
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                  <a href="index.php" class="nav__link">Home</a>
               </li>

               <li class="nav__item">
                  <a href="shoppageNU.php" class="nav__link">Shop</a>
               </li>

               <li class="nav__item">   
               <a href="faqNU.php" class="nav__link">FAQ</a>
               </li>

               <li class="nav__item">
                  <a href="aboutNU.php" class="nav__link">About</a>
               </li>

               <li class="nav__item">
                  <a href="contactusNU.php" class="nav__link">Contacts</a>
               </li>
            </ul>


           
            <!-- Close button -->
            <div class="nav__close" id="nav-close">
               <i class="ri-close-line"></i>
            </div>
         </div>

         <div class="nav__actions">
                     <!-- Search button -->
                     <i class="ri-search-line nav__search" id="search-btn"></i>

            <!-- Login button -->
            <i class="ri-user-line nav__login" id="login-btn"></i>

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

   <!--==================== LOGIN ====================-->
   <div class="login" id="login">
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login__form" onsubmit="return validateForm()">
    <img src="pics/login.png - .png">

    <div class="login__group">
        <div>
            <label for="email" class="login__label">Email</label>
            <input type="email" placeholder="Write your email" id="email" name="email" class="login__input" required>
        </div>

        <div>
            <label for="password" class="login__label">Password</label>
            <input type="password"  placeholder="Enter your password" id="password" name="password" class="login__input" required>
        </div>
    </div>

    <div>
        <p class="login__signup">
            You do not have an account? <a href="#" class="login-signup-link">Sign up</a>
        </p>

        <a href="#" id="forgot-password-trigger" class="login__forgot">
            You forgot your password
        </a>
        <div id="forgot-password-modal" class="modal" style="display:none;">
            <div class="modal-content">
                <span id="forgot-password-close" class="close-button"><i class="fa-solid fa-x"></i></span>
                <iframe src="forgot.php" frameborder="0" style="width: 100%; height: 100%;"></iframe>
            </div>
        </div>

        <button type="submit" class="login__button" name="login">Log In</button>
        <div class="g-recaptcha" data-sitekey="6LeZU5wpAAAAAJuZ5FdabJUty1q3-FWOLfrcyeth" onclick=""></div>

        <!-- Add a hidden input field for registration -->
        <input type="hidden" name="register" value="1">
    </div>
    <a class="admin" href="adminlogin.php">Admin Login</a>
</form>


    <i class="ri-close-line login__close" id="login-close"></i>
 </div>

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
  
   <!--==================== SEARCH ====================-->
   <div class="search" id="search">
      <form action="" class="search__form">
         <i class="ri-search-line search__icon"></i>
         <input type="search" placeholder="What are you looking for?" class="search__input">
      </form>

      <i class="ri-close-line search__close" id="search-close"></i>
   </div>

   <!--==================== LOGIN ====================-->
   <div class="login" id="login">
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login__form" onsubmit="return validateForm()">
    <img src="pics/login.png - .png">

    <div class="login__group">
        <div>
            <label for="email" class="login__label">Email</label>
            <input type="email" placeholder="Write your email" id="email" name="email" class="login__input" required>
        </div>

        <div>
            <label for="password" class="login__label">Password</label>
            <input type="password"  placeholder="Enter your password" id="password" name="password" class="login__input" required>
        </div>
    </div>

    <div>
        <p class="login__signup">
            You do not have an account? <a href="#" class="login-signup-link">Sign up</a>
        </p>

        <a href="forgot.php" class="login__forgot">
            You forgot your password
        </a>

        <button type="submit" class="login__button" name="login">Log In</button>
        <div class="g-recaptcha" data-sitekey="6LeZU5wpAAAAAJuZ5FdabJUty1q3-FWOLfrcyeth" onclick=""></div>

        <!-- Add a hidden input field for registration -->
        <input type="hidden" name="register" value="1">
    </div>
</form>


    <i class="ri-close-line login__close" id="login-close"></i>
 </div>
   <!-------------------Sign up----------------------->
   <div class="signup" id="signup-modal">
    <div class="signup-content">
                <h2>Sign-Up</h2>
        <img src="pics/luminalogo-removebg-preview.png" alt="signup image">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="signup-form"  onclick="register()" >
            <div class="row1">
                <label for="username" class="signup-label">Username</label>
                <input type="text" placeholder="Choose a username" id="signup-username" name="username" class="signup-input" required>

                <label for="email" class="signup-label">Email</label>
                <input type="email" placeholder="Enter your email" id="signup-email" name="email" class="signup-input" required>

                <label for="password" class="signup-label">Password</label>
                <input type="password" placeholder="Enter your password" id="signup-password" name="password" class="signup-input" required>

                <label for="password" class="signup-label hidden" id="otp-label">OTP</label>
                <input type="text" placeholder="" id="signup-otp" name="otp" class="signup-input hidden" required>
            </div>
            <button type="button" class="register__button" name="register" onclick="signup()" >Register</button>
            <div class="g-recaptcha" data-sitekey="6LeZU5wpAAAAAJuZ5FdabJUty1q3-FWOLfrcyeth" onclick=""></div>
        </form>
        <p>Already have an account? <a href="#" class="signup-login-link">Login</a></p>
    </div>
    <i class="ri-close-line signup__close" id="signup-close"></i>
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
    
// recaptcha
 function validateForm() {
            var response = grecaptcha.getResponse();
            if (response.length === 0) {
                alert("Please complete the reCAPTCHA");
                return false;
            }
            return true;
        }
// recaptcha
// signup otp
 function signup() {

    var xmlhttp = new XMLHttpRequest();
    var data = new FormData();

    var username = document.getElementById("signup-username").value;
    var email = document.getElementById("signup-email").value;
    var password = document.getElementById("signup-password").value;
    var otp = document.getElementById("signup-otp").value;

    if(otp==""){
        data.append('register', '1');
        data.append('username', username);
        data.append('email', email);
        data.append('password', password);
        xmlhttp.open("POST", "signup.php", true);
        xmlhttp.send(data);
        document.getElementById("otp-label").classList.remove("hidden")
        document.getElementById("signup-otp").classList.remove("hidden")

        alert("OTP was send, please check your email");
    }else{
        data.append('verify_email', '');
        data.append('email', email);
        data.append('verification_code', otp);

        xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            alert(xmlhttp.responseText);
            if(xmlhttp.responseText == "Verified"){
                window.location.reload()
            }
        }
    }

        xmlhttp.open("POST", "email-verification.php", true);
        xmlhttp.send(data);

    }
    


    }
    // signup otp

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

   /*=============== LOGIN ===============*/
   const login = document.getElementById('login'),
       loginBtn = document.getElementById('login-btn'),
       loginClose = document.getElementById('login-close'),
       signupModal = document.getElementById('signup-modal'),
       signupClose = document.getElementById('signup-close')

   /* Login show */
   loginBtn.addEventListener('click', () => {
       login.classList.add('show-login')
   })

   /* Login hidden */
   loginClose.addEventListener('click', () => {
       login.classList.remove('show-login')
   })

   /* Show Sign Up Modal when Sign up link is clicked */
   
   const signupLink = document.querySelector('.login-signup-link');
   signupLink.addEventListener('click', (event) => {
       event.preventDefault(); // Prevent default action of link
       login.classList.remove('show-login'); // Hide the login modal
      
       signupModal.classList.add('show-signup'); // Corrected class name here
   });

   /* Close Sign Up Modal */
   signupClose.addEventListener('click', (event) => {
       event.preventDefault();
       signupModal.classList.remove('show-signup'); // Corrected class name here
   });

   const loginLink = document.querySelector('.signup-login-link');
   loginLink.addEventListener('click', (event) => {
       event.preventDefault(); // Prevent default action of link
       login.classList.add('show-login'); // Show the login modal
       signupModal.classList.remove('show-signup'); // Hide the sign-up modal
   });

   loginClose.addEventListener('click', () => {
       login.classList.remove('show-signup');
   })

</script>

<script>
document.getElementById('forgot-password-trigger').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default anchor behavior
    var modal = document.getElementById('forgot-password-modal'); // Get the modal
    modal.style.display = "block"; // Display the modal

    // Close the modal when the user clicks on <span> (x)
    modal.querySelector('.close-button').onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal if the user clicks anywhere outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});
document.getElementById('forgot-password-close').addEventListener('click', function() {
    document.getElementById('forgot-password-modal').style.display = 'none';
});

// Optional: Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('forgot-password-modal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>
</body>
</html>






