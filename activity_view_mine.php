<?php
    require 'header.php';
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    
    if (isset($_GET['nonrecur_event_create'])){
        echo '<p>Non-recurring activity created.</p>';
    };
    
    if (isset($_GET['recur_event_create'])){
        echo '<p>Recurring activity created.</p>';
    };
    
    if (isset($_GET['edit'])){
        echo '<p>Activity updated.</p>';
    };
    
    if (isset($_GET['delete'])){
        echo '<p>Activity deleted.</p>';
    };
    
    if (isset($_GET['join'])){
        if ($_GET['join']=='success') {
            echo '<p>Activity joined.</p>';}
    };
    
    if (isset($_GET['quit'])){
        if ($_GET['quit']=='success') {
            echo '<p>Activity quited.</p>';}
    };
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

</style>

<body>

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
        //if the counter is zero, it means the user has not joined so return false
        if($cnt==0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    }
    
    require 'db_key.php';
    $conn = connect_db();
    $sql = "Select * from activity_table";
    $search_result = $conn->query($sql);
    
    ?>


<div><h1 align=center>My Activities List</h1></div>

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
            <th>Edit</th>
            <th>Quit</th>
        </tr>
    </thead>

    <tbody>
<?php
    while($row = $search_result->fetch_assoc()) {
        if (checkJoined($row['activity_id'],$user_id)==TRUE) //this implements the function in line 80 to 99
        {
    ?>

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

<td><?php echo ($row['username']!=$username? "-" : '<a href = "activity_edit.php?id='.$row['activity_id'].'">Click Here </a>'); ?></td>

<td><?php echo ($row['username']==$username? "-" : '<a href = "activity_quit_joined.php?id='.$row['activity_id'].'">Click Here</a>'); ?></td>

</tr>
<?php } } ?>

</tbody>
</table>
<?php
    } else
        //this is when the system cannot find any results
    echo "No results";
    ?>
</body>
