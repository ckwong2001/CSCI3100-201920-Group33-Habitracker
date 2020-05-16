<?php
  //this is the code to edit details event
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the edit activity of the "Activities" section
  //this is written on 23 April 2020
  //this program allows users to edit specific event
  //the program reads the activity_id and query it in mysql to perform data modification (including change the string name or the datetime date or the string type remarks of the event
    
    require 'header.php';
    ?>

<html>
<head>
<title>edit activity</title>
<link rel="stylesheet" href="activity_edit.css">

</head>

<body>


<?php
    function getProperWeekDay($capWeekDay){
        if ($capWeekDay=="MON")return "Monday";
        elseif ($capWeekDay=="TUE")return "Tuesday";
        elseif ($capWeekDay=="WED")return "Wednesday";
        elseif ($capWeekDay=="THU")return "Thursday";
        elseif ($capWeekDay=="FRI")return "Friday";
        elseif ($capWeekDay=="SAT")return "Saturday";
        elseif ($capWeekDay=="SUN")return "Sunday";
    }
    
    $publicMarker  = -1;
    $activityID = -1;
    
    
    if(isset($_GET['id'])){
        
        $activityID = $_GET['id'];
        echo '<form action = "activity_edit_backend.php" method="POST">';
        
        echo "<p><input type='hidden' name='activityID' placeholder='ID of the activity' value='$activityID'> </p>";
        //This is to post the id to the next page, hidden to user interface
        
        $conn = mysqli_connect("localhost","root","","Habitracker");
        $sql = "SELECT * FROM activity_table WHERE activity_id = ".$activityID." ";
        $result = mysqli_query($conn,$sql);
        
        while($row = mysqli_fetch_assoc($result)){
            if ($row['username'] == $_SESSION['username']) {
                
                echo '<div class="loginbox">';
                echo '<div><h1>Edit activity</h1></div>';
                
                if(!empty($row['activity_name'])){
                    
                    $actName = $row['activity_name'];
                    
                    echo "<p><label for='activtyName'>Name:</label> <input type='text' name='activityName' placeholder='Name of the activity' value='$actName'> </p>";
                    
                    
                    
                }
                
                if(!empty($row['activity_one_off_datetime'])){
                    $date= $row['activity_one_off_datetime'];
                    echo "<div></br>Date and time: ".$date."</div>";
                }
                if($row['activity_repetition']==1){
                    
                    echo "<div><br>The activity will be held once a week on ".
                    getProperWeekDay($row['activity_recurring_date_0']).
                    " at ".$row['activity_recurring_time_0'].". </div>";
                }
                if($row['activity_repetition']==2){
                    
                    echo "<div><br>The activity will be held twice a week on ".
                    getProperWeekDay($row['activity_recurring_date_0']).
                    " at ".$row['activity_recurring_time_0']." and ".
                    getProperWeekDay($row['activity_recurring_date_1']).
                    " at ".$row['activity_recurring_time_1'].". ".
                    
                    " </div>";
                }
                if($row['activity_repetition']==3){
                    
                    echo "<div><br>The activity will be held three times a week on ".
                    getProperWeekDay($row['activity_recurring_date_0']).
                    " at ".$row['activity_recurring_time_0']." , ".
                    getProperWeekDay($row['activity_recurring_date_1']).
                    " at ".$row['activity_recurring_time_1']." and ".
                    getProperWeekDay($row['activity_recurring_date_2']).
                    " at ".$row['activity_recurring_time_2'].". ".
                    " </div>";
                }
                echo "<div></br>Location: ".$row['activity_location']."</div>";
                
                
                $actRemark = $row['activity_remark'];
                
                
                
                $timeRemark = $row['activity_time_remark'];
                echo '
                <p></br>Remark on the date and time (Optional): <input type="text" value="'.$timeRemark.'" name="timeRemark" placeholder="Time remark of the activity"></p>
                <p><br/>General remark (Optional): <input type="text" value="'.$actRemark.'" name="Remark" placeholder="General remark of the activity"> </p>
                ';
                
                $publicMarker = $row['activity_status_open'];
              //storing the boolean var into an int
                
                if($publicMarker==1){
                  //this is the option when public is set to true
                    
                    echo '<p></br>Visible by other users?* <select name="publicOption" id="publicOption">
                    <option>no</option>
                    <option selected="selected">yes</option>
                    </select></p>';
                    
                    echo '<p style="font-weight:normal;"></br>* Note: You can close the activity when you think the participant recruitment is already satisfactory.</p>';
                    echo '<p style="font-weight:normal;"></br>If you plan to delete this activity, the activity also has to be closed first.</p>';
                    
                }elseif($publicMarker==0){
                  //this is when event is set to private
                    
                    echo '<p><br>Show to public or not? <select name="publicOption" id="publicOption">
                    <option selected="selected">no</option>
                    <option>yes</option>
                    </select></p>';
                    
                }
                
                echo '
                <br><button type="submit" name="submitEdit" >Finish Editing </button> </form>';
                
                
                if($publicMarker==0)
                  //only private event can be deleted
                    
                    echo'
                    <form action = "activity_delete.php" method="GET">
                    <button type="submit" name="id" value='.$activityID.'>Delete this activity</button> </form>';
                    
                    echo '<form action = "activity_view_mine.php">
                    <button type="submit">Back</button> </form>';
    ?>
</div>

<?php
    echo"</div>";
    } else echo "This is not a goal set up by this account. Please re-try. Click here to go back to ".'<a href="activity_view_mine.php">My Activities List</a>'.".";
    }
    }
    ?>

