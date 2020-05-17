<?php
    require 'header.php';
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    $goal_id = $_GET['goal_id'];
    
    require 'db_key.php';
    $conn = connect_db();
    //to retrieve information about the concerned goal
    $sql = "Select * from goals Where goal_id = '$goal_id'";
    $search_result = $conn->query($sql);
    $row = $search_result->fetch_assoc();
    if ($row['username'] == $_SESSION['username']) {
        $_SESSION['goal_id'] = $goal_id;
        //to delete the entry from mySQL
        $sql = "Delete from goals Where goal_id = '$goal_id'";
        $sql = $conn->query($sql);
        if($sql){
            header("Location: ../Habitracker/mygoals.php?delete_goal=success");
        }
    } else echo "This is not a goal set up by this account. Please re-try. Click here to go back to ".'<a href="mygoals.php">My Goals List</a>'.".";
    ?>


