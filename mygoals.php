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

</style>

<body>

<?php
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    //retrieve all goals created by this user
    require 'db_key.php';
    $conn = connect_db();
    $username = $_SESSION['username'];
    $sql = "Select * from goals Where username = '$username'";
    $search_result = $conn->query($sql);
    
    //echo feedback messages
    if (isset($_GET['create_goal'])){
        echo '<p>Goal created.</p>';
    };
    
    if (isset($_GET['edit_goal'])){
        echo '<p>Goal updated.</p>';
    };
    
    if (isset($_GET['delete_goal'])){
        echo '<p>Goal deleted.</p>';
    };
    
    ?>
    
<div><h1 align=center>My Goals List</h1></div>
<!--create the table if there is results-->
<?php
    if ($search_result->num_rows >0) {
        ?>
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
            <td><strong>Visible by other users</strong></td>
            <td><strong>Edit this goal</strong></td>
            <td><strong>Delete this goal</strong></td>
        </tr>
    </thead>
    <tbody>
<!--display the information of each goal-->
        <?php while($row = $search_result->fetch_assoc()) { ?>
        <tr>
        <td><?php echo $row['goal_id']; ?></td>
        <td><?php echo $row['goal_name']; ?></td>
        <td><?php echo ($row['goal_description']==''? "-" : $row['goal_description']); ?></td>
        <td><?php echo ($row['goal_subtask']==''? "-" : $row['goal_subtask']); ?></td>
        <td><?php echo $row['goal_enddate']; ?></td>
        <td><?php echo (($row['goal_starttime'] != NULL)? date("H:i", strtotime($row['goal_starttime'])) : '-'); ?></td>
        <td><?php echo (($row['goal_endtime'] != NULL)? date("H:i", strtotime($row['goal_endtime'])) : '-'); ?></td>
        <td><?php echo ($row['goal_public']? "Yes":"No"); ?></td>
        <td><?php echo '<a href="edit_goal.php?goal_id='.$row['goal_id'].'">Edit</a>'; ?></td>
        <td><?php echo '<a href="delete_goal.php?goal_id='.$row['goal_id'].'">Delete</a>'; ?></td>
        </tr>
        <?php } ?>
    </tbody>

</table>
<?php
    } else
    echo "No results";
    ?>


