<?php
session_start();
include('db_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumina</title>
    <link rel="icon" href="pics/LuminaLogo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="aboutNU.css">
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
       <!--==================== ABOUT ====================-->
     
       <div class="about">
        <div class="aboutinfo">
            <div>
                <h1>Our Mission</h1>
                <p>Is to deliver an extraordinary online shopping experience for our customers. We take pride in our extensive collection of products, ranging from everyday essentials to special gifts, ready to inspire and delight with every click.</p>
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
    <h1 class="oes">Our Journey</h1>
    <div class="story">

     <div class="title">
       <p>
         In the midst of the battleground between technology and imagination, a dream sprouted—a dream to breathe life into a new form of online shopping. From the spark of inspiration, we embarked on the path of change. Every step was filled with determination and a dream to invigorate the world of ecommerce.</p>
       <div class="vertical-line">&nbsp;</div>
       <p>As time passed, challenges arose. But every obstacle was an opportunity to fortify our resolve. At every corner of the road, a dream surged towards our envisioned goal. Amidst the chaos, a light ignited—a bright idea that would set online shopping apart.</p>
       <div class="vertical-line">&nbsp;</div>
       <p>Through every storm, we tirelessly trod the path of change. Until finally, the fruit of our labor blazed like a candle's flame—LUMINA. A hidden treasure that began as a simple dream, now becoming a reality in the world of ecommerce.</p>
       <div class="vertical-line">&nbsp;</div>
       <p>Through countless toil and sweat, our dream became a reality. The journey was fraught with tales of success and failure. At every stage, a new lesson was learned, and a new hope was born. Ultimately, the story of LUMINA is not just a tale of triumph but also of steadfast determination.</p>
       <div class="vertical-line">&nbsp;</div>
       <p>In our journey through the path of incredible change, the story of LUMINA continues to reflect the spirit of collaboration and transformation. With every step, we continue to breathe life into our dream—the dream to illuminate the world of ecommerce.
       </p>
     </div>
    </div>
   </main>
   
       
  
   <!-------------------Sign up----------------------->
   <div class="signup" id="signup-modal">
    <div class="signup-content">
                <h2>Sign-Up</h2>
        <img src="pics/luminalogo-removebg-preview.png" alt="signup image">

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






