<?php
  //this is the code to delete event
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the delete activity of the "Activities" section
  //this is written on 22 April 2020
  //this program allows users to delete specific event
  //the program reads the activity_id and query it in mysql to perform deletion

function deleteActivity($conn, $activity_id){
  $sql1 = "delete from activity_table where activity_id = ? ; ";


  $stmt1 = mysqli_prepare($conn,$sql1);
  //finding the activity from the table


  if ($stmt1 == FALSE) {
    header("Location: index.php?error=sqlerror1");
    exit();
  }
  else {
    mysqli_stmt_bind_param($stmt1, "i", $activity_id);
    mysqli_stmt_execute($stmt1);

    $sql2 = "delete from activity_users_list where activity_id = ? ;";
    $stmt2 = mysqli_prepare($conn,$sql2);
    //finding the activity id from the user list table

    if ($stmt2 == FALSE) {
      header("Location: index.php?error=sqlerror2");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt2, "i", $activity_id);
      mysqli_stmt_execute($stmt2);
      //perform deletion

      header('Location: activity_view_mine.php?delete=success');
      //report success

    }
  }
}

if(isset($_GET['id'])){

  $conn = mysqli_connect("localhost","root","","Habitracker");


  deleteActivity($conn,$_GET['id']);




}
