<?php


session_start();
if(isset($_POST['submitEdit'])){

  $conn = mysqli_connect("localhost","root","","Habitracker");


  $activity_name = mysqli_real_escape_string($conn, $_POST['activityName']);
  $activity_time_remark = mysqli_real_escape_string($conn, $_POST['timeRemark']);
  $activity_remark = mysqli_real_escape_string($conn, $_POST['Remark']);
  $activity_status_open =2 ;
  if ($_POST['publicOption'] == "yes")  $activity_status_open = 1;
  else $activity_status_open = 0;
  $activityID = mysqli_real_escape_string($conn, $_POST['activityID']);

//using post method to retrieve information from activity_edit.php

  if(empty($activity_name)||empty($activityID)){
    header("Location: ../activity_view_mine.php?edit=errorEmptyFields");
    //reporting error
  }else{




    $sql = "UPDATE `activity_table` SET `activity_name` = ?,
    `activity_time_remark` = ?,
    `activity_remark` = ?,
    `activity_status_open` = ? WHERE activity_id = ".$activityID." ";


    $stmt = mysqli_stmt_init($conn);



    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "sql statement not prepared";
      header("Location: activity_view_mine.php?edit=failstmtnotprep&id=$activityID");

    }else{
      mysqli_stmt_bind_param($stmt,"ssss",
      $activity_name,$activity_time_remark,
      $activity_remark,  $activity_status_open);
      mysqli_stmt_execute($stmt);

      header("Location: activity_view_mine.php?edit=done&id=$activityID");
      //reporting success and directing user back to main page
    }
  }

}
