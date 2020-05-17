//automated with the use of crontab on Mac
<?php
    session_start();
    require 'db_key.php';
    $conn = connect_db();
    
    //perform the checking goal by goal
    $sql = "Select * from goals";
    $search_result = $conn->query($sql);
    
    if ($search_result->num_rows >0) {
        while($row = $search_result->fetch_assoc()) {
            //retrieve the past information
            $streak = $row['streak'];
            $goal_id = $row['goal_id'];
            if ($row['goal_completed'] == 1) {
                //calculation if the goal is completed
                $streak = $streak + 1;
                //update in mySQL
                $sql = "Update goals set streak = '$streak' where goal_id = '$goal_id'";
                $sql = $conn->query($sql);
            } else if ($row['goal_completed'] == 0) {
                //reset streaks if the goal is not completed
                $streak = 0;
                //update in mySQL
                $sql = "Update goals set streak = '$streak' where goal_id = '$goal_id'";
                $sql = $conn->query($sql);
            }
            
            //to update the score
            $username = $row['username'];
            //retrieve information of the creator of the goal
            $sql = "Select * from login where username = '$username'";
            $search_result_2 = $conn->query($sql);
            if ($search_result_2->num_rows >0) {
                $row_2 = $search_result_2->fetch_assoc();
                //retrieve the past information
                $score = $row_2['score'];
                if ($streak>=1 && $streak<5) {
                    //calculation for streaks <5
                    $score = $score + $streak*100;
                    //update in mySQL
                    $sql = "Update login set score = '$score' where username = '$username'";
                    $sql = $conn->query($sql);
                } else if ($streak>=5) {
                    //calculation for streaks >=5
                    $score = $score + 500;
                    //update in mySQL
                    $sql = "Update login set score = '$score' where username = '$username'";
                    $sql = $conn->query($sql);
                }
            }
        }
    }

    //to reset the completion status
    $sql = "Update goals set goal_completed = '0'";
    $sql = $conn->query($sql);
?>


