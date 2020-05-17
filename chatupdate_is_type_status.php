<?php

include('chatdatabase_connection.php');

session_start();

//update the typing status of a user when one is typing in the chat dialog box to the database 
//the typing status will then be displayed in the chat index page 
$query = "
UPDATE login_details
SET is_type = '".$_POST["is_type"]."'
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>
