<?php

include ('chatdatabase_connection.php');

session_start();

$data = array(
    ':to_user_id'  => $_POST['to_user_id'],  //person who receives a message
    ':from_user_id'  => $_SESSION['user_id'],  //person who sent a message
    ':chat_message'  => $_POST['chat_message'],
    ':status'   => '1'
   );

//query for inserting chat message and its related information such as sender, receiver, 
// and status (whether a message is read) into the database 
$query = "
INSERT INTO chat_message 
(to_user_id, from_user_id, chat_message, status) 
VALUES (:to_user_id, :from_user_id, :chat_message, :status)
";

$statement = $connect->prepare($query);

if($statement->execute($data))
{
 echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);
}

?>
