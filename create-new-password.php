<html>
    <head>
    <link rel="stylesheet" href="create-new-password.css">
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
//for display animation in the frontend page
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

//allow users to create their new password after being redirected from the email
//users will receive an email which contain the link to this page if one forgets his password when they attempt to login
    
<img src="img/logo.png" alt="Habitracker" height="50">
<div class="loginbox">
<h1>Create your new password</h1>
        <?php
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if(empty($selector) || empty($validator)) {
                echo "Could not validate your request!";
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){   //check if it is hex number 
                   ?>
                    <form action="includes/reset-password.inc.php" method="post">  
                        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                        <input type="password" name="pwd" placeholder="Enter a new password">
                        <input type="password" name="pwd-repeat" placeholder="Repeat new password">
                        <button type="submit" name="reset-password-submit">Reset password</button>

                    </form>
                    <?php
                }
            }
        ?>
</div>
        
  

<?php
    require "footer.php";
?>
