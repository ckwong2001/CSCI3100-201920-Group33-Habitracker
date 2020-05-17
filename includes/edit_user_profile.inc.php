<!--take in users' input and update the database when user edit their profile-->
<?php

session_start();

$username = $_SESSION['username'];
require 'db_key.php';
$conn = connect_db();

//allocate variables to store the input by the users
if (isset($_POST["finish-edit-profile-submit"])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $welcomeMessage = $_POST['welcome_message'];
    
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $welcomeMessage = mysqli_real_escape_string($conn, $welcomeMessage);
    
    //update the database 
    $sql = "Update login Set first_name = '$firstName', last_name = 'lastName', welcome_message = '$welcomeMessage' Where username = '$username'";
    $sql = $conn->query($sql);
    
    //redirect user to the profile display page 
    header("Location: ../user_profile.php?profile=profileupdated");

}

?>
