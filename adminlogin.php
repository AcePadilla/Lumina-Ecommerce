<?php

if (isset($_POST["login"])) {
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    session_start();
    include('db_connection.php');
    
    $sql = "SELECT * FROM admin WHERE login_username='$login_username' AND login_password='$login_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
     
        header("Location: admin5.php");
        exit(); 
    } else {
        echo "<p>Invalid username or password.</p>";
    }

    $conn->close();
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
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
    <style>
       /*=============== GOOGLE FONTS ===============*/
        @import url("https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600&display=swap");

        /*=============== VARIABLES CSS ===============*/
        :root {
        --header-height: 3.5rem;

        /*========== Colors ==========*/
        /*Color mode HSL(hue, saturation, lightness)*/
        --first-color: hsl(230, 75%, 56%);
        --title-color: hsl(230, 75%, 15%);
        --text-color: hsl(230, 12%, 40%);
        --body-color: hsl(230, 100%, 98%);
        --container-color: hsl(230, 100%, 97%);
        --border-color: hsl(230, 25%, 80%);

        /*========== Font and typography ==========*/
        /*.5rem = 8px | 1rem = 16px ...*/
        --body-font: "Syne", sans-serif;
        --h2-font-size: 1.25rem;
        --normal-font-size: .938rem;

        /*========== Font weight ==========*/
        --font-regular: 400;
        --font-medium: 500;
        --font-semi-bold: 600;

        /*========== z index ==========*/
        --z-fixed: 100;
        --z-modal: 1000;
        }

        /*========== Responsive typography ==========*/
        @media screen and (min-width: 1023px) {
        :root {
            --h2-font-size: 1.5rem;
            --normal-font-size: 1rem;
        }
        }

        /*=============== BASE ===============*/
        * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
        }

        html {
        scroll-behavior: smooth;
        }

        body,
        input,
        button {
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        }
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("pics/mockup.png");
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Optional: Makes the background fixed during scroll */
        }

        .login-form {
            margin: 180px auto;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px); /* For Safari */
            padding: 40px;
            background: rgba(255, 255, 255, 0.61); /* Slightly transparent white */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        input,
        button {
        border: none;
        outline: none;
        }

        ul {
        list-style: none;
        }

        a {
        text-decoration: none;
        }

        img {
        display: block;
        max-width: 100%;
        height: auto;
        }

        /*=============== REUSABLE CSS CLASSES ===============*/
        .container {
        max-width: 1120px;
        margin-inline: auto; /* Baguhin ang margin para maging auto at nasa gitna */
        }

        .main {
        position: relative;
        height: 100vh;
        }


        .search,
        .login {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: var(--z-modal);
        background-color: hsla(230, 75%, 15%, .1);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px); /* For safari */
        padding: 8rem 1.5rem 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity .4s;
        }

        .search__close,
        .login__close,
        #signup-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        font-size: 1.5rem;
        color: var(--title-color);
        cursor: pointer;
        }
                

        h2{
            font-size: 36px;
            margin-bottom: 40px;
            color:#007bff;
        }
        .login-form{
            margin: 180px auto;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
        .login-form {
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .flip-card__form {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.flip-card__form input {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.flip-card__form input:focus {
    outline: none;
    border-color: #007bff;
}

.flip-card__form button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.flip-card__form button:hover {
    background-color: #0056b3;
}
        button {
            padding: 10px 20px;
            border: none;
            background-color: #0056b3;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            transition:all 0.3s ease;
        }
        button:hover {
            background-color: #53a6ff;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <div>
            <h2>Welcome Admin!</h2>
          
            <form class="flip-card__form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input class="flip-card__input" name="login_username" placeholder="Username" type="text">
<input class="flip-card__input" name="login_password" placeholder="Password" type="password">
                    <button class="flip-card__btn" type="submit" name="login">Login</button>
            </form>
        </div>
        <div>
            <img src="pics/welcomeadmin.png" alt="">
        </div>
    </div>
    
</body>
</html>