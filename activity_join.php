<?php

  //this is the code to join event
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the join activity of the "Activities" section
  //this is written on 23 April 2020
  //this program allows users to join specific event
  //the program reads the activity_id and query it in mysql, then add the user id to the  acitivty_user_table in the database with the corresponding activity_id


session_start();
$conn = mysqli_connect("localhost","root","","Habitracker");
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
    
function getActivityNameFromActivityID($data){
  $conn = mysqli_connect("localhost","root","","Habitracker");
  $sql = "SELECT * FROM activity_table WHERE activity_id = ".$data." ";
  $result = mysqli_query($conn,$sql);
  while($row = mysqli_fetch_assoc($result)){
    echo "<span>".$row['activity_name']."</span><br>";
  }
//this is function to retrieve the activity name by its unique ID in SQL DB

}

if(isset($_GET['id'])){

  $userName = $_SESSION['username'];
  $activityID = $_GET['id'];


  $conn = mysqli_connect("localhost","root","","Habitracker");
  $sql = "SELECT * FROM activity_users_list WHERE activity_id = ".$activityID." ";
  $result = mysqli_query($conn,$sql);

  $alreadyJoined = 0;
  //if the user already joined it, he cannot join it again

  while($row = mysqli_fetch_assoc($result)){
    if($row['username'] == $userName){
      $alreadyJoined++;
    }
  }

  if($alreadyJoined==0){//when equals to zero, the user HAS NOT joined the event
    $sqlInsert = "INSERT INTO `activity_users_list` ( `user_id`, `activity_id`) VALUES ( '$user_id', '$activityID');";
    $result = mysqli_query($conn,$sqlInsert);
    header("Location:activity_view_mine.php?join=success");
  }else{
    echo "You have already joined this event";
    header("Location:activity_view_mine.php?join=fail");


  }





}



?>
