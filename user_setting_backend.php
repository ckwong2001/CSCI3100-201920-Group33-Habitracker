<?php
    session_start();
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    } else if($_POST){
        require 'db_key.php';
        $conn = connect_db();
        //get the results input by the user and change them to proper SQL
        if(isset($_POST['edit_setting']) ){
            $user_id = $_SESSION['user_id'];
            $receive_dailyreminder = (isset($_POST['receive_dailyreminder'])) ? 1 : 0;
            $receive_weeklyreport = (isset($_POST['receive_weeklyreport'])) ? 1 : 0;

            //update the SQL entry
            $sql = "Update login Set receive_dailyreminder = '$receive_dailyreminder', receive_weeklyreport = '$receive_weeklyreport' Where user_id = '$user_id'";
            $sql = $conn->query($sql);
            if($sql){
                header("Location: ../Habitracker/user_setting.php?edit_setting=success");
            }
        }
    } else{
        header('location: index.php');
        exit();
    }
    ?>
