<?php
session_start();
include ('db_connection.php');


$email = $conn->real_escape_string($_SESSION['email']);




// Fetch clientid, username, and profile data
$sql = "SELECT client.clientid, client.username, user_profiles.fullname, user_profiles.birthday, user_profiles.address, user_profiles.contact_number
        FROM client
        LEFT JOIN user_profiles ON client.clientid = user_profiles.clientid
        WHERE client.email = '$email'";

$result = $conn->query($sql);

$userData = [];

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "User not found";
    exit;
}

$clientid = $userData['clientid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $address = $conn->real_escape_string($_POST['address']);
    $contactNumber = $conn->real_escape_string($_POST['contactNumber']);

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

    exit();
}
// Close the statement

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
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina</title>
    <link rel="icon" href="pics/LuminaLogo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="editprofile.css">
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<body>
    
   <!--==================== HEADER ====================-->
 
   <header class="header" id="header">
      <nav class="nav container">

         <a href="#" class="nav__logo">LUMINA</a>
      
         <div class="nav__menu" id="nav-menu">
         <ul class="nav__list">
               <li class="nav__item">
                  <a href="home.php" class="nav__link">Home</a>
               </li>

               <li class="nav__item">
                  <a href="shoppage.php" class="nav__link">Shop</a>
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
            <!-- Search button -->
               
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
      <form action="" class="search__form">
         <i class="ri-search-line search__icon"></i>
         <input type="search" placeholder="What are you looking for?" class="search__input">
      </form>

      <i class="ri-close-line search__close" id="search-close"></i>
   </div>

   <main>
   <form action="editprofileback.php" id="editProfileForm" method="post" enctype="multipart/form-data">
    <h2>Edit Profile</h2>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo isset($userData['username']) ? htmlspecialchars($userData['username']) : ''; ?>" required>

    <label for="fullName">Full Name:</label>
    <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" value="<?php echo isset($userData['fullname']) ? htmlspecialchars($userData['fullname']) : ''; ?>" required>

    <label for="birthday">Birthday:</label>
    <input type="date" id="birthday" name="birthday" value="<?php echo isset($userData['birthday']) ? $userData['birthday'] : ''; ?>" required>

    <label for="address">Address:</label>
    <textarea id="address" name="address" placeholder="Enter your address" required><?php echo isset($userData['address']) ? htmlspecialchars($userData['address']) : ''; ?></textarea>

    <label for="contactNumber">Contact Number:</label>
    <input type="tel" id="contactNumber" name="contactNumber" placeholder="Enter your contact number" value="<?php echo isset($userData['contact_number']) ? htmlspecialchars($userData['contact_number']) : ''; ?>" required>

    <!-- Picture Upload Input -->
    <label for="profilePicture">Profile Picture:</label>
    <input type="file" id="profilePicture" name="profilePicture" accept="image/*" required>

    <button type="submit">Save Changes</button>
</form>

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

   /* Drag and drop image */

   function dragOverHandler(event) {
        event.preventDefault();
    }

    function dragEnterHandler(event) {
        event.preventDefault();
        document.getElementById('dropArea').classList.add('highlight');
    }

    function dragLeaveHandler(event) {
        event.preventDefault();
        document.getElementById('dropArea').classList.remove('highlight');
    }

    function dropHandler(event) {
        event.preventDefault();
        document.getElementById('dropArea').classList.remove('highlight');
        document.getElementById('dropArea').classList.add('has-image');

        var files = event.dataTransfer.files;
        handleFiles(files);
    }

    </script>
</body>
</html>