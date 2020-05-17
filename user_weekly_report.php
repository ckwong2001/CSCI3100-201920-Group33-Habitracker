<?php
    require 'header.php';
?>

<html>
    <head>
    <link rel="stylesheet" href="user_weekly_report.css">
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
    
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    
    $lastSunday = date('Y-m-d',strtotime('last sunday'));
    $dayafterlastSunday = date('Y-m-d',strtotime('last sunday -6 days'));

?>

<div class="loginbox">

<div><h1>Weekly Report</h1></div>
<div><p>Hey <?php echo "$username";?>, want a summary of your progress last week?</p><p>Click the button below to check out your report from <?php echo "$dayafterlastSunday";?> to <?php echo "$lastSunday";?>!</p></div>
<form action = 'view_weekly_report.php' method = 'POST'>
<div class ='text-center mt-3 w-50'>
<button class = 'btn btn-outline-info' type = 'submit' value = 'submit' name= 'weekly_report'>View report</button>
</div>
</form>

<p>Share the joy with your friends:</p>

<div class="middle">
    <a class="btn" href="#">
        <i class="fa fa-google"></i>
    </a>
    <a class="btn" href="#">
        <i class="fa fa-twitter"></i>
    </a>
    <a class="btn" href="#">
        <i class="fa fa-facebook"></i>
    </a>
    <a class="btn" href="#">
        <i class="fa fa-instagram"></i>
    </a>
</div>


</body>
</html>

