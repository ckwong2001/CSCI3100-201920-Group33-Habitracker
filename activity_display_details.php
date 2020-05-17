<?php
   //this is the code to display details of an event
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the view activity of the "Activities" section
  //this is written on 21 April 2020
  //this program allows users to view specific event
  //the program reads the activity_id and query it in mysql to display the string name, the datetime time and general remarks stored in string format
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
        
        echo '<div><h1>Activity details</h1></div>';
        
        $activityID = $_GET['id'];
         //getting the activity id so that we can query it in the table
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
        //displaying the date and time
    }
    if($row['activity_repetition']==1){
       //for once a week
        
        echo "<div><br>The activity will be held once a week on ".
        getProperWeekDay($row['activity_recurring_date_0']).
        " at ".$row['activity_recurring_time_0'].". </div>";
    }
    if($row['activity_repetition']==2){
       //for twice a week
        
        echo "<div><br>The activity will be held twice a week on ".
        getProperWeekDay($row['activity_recurring_date_0']).
        " at ".$row['activity_recurring_time_0']." and ".
        getProperWeekDay($row['activity_recurring_date_1']).
        " at ".$row['activity_recurring_time_1'].". ".
        
        " </div>";
    }
    if($row['activity_repetition']==3){
       //for thrice a week
        
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
           //to find the user name to display it in the table, we need to look up the name in the user_list with the corresponding acitivity id
    $result_2 = mysqli_query($conn,$sql_2);
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
    ?>

<br><form action = "activity_show_all_public_activities.php">
<button type="submit">View all activities</button> </form>

<form action = "activity_view_mine.php">
<button type="submit">View my activities</button> </form>

</div>

<?php
    echo"</div>";
    
    }
    }
    ?>
