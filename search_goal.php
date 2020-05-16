<?php
    require "header.php";
    
    //echo feedback message
    if (isset($_GET['goal_reported'])){
        echo '<p>Goal reported.</p>';
    };
?>

<html>
    <head>
    <link rel="stylesheet" href="search_goal.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

//to display the content in a box
<body>
<div class="loginbox">
<?php
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
?>

<div>
<div><h1>Search goals</h1></div>
</div>
//for choosing the preferences in the search
<form action = 'search_goal_result.php' method = 'POST'>
    <label>You can search goals of other users through keywords.</label><br><br>
    <label>Keyword: <br></label>
    <div class="search_box">
        <input class = "input_box" type="text" name="goal_keyword">

        <button class = "btn" type = 'submit' value = 'submit' name= 'search_goal'>
            <i class="fa fa-search"></i>
        </button>
    </div>

<p><br><br><br>Sort by:
<select name="sortby" id="sortby">
<option selected="selected">Goal ID</option>
<option>Goal name</option>
<option>End date</option>
<option>Start time</option>
<option>End time</option>

</select>
<p>Order:
<select name="order" id="order">
<option selected="selected">Ascending</option>
<option>Descending</option>
</select></p>

    
</form>
</div>
</body>
</html>
