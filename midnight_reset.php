<?php
    session_start();
    require 'db_key.php';
    $conn = connect_db();
    
    
    $sql = "Select * from goals";
    $search_result = $conn->query($sql);
    
    if ($search_result->num_rows >0) {
        while($row = $search_result->fetch_assoc()) {
            $streak = $row['streak'];
            $goal_id = $row['goal_id'];
            if ($row['goal_completed'] == 1) {
                $streak = $streak + 1;
                $sql = "Update goals set streak = '$streak' where goal_id = '$goal_id'";
                $sql = $conn->query($sql);
            } else if ($row['goal_completed'] == 0) {
                $streak = 0;
                $sql = "Update goals set streak = '$streak' where goal_id = '$goal_id'";
                $sql = $conn->query($sql);
            }
            $username = $row['username'];
            $sql = "Select * from login where username = '$username'";
            $search_result_2 = $conn->query($sql);
            if ($search_result_2->num_rows >0) {
                $row_2 = $search_result_2->fetch_assoc();
                $score = $row_2['score'];
                if ($streak>=1 && $streak<5) {
                    $score = $score + $streak*100;
                    $sql = "Update login set score = '$score' where username = '$username'";
                    $sql = $conn->query($sql);
                } else if ($streak>=5) {
                    $score = $score + 500;
                    $sql = "Update login set score = '$score' where username = '$username'";
                    $sql = $conn->query($sql);
                }
            }
        }
    }
    
    $sql = "Update goals set goal_completed = '0'";
    $sql = $conn->query($sql);
    /*
    $sql = "Update goals set streak = '0'";
    $sql = $conn->query($sql);
    
    $sql = "Update login set score = '0'";
    $sql = $conn->query($sql);
    */
?>


