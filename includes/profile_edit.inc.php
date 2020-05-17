<!--backend code for editing user profile-->

<?php
session_start();
$username = $_SESSION['username'];
?>


<?php

if(!isset($_SESSION['username'])){
    echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
    exit();

} else if($_POST){
    require 'db_key.php';
    $conn = connect_db();

//allocate variables to store the input of users when they edit their profile
    
if (isset($_POST["finish-edit-profile-submit"])) {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $welcomeMessage = $_POST["welcome_message"];
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $welcomeMessage = mysqli_real_escape_string($conn, $welcomeMessage);

    //update the database on users' personal information
    $sql = "Update login Set first_name = '$firstName',last_name = '$lastName',welcome_message = '$welcomeMessage' where '$username' = username";
    $sql = $conn->query($sql);
    if($sql){
        
        //redirect users back to the profile display page after editing their profile
        header("Location: ../profile_display.php?profile=profileupdated");
    }
}
}
        
?>
