<?php
include 'db_connection.php'; 
session_start();
$userLoggedIn = isset($_SESSION['email']);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['full_name']) && isset($_POST['email']) && isset($_POST['msg'])) {
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

    $totalQuantity = 0;
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
    <link rel="stylesheet" href="homelogedin.css">
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<body>
   <!--==================== HEADER ====================-->
   <header class="header" id="header">
      <nav class="nav container">
         <a href="home.php" class="nav__logo">LUMINA</a>

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

<!-- Dynamic login/logout button -->
                    <a href="logout.php" class="nav__link logout-link">
            <i class="ri-logout-box-r-line"></i>
            <span class="logout-text">Logout</span>
        </a>
            <a href="clientprofile.php" class="nav__link logout-link"><i class="ri-user-line"></i><span class="logout-text">Profile</span></a>
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
      <form action="" class="search__form">
         <i class="ri-search-line search__icon"></i>
         <input type="search" placeholder="What are you looking for?" class="search__input">
      </form>

      <i class="ri-close-line search__close" id="search-close"></i>
   </div>
 </div>
   <main>
      <!--==================== TITLE ====================-->
      <div class="context">
         <h1>ENLIGHTENING YOUR LIFE</h1>
         <p>Discover the freshest additions to our inventory in Our Latest Arrivals where style meets innovation. Stay ahead of trends and elevate your shopping experience with our newest products.</p>
         <div class="shopnow">
                <a href="shoppage (1).php">Shop Now</a>
            </div>
   
      </div>
      <div class="mockups">
            <img src="pics/mockup.png" alt="image">
      </div>
   </main>
 
   <!--==================== ABOUT ====================-->
   <div class="about">
            <div class="aboutinfo">
                <div>
                    <h1>Our Mission</h1>
                    <p>is to deliver an extraordinary online shopping experience for our customers. We take pride in our extensive collection of products, ranging from everyday essentials to special gifts, ready to inspire and delight with every click.</p>
                </div>
              

                <img src="pics/aboutusvector2.png" alt="">
            </div>
       
            <div class="box-container">
                <div class="box"> 
                    <h2>Innovative</h2>
                    <i class="fa-solid fa-lightbulb fa-2xl"></i>
                    <p>We continuously lead by being inventive and changing our approaches to online shopping. We advocate for new ideas and solutions to provide our customers with an even more remarkable shopping experience.</p>
                </div>
                <div class="box">
                    <h2>Trendsetting</h2>
                    <i class="fa-solid fa-magnifying-glass fa-2xl"></i>
                    <p>As a trendsetting store, LUMINA offers products and styles that follow the latest trends in fashion, lifestyle, and technology. We stay ahead of the curve, ready to inspire and guide our customers in their clothing and lifestyle choices.</p>
                </div>
                <div class="box">
                    <h2>Reliable</h2>
                    <i class="fa-solid fa-circle-check fa-2xl"></i>
                    <p>Trust is at the core of everything we do. We are known for our dependable service and the quality of our products. To our customers, LUMINA is not just a store but a reliable partner in their online shopping needs.</p>
                </div>
            </div>
        </div>
  
        <section class="contact-section" id="contact">
    
            <h2 class="section-title">Contact Us</h2>
            <div class="contact-div">
                <div>
                    <img src="pics/vectorcontact.png" alt="">
                </div>
                <div class="contact__container bd-grid">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="text" name="full_name" placeholder="Name" class="contact__input" required>
                        <input type="mail"  name="email" placeholder="Email" class="contact__input" required>
                        <textarea name="msg" id="" cols="0" rows="10" class="contact__input"></textarea>
                        <button>
                            <div class="svg-wrapper-1">
                            <div class="svg-wrapper">
                                <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="24"
                                height="24"
                                >
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    fill="currentColor"
                                    d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                                ></path>
                                </svg>
                            </div>
                            </div>
                            <span>Send</span>
                        </button>
                    </form>
                </div>
            </div>
            
        </section>
 
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
                      <li><a href="home.php">home</a></li>
                      <li><a href="shoppage-1.php">shop</a></li>
                      <li><a href="faq.php">faq</a></li>
                      <li><a href="about.html">about</a></li>
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
</body>
</html>