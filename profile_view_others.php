<!--allow other users to have access to other users' profile when they click into their profile in other webpages-->
<!-- only partial information about a user is shown in order to protect users' privacy-->

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
    $username = $_GET['username'];
   
    if( !isset( $_SESSION['username']) ){

        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    //fetch other users' information from the database, which includes first name, last name, welcoming message and username only
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
            echo "<img src='upload_image/profile".$id.".jpg' width ='200'>";
        } else if ($row['image_status'] == 1){
            echo "<img src='upload_image/profiledefault.jpg' width ='200'>";
        }
        echo "</div>";
        ?>
         
        </div>
        <div class="main-container">
            <h3><?php echo "Username: ".$row['username']; ?></h3>

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

            <?php

            if (isset($_GET['profile'])){    //use $_GET to check the url
                if ($_GET['profile'] == "profileupdated") {
                echo '<p> Your profile is updated!</p>';
            }
            }
         ?>
        </div>
    </div>
</body>
