<?php
    require 'header.php';
?>

<html>
    <head>
    <link rel="stylesheet" href="user_setting.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>

<?php
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    //echo feedback message
    if (isset($_GET['edit_setting'])){
        echo '<p>Settings saved.</p>';
    };
    
    ///retrieve preference of this user
    $user_id = $_SESSION['user_id'];
    require 'db_key.php';
    $conn = connect_db();
    $sql = "Select * from login Where user_id = '$user_id'";
    $search_result = $conn->query($sql);
    $row = $search_result->fetch_assoc();
?>

<div class="loginbox">
//to place the content of the form in a box
<div><h1>Settings</h1></div>
<div><h2>Personalize services according to your needs</h2></div>
<form action = 'user_setting_backend.php' method = 'POST'>
<div class = 'p-5 m-5'>
<div class="form-group">
//the indication of whether to receive emails

<input type="checkbox" name="receive_dailyreminder" <? echo ($row['receive_dailyreminder']? "checked":""); ?>>
<label class ="switch" for="receive_dailyreminder">Receive goal reminder daily via email</label><br><br>

<input type="checkbox" name="receive_weeklyreport" <? echo ($row['receive_weeklyreport']? "checked":""); ?>>
<label for="receive_weeklyreport">Receive weekly report via email</label><br>

<br>

<div class ='text-center mt-3 w-50'>
<button class = 'btn btn-outline-info' type = 'submit' value = 'submit' name= 'edit_setting'>Save Changes</button>

</div>
</div>
</div>
</form>
</div>
</div>
</body>
</html>

