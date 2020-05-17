《!--for users to sign up if they do not have an account previously-->
<html>
    <head>
    <link rel="stylesheet" href="signup_style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('img/login_bg3.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

<main>
   
<img src="img/logo.png" alt="Habitracker" height="50">
<div class="loginbox">
    <h1>Signup Here</h1>
    <div class="errormessage">
    <?php
        //display error messages corresponding to the invalid input by the users 
            if (isset($_GET['error'])){    //use $_GET to check the url
                if ($_GET['error'] == "emptyfields") {
                    echo '<p> Fill in all fields!</p>';
                }
                else if ($_GET['error'] == "invaliduidmail") {
                    echo '<p> Invalid username and e-mail!</p>';
                }
                else if ($_GET['error'] == "invaliduid") {
                    echo '<p> Invalid username! The username can only contain alphabets and numbers.</p>';
                }
                else if ($_GET['error'] == "invalidmail") {
                    echo '<p> Invalid e-mail!</p>';
                }
                else if ($_GET['error'] == "passwordcheck") {
                    echo '<p> The password and the re-entered password do not match. Please check.</p>';
                }
                else if ($_GET['error'] == "usertaken") {
                    echo '<p> Username is already taken!</p>';
                }
            }
        //display success message after user has successfully registered one's account
            else if (isset($_GET['signup'])) {
                if ($_GET['signup'] == "success") {
                echo '<p class="signup_success"> Signup successful</p>';
                echo '<a href="login.php">Please click here to log in!</a></br>';
                }
            }
        ?>
        </div>
    <!--display the signup form for users to sign up and pass their input to the backend appplication-->
        <form action="includes/signup.inc.php" method="post">
            <p>Username</p> 
            <input type="text" name="uid" placeholder="Enter Username">
            <p>Email</p> 
            <input type="text" name="mail" placeholder="Enter E-mail">
            <p>Password</p> 
            <input type="password" name="pwd" placeholder="Enter Password">
            <p>Repeat your password</p> 
            <input type="password" name="pwd-repeat" placeholder="Confirm password">
            <button type="submit" name="signup-submit">Signup</button>
            <a href="login.php">Please click here to log in if you have registered an account!</a></br>
        </form>
</div>

    </main>

    </body>

<?php
    require "footer.php";
?>
