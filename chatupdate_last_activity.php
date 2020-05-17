<?php

//update_last_activity.php

//update users' last activity when one logged in the habitracker system
//for showing one's online or offline status in the chat index page 
include('chatdatabase_connection.php');

session_start();

$query = "
UPDATE login_details 
SET last_activity = now() 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>
