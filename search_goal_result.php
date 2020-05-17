<?php
    require 'header.php';
    ?>

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
    background-color: #009897;
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
    border-bottom: 3px solid #009897;
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

<body>

<?php
    
    
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    $username = $_SESSION['username'];
    require 'db_key.php';
    $conn = connect_db();
    
    //to get the filled requirements of the search
    $goal_keyword = $_POST['goal_keyword'];
    $sortby = $_POST['sortby'];
    
    //change the filled deatails into proper SQL
    if ($sortby=="Goal ID") $sortby = "goal_id";
    elseif ($sortby=="Goal name") $sortby = "goal_name";
    elseif ($sortby=="End date") $sortby = "goal_enddate";
    elseif ($sortby=="Start time") $sortby = "goal_starttime";
    elseif ($sortby=="End time") $sortby = "goal_endtime";
    $order = $_POST['order'];
    if ($order=="Ascending") $order = "ASC";
    elseif ($order=="Descending") $order = "DESC";
    
    //get all the entries that are set as public and match the keyword
    $sql = "Select * from goals Where goal_name Like '%$goal_keyword%' and goal_public = True Order by $sortby $order";
    $search_result = $conn->query($sql);
    
    $sortby = $_POST['sortby'];
    $order = $_POST['order'];
    ?>

//set up the zone for inputting details of the next searching
<div><h1 align=center>Search results</h1></div>
<div class="search-word">
<h3>Search by keyword</h3>
<form action = 'search_goal_result.php' method = 'POST'>
<label>Keyword: </label>

<div class="search_box">
<input class = 'input_box' type="text" name="goal_keyword"><br><br>
<button class = 'btn' type = 'submit' value = 'submit' name= 'search_goal'><i class="fa fa-search"></i></button>
</div>
<p>Sort by:
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
</select></p></br>
</form>

<div><h3>Search results</h3></div>
<div><p>Keyword: <?php echo "$goal_keyword"; ?></p></div>
<div><p>Sort by: <?php echo $sortby; ?></p></div>
<div><p>Order: <?php echo $order; ?></p></div>
</div>

//set up the table if there is results
<?php
    if ($search_result->num_rows >0) {
        ?>
<table class="content-table">
<thead>
<tr>
<th>User</th>
<th>Goal ID</th>
<th>Goal name</th>
<th>Description</th>
<th>Subtask</th>
<th>End date</th>
<th>Start time</th>
<th>End time</th>
<th>Report this goal to admin</th>
</tr>
</thead>

//display the details of the goal
<tbody>
<?php while($row = $search_result->fetch_assoc()) { ?>


<tr>
<td><?php echo ($row['username']==$username? $row['username'] : '<a href="profile_view_others.php?username='.$row['username'].'">'.$row['username'].'</a>'); ?></td>
<td><?php echo $row['goal_id']; ?></td>
<td><?php echo $row['goal_name']; ?></td>
<td><? echo ($row['goal_description']==''? "-" : $row['goal_description']); ?></td>
<td><? echo ($row['goal_subtask']==''? "-" : $row['goal_subtask']); ?></td>
<td><?php echo $row['goal_enddate']; ?></td>
<td><?php echo (($row['goal_starttime'] != NULL)? date("H:i", strtotime($row['goal_starttime'])) : '-'); ?></td>
<td><?php echo (($row['goal_endtime'] != NULL)? date("H:i", strtotime($row['goal_endtime'])) : '-'); ?></td>

//display the button to report goal if the user if not the creator of the goal
<?php
    if ($row['username'] == $_SESSION['username']) {
        echo '<td>-</td>';
    }
    else {
        echo '<td><a href="report_goal.php?id='.$row['goal_id'].'">Click Here</a></td>';
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

