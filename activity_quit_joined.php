<?php
      //this is the code to quit event they have joined
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the quit activity of the "Activities" section
  //this is written on 23 April 2020
  //this program allows users to quit specific event
  //the program reads the activity_id and query it in mysql, then delete the specific entry from activity_user_table
    require 'header.php';
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    ?>

<html>
<head>
<title>edit activity</title>
<link rel="stylesheet" href="activity_display_details.css">

</head>

<body>

<div class="loginbox">

<?php
    function checkIfTheMemberIsTheCreator($activityID,$user_id){
        $cnt=0;
        
        $conn = mysqli_connect("localhost","root","","Habitracker");
        if($user_id==NULL){
            header("Location: index.php?query=failed");
        }else{
            $username = $_SESSION["username"];
            $sql = "SELECT * FROM activity_table WHERE  username = '$username' and activity_id = '$activityID'";
        }
        
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $cnt++;
        }
        if($cnt==0){
            echo '<br><form action = "activity_quit_joined_backend.php" method="GET">
            <button type="submit" name="id" value='.$activityID.'>Confirm Quit </button> </form>';
        }else{
            echo '<br>You are the creator of this event, you cannot quit this event.<br>If you plan to delete this event, please first make the event closed under edit activity.<br>';
        }
        
    }
    
    function getProperWeekDay($capWeekDay){
        if ($capWeekDay=="MON")return "Monday";
        elseif ($capWeekDay=="TUE")return "Tuesday";
        elseif ($capWeekDay=="WED")return "Wednesday";
        elseif ($capWeekDay=="THU")return "Thursday";
        elseif ($capWeekDay=="FRI")return "Friday";
        elseif ($capWeekDay=="SAT")return "Saturday";
        elseif ($capWeekDay=="SUN")return "Sunday";
    }
      //this function is to return the correct string name from the input from POST method
    
    $publicMarker  = -1;
    $activityID = -1;
      //this minus one allow the system to debug and catch error
    
    
    if(isset($_GET['id'])){
        
        echo '<div><h1>Are you sure to quit this activity?</h1></div>';
        
        $activityID = $_GET['id'];
        
        $conn = mysqli_connect("localhost","root","","Habitracker");
        $sql = "SELECT * FROM activity_table WHERE activity_id = ".$activityID." ";
        $result = mysqli_query($conn,$sql);
        
        while($row = mysqli_fetch_assoc($result)){
            
    ?>

<p>Activity ID: <?php echo $row['activity_id'];?></p>

<br><p>Name: <?php echo $row['activity_name'];?></p>

<?php
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
    ?>

<br><p>Remark on the date and time: <?php echo ($row['activity_time_remark']==''? "-" : $row['activity_time_remark']); ?></p>

<br><p>General remark: <?php echo ($row['activity_remark']==''? "-" : $row['activity_remark']); ?></p>

<br><p>Created by: <?php echo ($row['username']==$username? $row['username'] : '<a href="profile_view_others.php?username='.$row['username'].'">'.$row['username'].'</a>');?></p>

<br><p>List of users in the activity: </p>

<?php
    $sql_2 = "SELECT * FROM activity_users_list WHERE activity_id = ".$row['activity_id']." ";
    $result_2 = mysqli_query($conn,$sql_2);
              //this is to retrieve the member list
    if ($result_2->num_rows > 0) {
        echo '<ul>';
        while($row_2 = mysqli_fetch_assoc($result_2)){
            if ($row_2['user_id'] != $_SESSION['user_id']) {
                $sql_3 = "SELECT * FROM login WHERE user_id = ".$row_2['user_id']." ";
                $result_3 = mysqli_query($conn,$sql_3);
                $row_3 = mysqli_fetch_assoc($result_3);
                echo '<li><a href="profile_view_others.php?username='.$row_3['username'].'">'.$row_3['username'].'</a>';
            } else { echo '<li><p>'.$username.'</p>';}
        }
        echo '</ul>';
    } else {echo '<p>-</p>';};

    $activity_id = $row['activity_id'];
    checkIfTheMemberIsTheCreator($activity_id,$user_id);
    
    ?>


<form action = "activity_view_mine.php">
<button type="submit">Back</button> </form>

</div>

<?php
    echo"</div>";
    
    }
    }
    ?>
