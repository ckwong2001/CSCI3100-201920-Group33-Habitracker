
<?php
  //this is the code to search event
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the search activity of the "Activities" section
  //this is written on 24 April 2020
  //this program allows users to search specific event with a specific keyword
  //the program reads the string keyword from user and perform search function with mysql
    require "header.php";
?>

<html>
    <head>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
    .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 400px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.15);
        margin-left:auto;
        margin-right:auto;
    }

    .content-table thead tr {
        background-color: #006f98;
        color: #ffffff;
        text-align: left;
        font-weight: bold;
    }

    .content-table th,
    .content-table td {
        padding: 12px 15px;
    }

    .content-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .content-table tbody tr:nth-of-type(odd) {
        background-color: #ffffff;
    }

    .content-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .content-table tbody tr:last-of-type {
        border-bottom: 3px solid #006f98;
    }

    .search_box
{
    position: relative;
    top: 30%;
    left: 18%;
    transform: translate(-106%, -70%);
    background-color: white;
    height: 15px;
    border-radius: 40px;
    border: 2px solid #668cff;
    border-width: 2px;
    padding: 10px;
    width: 150px;
}

.input_box
{
    border: none;
    outline: none;
    background: none;
    float: left;
    padding: 0;
    color: #2f3640;
    font-size: 16px;
    line-height: 20px;
    width: 240px;
}

.btn
{
    position: relative;
    color: #1abc9c;
    text-decoration: none;
    width: 40px;
    height: 40px;
    line-height: 20px;
    text-align: center;
    border-radius: 50%;
    top: 0%;
    left: 86%;
    transform: translate(-15%, -125%);
}

.search_box button[type="submit"]{
    border: none;
    outline: none;
    height: 38px;
    width: 38px;
    background: #668cff;
    color: #fff;
    font-size: 14px;
    border-radius: 20px;
 
}

.search_box button[type="submit"]:hover{
    cursor:pointer;
    background: white;
    color: #000;
    border: 2px solid #668cff;
}

.search-word  
{
    position: relative;
    left: 7%;
}

</style>
</head>

<body>

<?php
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
?>

<?php
    
    function checkJoined($activityID,$user_id){
        $cnt=0;
        
        $conn = mysqli_connect("localhost","root","","Habitracker");
        if($user_id==NULL){
            header("Location: index.php?query=failed");
        }else{
            $sql = "SELECT * FROM activity_users_list WHERE  user_id = '$user_id' and activity_id = '$activityID'";
        }
        
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $cnt++;
        }
        if($cnt==0){
            echo '<td><a href = "activity_join.php?id='.$activityID.'">Click Here</a> </td>';
        }else{
            echo '<td>Joined</td>';
        }
    }
    
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    require 'db_key.php';
    $conn = connect_db();
    $activity_keyword = $_POST['activity_keyword'];
    $sortby = $_POST['sortby'];
    if ($sortby=="Activity ID") $sortby = "activity_id";
    elseif ($sortby=="Name") $sortby = "activity_name";
    elseif ($sortby=="Recurrence") $sortby = "activity_repetition";
    $order = $_POST['order'];
    if ($order=="Ascending") $order = "ASC";
    elseif ($order=="Descending") $order = "DESC";
    $sql = "Select * from activity_table Where activity_name Like '%$activity_keyword%' and activity_status_open = '1' Order by $sortby $order";
    $search_result = $conn->query($sql);
    
    $sortby = $_POST['sortby'];
    $order = $_POST['order'];
    ?>


<div><h1 align=center>Existing Activities</h1></div>
<div class="search-word">
<h3>Search by keyword</h3>
<form action = 'activity_search_result.php' method = 'POST'>
<label>Keyword: </label>

<div class="search_box">
    <input class = 'input_box' type="text" name="activity_keyword"><br><br>
    <button class = 'btn' type = 'submit' value = 'submit' name= 'search_activity'><i class="fa fa-search"></i></button>
</div>

<p>Sort by:
<select name="sortby" id="sortby">
<option selected="selected">Activity ID</option>
<option>Name</option>
<option>Recurrence</option>

</select>
<p>Order:
<select name="order" id="order">
<option selected="selected">Ascending</option>
<option>Descending</option>
</select></p></br>

</form>

<div><h3>Search results</h3></div>
<div><p>Keyword: <?php echo "$activity_keyword"; ?></p></div>
<div><p>Sort by: <?php echo $sortby; ?></p></div>
<div><p>Order: <?php echo $order; ?></p></div>
</div>

<?php
    if ($search_result->num_rows >0) {
        ?>
<table class="content-table">
    <thead>
        <tr>
            <th>Activity ID</th>
            <th>Name</th>
            <th>Recurrence</th>
            <th>Date and time</th>
            <th>No. of days</th>
            <th>Day1</th>
            <th>Time1</th>
            <th>Day2</th>
            <th>Time2</th>
            <th>Day3</th>
            <th>Time3</th>
            <th>Creator</th>
            <th>Details</th>
            <th>Join</th>
            <th>Report inappropriate</th>
        </tr>
    </thead>

    <tbody>
<?php while($row = $search_result->fetch_assoc()) { ?>

<tr>
<td><?php echo $row['activity_id']; ?></td>
<td><?php echo $row['activity_name']; ?></td>
<td><?php echo ($row['activity_repetition']==0? "One-off" : "Recurring"); ?></td>
<td><?php echo ($row['activity_repetition']==0? date('yy-m-d H:i', strtotime($row['activity_one_off_datetime'])) : "-"); ?></td>

<td><?php echo ($row['activity_repetition']==0? "-" : $row['activity_repetition']); ?></td>

<td><?php echo ($row['activity_repetition']==0? "-" : $row['activity_recurring_date_0']); ?></td>
<td><?php echo ($row['activity_repetition']==0? "-" : date('H:i', strtotime($row['activity_recurring_time_0']))); ?></td>

<td><?php echo ($row['activity_repetition']==0? "-" : ($row['activity_repetition']<2? "-" : $row['activity_recurring_date_1'])); ?></td>
<td><?php echo ($row['activity_repetition']==0? "-" : ($row['activity_repetition']<2? "-" : date('H:i', strtotime($row['activity_recurring_time_1'])))); ?></td>

<td><?php echo ($row['activity_repetition']==0? "-" : ($row['activity_repetition']<3? "-" : $row['activity_recurring_date_2'])); ?></td>
<td><?php echo ($row['activity_repetition']==0? "-" : ($row['activity_repetition']<3? "-" : date('H:i', strtotime($row['activity_recurring_time_2'])))); ?></td>

<td><?php echo ($row['username']==$username? $row['username'] : '<a href="profile_view_others.php?username='.$row['username'].'">'.$row['username'].'</a>'); ?></td>

<td><?php echo '<a href = "activity_display_details.php?id='.$row['activity_id'].'">Click Here</a>'; ?></td>

<?php checkJoined($row['activity_id'],$user_id); ?>
    
<?php 
    if ($row['username'] == $_SESSION['username']) {
        echo '<td>-</td>';
    }
    else {
        echo '<td><a href = "report_activity.php?id='.$row['activity_id'].'">Click Here</a></td>';
    }
?>
</tr>
<?php } ?>

</tbody>
</table>
<?php
    } else
    echo "No results";
    ?>
</body>
