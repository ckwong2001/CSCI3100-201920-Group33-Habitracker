//when users attempt to change their password by clicking the button in their account management tab

<?php
    require "header.php";
?>
<html>
    <head>
    <link rel="stylesheet" href="change-password.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    
<?php
    //prevent one from access the page if one has not logged in
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    } else {
    ?>


<div class="loginbox">
    <main>
    <h1>Change Password</h1>
            <form action="includes/change-password.inc.php" method="post">
            <input type="password" name="exist-pwd" placeholder="Current Password">
            <input type="password" name="new-pwd" placeholder="New Password">
            <input type="password" name="repeat-pwd" placeholder="Repeat New Password">
            <button type="submit" name="change-password-submit">Save Changes</button>

            </form>
        
    //printing error messages according to the invalid input of the users
    <?php
        if (isset($_GET['changepwd'])){    //use $_GET to check the url
            if ($_GET['changepwd'] == "empty") {
                echo '</br>';
                echo '<p class="wrong"> Fill in all fields!</p>';
            }
            else if ($_GET['changepwd'] == "pwdnotsame") {
                echo '</br>';
                echo '<p class="wrong">Your new password and your confirmation password do not match</p>';
            }
            else if ($_GET['changepwd'] == "wrongpwd") {
                echo '</br>';
                echo '<p class="wrong">You input the wrong current password</p>';
            }
            //print success message to notify the user that one's password is updated 
            else if ($_GET['changepwd'] == "passwordupdated") {
                echo '</br>';
                echo '<p class="success">Your password is updated</p>';
            }
            
        }
    }
?>
    
</div>
</main>

<?php
    require "footer.php";
?>
