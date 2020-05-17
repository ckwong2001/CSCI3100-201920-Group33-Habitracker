<?php

//fetch_user_chat_history.php

//for fetching users' chat history in private chat
include('chatdatabase_connection.php');

session_start(); //get session variable

echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);

?>
