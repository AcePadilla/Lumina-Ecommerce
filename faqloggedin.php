
<?php
session_start();
include('db_connection.php');

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = safe_escape($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM client WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['email'] = $email;
        header("Location: shoppage.php");
        exit();
    } else {
        echo '<script>alert("Invalid email or password!");</script>';
    }
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = safe_escape($conn, $_POST['username']);
    $email = safe_escape($conn, $_POST['email']);
    $password = $_POST['password']; 

    $query = "INSERT INTO client (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($query) === TRUE) {
        echo '<script>alert("Registration successful!");</script>';
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['full_name'], $_POST['email'], $_POST['msg'])) {
    $full_name = safe_escape($conn, $_POST['full_name']);
    $email = safe_escape($conn, $_POST['email']);
    $msg = safe_escape($conn, $_POST['msg']);

    $sql = "INSERT INTO messages (full_name, email, msg) VALUES ('$full_name', '$email', '$msg')";

    if ($conn->query($sql) === TRUE) {
        // Message successfully inserted
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}// Handle rating submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rate'])) {
    $rating = safe_escape($conn, $_POST['rate']);
    $query = "INSERT INTO reviews (rating) VALUES ('$rating')";
    if ($conn->query($query) === TRUE) {
        // Determine thank you message based on rating  
        $thank_you_message = "";
        switch ($rating) {
            case '1':
                $thank_you_message = "We're sorry to hear that you had a poor experience. We'll do our best to improve.";
                break;
            case '2':
                $thank_you_message = "Thank you for your feedback. We'll take it into consideration for future improvements.";
                break;
            case '3':
                $thank_you_message = "Thank you! We're glad you had an average experience. We'll strive to make it better.";
                break;
            case '4':
                $thank_you_message = "Thank you! We're glad you had a good experience. We hope to serve you again soon.";
                break;
            case '5':
                $thank_you_message = "Wow! Thank you for your amazing feedback. We're thrilled you had a fantastic experience!";
                break;
            default:
                $thank_you_message = "Thank you for your feedback!";
                break;
        }
        // Output the thank you message inside the div with ID "thankYouMessage"
        echo '<script>document.getElementById("thankYouMessage").innerHTML = "' . $thank_you_message . '";</script>';
        echo '<script>document.getElementById("thankYouMessage").style.display = "block";</script>';
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Close the database connection
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
    <link rel="stylesheet" href="faq.css">
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                <!-- Search button -->
                <i class="ri-search-line nav__search" id="search-btn"></i>

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

   <!--==================== LOGIN ====================-->
   <div class="login" id="login">
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login__form">
    <img src="pics/login.png - .png">

    <div class="login__group">
        <div>
            <label for="email" class="login__label">Email</label>
            <input type="email" placeholder="Write your email" id="email" name="email" class="login__input">
        </div>

        <div>
            <label for="password" class="login__label">Password</label>
            <input type="password" placeholder="Enter your password" id="password" name="password" class="login__input">
        </div>
    </div>
    
    <div>
        <p class="login__signup">
            You do not have an account? <a href="#" class="login-signup-link">Sign up</a>
        </p>

        <a href="#" class="login__forgot">
            You forgot your password
        </a>

        <button type="submit" class="login__button" name="login">Log In</button>
        <!-- Add a hidden input field for registration -->
        <input type="hidden" name="register" value="1">
    </div>
    <div class="g-recaptcha" data-sitekey="6LeZU5wpAAAAAJuZ5FdabJUty1q3-FWOLfrcyeth"></div>
</form>


    <i class="ri-close-line login__close" id="login-close"></i>
 </div>
   <main>
    <h1>FAQ</h1>
            
            <section class="card">
                <!-- cube img -->
                <!-- Images -->
                <div class="card__img">
                  <!-- mobile -->
                  <img class="card__img-mobile" src="pics/faq.png" alt="Faq Image">
                  
                  <img class="card__img-desktop" src="pics/faq.png" alt="Woman online desktop">
                </div>
                <!-- Text -->
                <div class="card__text">
            
                  <div class="accordion">
                    <!-- item 1 -->
                    <div class="accordion__item">
                      <button class="accordion__title">
                          How do I place an order?
                      </button>
      
                      <div class="accordion__collapse collapse">
                          <div class="accordion__text">
                              <p>To place an order, simply browse through our catalog, select the items you want to purchase, add them to your shopping cart, and proceed to checkout. Follow the prompts to complete your order.</p>
                          </div>
                      </div>
                  </div>
                  <!-- item 2 -->
                  <div class="accordion__item">
                      <button class="accordion__title">
                          What payment methods do you accept?
                      </button>
      
                      <div class="accordion__collapse collapse">
                          <div class="accordion__text">
                              <p>We accept various payment methods, including credit/debit cards, bank transfers, and cash on delivery (COD). You can choose the payment option that suits you best during checkout.</p>
                          </div>
                      </div>
                  </div>
                  <!-- item 3 -->
                  <div class="accordion__item">
                      <button class="accordion__title">
                          How long will it take to receive my order?
                      </button>
      
                      <div class="accordion__collapse collapse">
                          <div class="accordion__text">
                              <p>Delivery times may vary depending on your location and the shipping method selected. Typically, orders are delivered within 3-5 business days. You can track your order using the provided tracking number.</p>
                          </div>
                      </div>
                  </div>
                  <!-- item 4 -->
                  <div class="accordion__item">
                      <button class="accordion__title">
                          Can I return or exchange an item?
                      </button>
      
                      <div class="accordion__collapse collapse">
                          <div class="accordion__text">
                              <p>Yes, we have a hassle-free return and exchange policy. If you're not satisfied with your purchase or if there's a defect with the item, you can return it within 30 days for a full refund or exchange.</p>
                          </div>
                      </div>
                  </div>
                  <!-- item 5 -->
                  <div class="accordion__item">
                      <button class="accordion__title">
                          How can I contact customer support?
                      </button>
      
                      <div class="accordion__collapse collapse">
                          <div class="accordion__text">
                              <p>Our customer support team is available 24/7 to assist you with any inquiries or concerns. You can reach us chat, email, or social links. We're here to help!</p>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

           
              <h3>How was your experience?</h3>
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="rating">
                    <input value="5" name="rate" id="star5" type="radio">
                    <label title="text" for="star5"></label>
                    <input value="4" name="rate" id="star4" type="radio">
                    <label title="text" for="star4"></label>
                    <input value="3" name="rate" id="star3" type="radio" checked="">
                    <label title="text" for="star3"></label>
                    <input value="2" name="rate" id="star2" type="radio">
                    <label title="text" for="star2"></label>
                    <input value="1" name="rate" id="star1" type="radio">
                    <label title="text" for="star1"></label>
                </div>
             
                <button type="submit" class="button1">
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                        </svg>
                        </div>
                    </div>
                     <span>Submit Rating</span>
                </button>
            </form>
   </main>
   
   <!-------------------Sign up----------------------->

   <div class="signup" id="signup-modal">
    <div class="signup-content">
        <img src="pics/signup.png" alt="signup image">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signup-form">
            <div class="row1">
                <label for="username" class="signup-label">Username</label>
                <input type="text" placeholder="Choose a username" id="username" name="username" class="signup-input">

                <label for="email" class="signup-label">Email</label>
                <input type="email" placeholder="Enter your email" id="email" name="email" class="signup-input">

                <label for="password" class="signup-label">Password</label>
                <input type="password" placeholder="Enter your password" id="password" name="password" class="signup-input">
            </div>
            <button type="submit" class="register__button" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="#" class="signup-login-link">Login</a></p>
        <div class="g-recaptcha" data-sitekey="6LeZU5wpAAAAAJuZ5FdabJUty1q3-FWOLfrcyeth"></div>
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

   document.addEventListener(function () {
                const passwordInput = document.getElementById("passwordInput");
                const togglePassword = document.getElementById("togglePassword");

                togglePassword.addEventListener("click", function () {
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        togglePassword.classList.remove("fa-eye");
                        togglePassword.classList.add("fa-eye-slash");
                    } else {
                        passwordInput.type = "password";
                        togglePassword.classList.remove("fa-eye-slash");
                        togglePassword.classList.add("fa-eye");
                    }
                });
            });
</script>

<script>
   const accordionBtns = document.querySelectorAll(".accordion__title");

accordionBtns.forEach((button) => {
  button.addEventListener("click", (event) => {
    let accCollapse = button.nextElementSibling;

    if (!button.classList.contains("collapsing")) {
      // open accordion item
      if (!button.classList.contains("open")) {
        accCollapse.style.display = "block";
        let accHeight = accCollapse.clientHeight;

        setTimeout(() => {
          accCollapse.style.height = accHeight + "px";
          accCollapse.style.display = "";
        }, 1);

        accCollapse.classList = "accordion__collapse collapsing";

        setTimeout(() => {
          accCollapse.classList = "accordion__collapse collapse open";
        }, 300);
      }
      //close accordion item
      else {
        accCollapse.classList = "accordion__collapse collapsing";

        setTimeout(() => {
          accCollapse.style.height = "0px";
        }, 1);  

        setTimeout(() => {
          accCollapse.classList = "accordion__collapse collapse";
          accCollapse.style.height = "";
        }, 300);
      }

      button.classList.toggle("open");
    }
  });
});

</script>
</body>
</html>






