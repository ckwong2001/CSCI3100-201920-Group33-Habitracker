<?php
//retrieve the activity that a user joined and corresponding activity name when user enter the group chat index page 

//fetch_user.php 
//this is for displaying button "start chat" so it excludes the current user 

include('chatdatabase_connection.php');

session_start();

//select activity from database which the user has joint */
$query = "
SELECT * FROM activity_users_list 
WHERE user_id = '".$_SESSION['user_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
 <th width="70%">Activity Name</td>
 
 <th width="30%">Action</td>
 </tr>
';

foreach($result as $row)
{
//to display the other information of the activity, other than the activity id, from another table in the database 
//for displaying such information in the chat index page, such as the activity name
$query = "
SELECT * FROM activity_table 
WHERE activity_id = '".$row['activity_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result_2 = $statement->fetchAll();

foreach($result_2 as $row_2){

 //to display one's joined activity in the group chat index page for users to start chat with people in the same activity
 $output .= '
 <tr>
    <td>'.$row_2['activity_name'].' </td>
   
    <td><button type="button" class="btn btn-info btn-xs start_group_chat" data-activityid="'.$row_2['activity_id'].'" data-activityname="'.$row_2['activity_name'].'">Start Group Chat</button></td>
 </tr>
 ';

}
}

$output .= '</table>';

echo $output;

?>
