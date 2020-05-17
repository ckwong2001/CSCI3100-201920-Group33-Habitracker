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

    .btn button[type="submit"]{
    position: relative;
    border: none;
    outline: none;
    height: 30px;
    width: 90px;
    background: #009897;
    color: #fff;
    font-size: 14px;
    border-radius: 8px;
    left: 20.5%;
    }

    .btn button[type="submit"]:hover{
        cursor:pointer;
        background: white;
        color: #000;
        border: 2px solid #009897;
    }

    .btn p{
        position: relative;
        left: 20.5%;
    }

</style>
<body>
<?php
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    require 'db_key.php';
    $conn = connect_db();
    $username = $_SESSION['username'];
    $today = date("Y-m-d", time());
    //retrieve the goals that are still in progress
    $sql = "Select * from goals Where username = '$username' and goal_enddate >= '$today'";
    $search_result = $conn->query($sql);
    
    //echo feedback message
    if (isset($_GET['update_goal_completion'])){
        echo '<p>Progress today saved.</p>';
    };
?>

<div><h1 align=center>My Progress Today</h1></div>
<form action = 'goal_backend.php' method = 'POST'>
<div class = 'p-5 m-5'>
<div class="form-group">

<?php
    if ($search_result->num_rows >0) {
        ?>
    //create the table if there is result
    <table class="content-table">
        <thead>
            <tr>
            <td><strong>Goal ID</strong></td>
            <td><strong>Goal name</strong></td>
            <td><strong>Description</strong></td>
            <td><strong>Subtask</strong></td>
            <td><strong>End date</strong></td>
            <td><strong>Start time</strong></td>
            <td><strong>End time</strong></td>
            <td><strong>Streaks*</strong></td>
            <td><strong>Completed today</strong></td>
            </tr>
        </thead>

        //display the goal information
        <tbody>
        <?php while($row = $search_result->fetch_assoc()) { ?>
        <tr>
        <td><? echo $row['goal_id']; ?></td>
        <td><? echo $row['goal_name']; ?></td>
        <td><? echo ($row['goal_description']==''? "-" : $row['goal_description']); ?></td>
        <td><? echo ($row['goal_subtask']==''? "-" : $row['goal_subtask']); ?></td>
        <td><? echo $row['goal_enddate']; ?></td>
        <td><? echo (($row['goal_starttime'] != NULL)? date("H:i", strtotime($row['goal_starttime'])) : '-'); ?></td>
        <td><? echo (($row['goal_endtime'] != NULL)? date("H:i", strtotime($row['goal_endtime'])) : '-'); ?></td>
        <td><? echo $row['streak']; ?></td>
        <td><input type="checkbox" name=<?php echo('"goal_completed_'.$row['goal_id'].'"'); ?> <? echo ($row['goal_completed']? "checked":""); ?>></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>


<div class="btn">
    <p>* Remark: The streaks are updated at midnight every day.</p>
    <button class ="btn" type = 'submit' value = 'submit' name= 'update_goal_completion'>Save</button>
</div>
<?php
    } else
    echo "No results";
    ?>

</body>
