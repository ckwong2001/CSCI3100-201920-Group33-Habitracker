<?php
    session_start();
    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="style.css">
        
<!--        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        body {
            background-image: url('img/background.jpg');
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
        overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            font-size: 16px;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .dropdown {
            float: left;
            overflow: hidden;
        }

        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }

        .navbar a: hover, .dropdown: hover .dropbtn {
            background-color: blue;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a: hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        </style>
    </head>
<body>
    //to display the logo
<img src="img/logo.png" alt="Habitracker" height="50">
<div class="navbar">
    <a href="index.php">Home</a>
    
    //to display the dropdown list navigated to different pages
    <div class="dropdown">
        <button class="dropbtn">Goals
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="user_leaderboard.php">Leaderboard</a>
            <a href="search_goal.php">Search goals</a>
            <a href="create_goal.php">Create goal</a>
            <a href="mygoals.php">View my goals</a>
            <a href="goal_progress_today.php">My progress today</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Activities
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="activity_show_all_public_activities.php">Search activities</a>
            <a href="activity_create_nonrecurring.php">Create non-recurring activity</a>
            <a href="activity_create_new_event.php">Create recurring activity</a>
            <a href="activity_view_mine.php">View my activities</a>
        </div>
    </div>

    <a href="chatindex.php">Chat</a>

    <a href="groupchat_index.php">Group chat</a>

    <div class="dropdown">
        <button class="dropbtn">My account
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="profile_display.php">My profile</a>
            <a href="user_setting.php">Settings</a>
            <a href="change-password.php">Change password</a>
        </div>
    </div>

</div>

//authenticate the user
<?php
if (!isset($_SESSION['user_id'])){
    echo '<a href="login.php">Please click here to log in if you have registered an account!</a></br>';
} else {
 echo '<form action="includes/logout.inc.php" method="post">
 <button type="submit" name="logout-submit">Logout</button></br></br>
 </form>';
}

?>
