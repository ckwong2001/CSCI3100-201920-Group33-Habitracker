<?php

//retrieve chat messages when users open the dialog box to see the chat history of a certain activity
include ('chatdatabase_connection.php');

session_start();

$data = array(
    ':activity_id'  => $_POST['activity_id'],  //person receive message
    ':from_user_id'  => $_SESSION['user_id'],  //person send message
    ':activity_chat_message'  => $_POST['activity_chat_message'],
    ':status'   => '1'
   );

//inserting chat message into the database, with the tabl name "activity chat message"
$query = "
INSERT INTO activity_chat_message 
(activity_id, from_user_id, chat_message, status) 
VALUES (:activity_id, :from_user_id, :activity_chat_message, :status) 
";

$statement = $connect->prepare($query);

if($statement->execute($data))
{
 echo fetch_activity_chat_history($_SESSION['user_id'], $_POST['activity_id'], $connect); //bind parameters in chatdatabase function
}

?>
