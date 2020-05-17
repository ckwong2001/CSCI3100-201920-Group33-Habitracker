<?php
//fetch the group chat history of a certain activity when a user open the group chat dialogue box

//fetch_user_chat_history.php

include('chatdatabase_connection.php');

session_start(); //get session variable

echo fetch_activity_chat_history($_SESSION['user_id'], $_POST['activity_id'], $connect); //bind parameters to the database.php

?>
