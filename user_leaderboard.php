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

    .btn p{
    position: relative;
    left: 35%;
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
    //retrieve information of the users in descending order according to score
    $sql = "SELECT * FROM login ORDER BY score DESC";
    $search_result = $conn->query($sql);
    
    ?>


<div><h1 align=center>Leaderboard</h1></div>
<?php
    //set up the table if there is results
    if ($search_result->num_rows >0) {
        $rank = 0;
        $same = 0; //to store number of consecutive users having the same score
        $score = 0;
        $found = 0;
        ?>
<table class="content-table">
    <thead>
        <tr>
            <th>Rank</th>
            <th>User</th>
            <th>Score*</th>
        </tr>
    </thead>

    <tbody>
<?php
    //display the results user by user
    while($row = $search_result->fetch_assoc()) {
        if (($rank+$same < 10)||($found==0)) {
            //we need more entries to display or we have not found the rank of this user
            if (($score != $row['score']) || ($rank==0)) {
                //if different score as the previous user
                $rank = $rank + $same + 1;
                $same = 0;
            } else {
                //if same score as the previous user
                $same = $same + 1;
            }
            $score = $row['score'];
            //find the rank of this user
            if ($row['user_id']==$_SESSION['user_id']) {
                $user_rank = $rank;
                $user_score = $row['score'];
                $found = 1;
            }
    ?>
<!--display the details of each of the top 10 users-->
<tr>
<td><?php echo $rank; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['score']; ?></td>
</tr>

<?php
        }
    }
    ?>

</tbody>
</table>

<?php
    }
    ?>
<!--display the rank of this user-->
<div><h1 align=center>My Ranking</h1></div>

<table class="content-table">
    <thead>
        <tr>
        <th>Rank</th>
        <th>User</th>
        <th>Score*</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td><?php echo $user_rank; ?></td>
        <td><?php echo $_SESSION['username']; ?></td>
        <td><?php echo $user_score; ?></td>
        </tr>
    <tbody>
</table>

<div class="btn">
    <p>* Remark: The scores are updated at midnight every day.</p>
</div>

</body>
