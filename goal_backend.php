<?php
    session_start();
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    } else if($_POST){
        require 'db_key.php';
        $conn = connect_db();
        if(isset($_POST['create_goal']) ){
            //to create a goal
            //retrieve the filled info
            $goal_name = $_POST['goal_name'];
            $goal_description = $_POST['goal_description'];
            $goal_subtask = $_POST['goal_subtask'];
            $username = $_SESSION['username'];
            //calculate the end date from the duration
            $goal_enddate = date("Y-m-d", strtotime("+{$_POST['duration']} days"));
            //change the format of the time
            if (($_POST['goal_starttime_hh'])&&($_POST['goal_starttime_mm'])) {$goal_starttime = "{$_POST['goal_starttime_hh']}:{$_POST['goal_starttime_mm']}:00";} else {$goal_starttime = NULL;};
            if (($_POST['goal_endtime_hh'])&&($_POST['goal_endtime_mm'])) {$goal_endtime = "{$_POST['goal_endtime_hh']}:{$_POST['goal_endtime_mm']}:00";} else {$goal_endtime = NULL;};
            //change the format of the pricavy boolean
            $goal_public = (isset($_POST['goal_public'])) ? 1 : 0;
            //sanitize the input
            $goal_name = mysqli_real_escape_string($conn, $goal_name);
            $goal_description = mysqli_real_escape_string($conn, $goal_description);
            $goal_subtask = mysqli_real_escape_string($conn, $goal_subtask);
            
            //insert the mySQL entry
            $sql = "Insert Into goals (username, goal_name, goal_description, goal_subtask, goal_enddate, goal_starttime, goal_endtime, goal_public, goal_completed) VALUES ('$username', '$goal_name', '$goal_description', '$goal_subtask', '$goal_enddate', ".($goal_starttime==NULL ? "NULL" : "'$goal_starttime'").", ".($goal_endtime==NULL ? "NULL" : "'$goal_endtime'").", '$goal_public', 0)";
            $sql = $conn->query($sql);
            if($sql){
                header("Location: ../Habitracker/mygoals.php?create_goal=success");
            }
        } else if (isset($_POST['edit_goal'])) {
            //to edit a goal
            //retrieve the filled info
            $goal_id = $_SESSION['goal_id'];
            $goal_name = $_POST['goal_name'];
            $goal_description = $_POST['goal_description'];
            $goal_subtask = $_POST['goal_subtask'];
            $username = $_SESSION['username'];
            //calculate the end date from the duration
            $goal_enddate = date("Y-m-d", strtotime("+{$_POST['duration']} days"));
            //change the format of the time
            if (($_POST['goal_starttime_hh'])&&($_POST['goal_starttime_mm'])) {$goal_starttime = "{$_POST['goal_starttime_hh']}:{$_POST['goal_starttime_mm']}:00";} else {$goal_starttime = NULL;};
            if (($_POST['goal_endtime_hh'])&&($_POST['goal_endtime_mm'])) {$goal_endtime = "{$_POST['goal_endtime_hh']}:{$_POST['goal_endtime_mm']}:00";} else {$goal_endtime = NULL;};
            //change the format of the pricavy boolean
            $goal_public = (isset($_POST['goal_public'])) ? 1 : 0;
            //sanitize the input
            $goal_name = mysqli_real_escape_string($conn, $goal_name);
            $goal_description = mysqli_real_escape_string($conn, $goal_description);
            $goal_subtask = mysqli_real_escape_string($conn, $goal_subtask);
            
            //update the mySQL entry
            $sql = "Update goals Set goal_name = '$goal_name', goal_description = '$goal_description',goal_subtask = '$goal_subtask',goal_enddate = '$goal_enddate',goal_starttime = ".($goal_starttime==NULL ? "NULL" : "'$goal_starttime'").",goal_endtime = ".($goal_endtime==NULL ? "NULL" : "'$goal_endtime'").",goal_public = '$goal_public' Where goal_id = '$goal_id'";
            $sql = $conn->query($sql);
            
            if($sql){
                header("Location: ../Habitracker/mygoals.php?edit_goal=success");
            }
        } else if (isset($_POST['update_goal_completion'])) {
            //to update daily goal completion status
            $username = $_SESSION['username'];
            $today = date("Y-m-d", time());
            $sql = "Select * from goals Where username = '$username' and goal_enddate >= '$today'";
            $search_result = $conn->query($sql);
            
            //review goal by goal
            if ($search_result->num_rows >0) {
                while($row = $search_result->fetch_assoc()) {
                    $goal_id = $row['goal_id'];
                    //retrieve completion status
                    $goal_completed = (isset($_POST["goal_completed_$goal_id"])) ? 1 : 0;
                    //update in mySQL
                    $sql = "Update goals Set goal_completed = '$goal_completed' Where goal_id = '$goal_id'";
                    $sql = $conn->query($sql);
                }
            }
            
            if($sql){
                header("Location: ../Habitracker/goal_progress_today.php?update_goal_completion=success");
            }
        }
    }else{
        header('location: index.php');
        exit();
    }
    //header('location: index.php');
    ?>
