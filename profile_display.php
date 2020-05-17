<!--display one's profile when user click the view profile button-->

<?php
    require 'header.php';
?>

<html>
    <head>
    <title>Profile Card design</title>
    <link rel="stylesheet" href="profile_display.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
<body>

<?php
    //security measure to prevent one from accessing users in the system by changing the url
    $username = $_SESSION['username'];
   
    if( !isset( $_SESSION['username']) ){

        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    //fetch information of the user who logged in the system from the database
    require 'db_key.php';
    $conn = connect_db();
    $sql = "Select * from login Where username = '$username'";
    $search_result = $conn->query($sql);
    $row = $search_result->fetch_assoc();
    $id = $row['user_id'];
?>
    <div class="profile-card">
        <div class="image-container">
        <?php 
        echo "<div>";
        if ($row['image_status'] == 0){
            echo "<img src='upload_image/profile".$id.".jpg' height ='150'>";
        } else if ($row['image_status'] == 1){
            echo "<img src='upload_image/profiledefault.jpg' height ='150'>";
        }
        echo "</div>";
        ?>
         
        </div>
        
        <!-- display users' first name, last name, profile picture and welcoming message in their profile-->
        <div class="main-container">
            <h3><?php echo "Username: ".$row['username']; ?></h3>
            <p><i class="fa fa-envelope info"></i><?php echo "Email: ".$row['email'];?></p>

            <p><i class="fa fa-star info"></i><?php
                if (isset($row['first_name'])){
                    echo "First name: ".$row["first_name"];
                }
                    else 
                        echo "First name: ";?></p>

            <p><i class="fa fa-star-o info"></i><?php
                if (isset($row['last_name'])){
                    echo "Last name: ".$row["last_name"];
                }
                    else 
                        echo "Last name: ";?></p>

            <p><i class="fa fa-heart info"></i><?php
                if (isset($row['welcome_message'])){
                    echo "Welcoming message: ".$row["welcome_message"];
                    echo "<br>";
                }
                    else 
                        echo "Welcoming message: ";?></p>
            <hr>
            <form action="profile_edit.php" method="post"> 
            <button class="edit_profile" type="submit" name="edit-profile-submit">Edit your profile</button>
            </form>
            <?php

            //display success message after user edit their profile and being redirect back to the display profile page
            if (isset($_GET['profile'])){    //use $_GET to check the url
                if ($_GET['profile'] == "profileupdated") {
                echo '<p class="success"> Your profile is updated!</p>';
            }
            }
            
            //display error messages according to users invalid actions when uploading their profile picture 
            if (isset($_GET['error'])){  
                if ($_GET['error'] == "wrongtype") {
                    echo '<p class="wrong">You cannot upload files of this type!</p>';
                }
                else if ($_GET['error'] == "filetoobig") {
                    echo '<p class="wrong"> Your file is too big!</p>';
                }
                else if ($_GET['error'] == "error") {
                    echo '<p class="wrong">There was an error uploading your file!</p>';
                }
            }
            
            //display success message after user successfully update their proilfe picture 
            if (isset($_GET['upload'])){ 
                if ($_GET['upload'] == "success"){
                    echo '<p class="success">Your profile picture is uploaded!</p>';
                }
            }
         ?>
        </div>
    </div>
</body>
