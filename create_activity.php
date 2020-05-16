//header of page and check authorized user
<?php
    require 'header.php';
    if( !isset( $_SESSION['username']) ){
        echo "You are not authorized to view this page. Go back <a href= '/'>home</a>";
        exit();
    } 
    ?>

//display of the info in the box
<body>
<div class = 'container'>
<div>
<div><h1>Welcome to the activity creation page, <?php echo $_SESSION['username'] ?>!</h1></div>
</div>
    
//content of the form for creating goal
<form action = 'activity_backend.php' method = 'POST'>
<div class = 'p-5 m-5'>
<div class="form-group">
<label>Activity name:</label>
<input class = 'form-control w-50' type="text" name="activity_name" required><br><br>

<input type="checkbox" name="activity_repetition">
<label for="activity_repetition">This is a recurring activity.</label><br><br>

<label>Date of activity/Day of the week for recurring activity:</label>
<input class = 'form-control w-50' type="text" name="activity_date" required><br><br>

<label>Time (Optional) (Please input the time in the form of hh:mm):</label>
<input type="number" name="activity_starttime_hh" min="0" max="23">
<label>:</label>
<input type="number" name="activity_starttime_mm" min="0" max="59">
<label> to </label>
<input type="number" name="activity_endtime_hh" min="0" max="23">
<label>:</label>
<input type="number" name="activity_endtime_mm" min="0" max="59"><br><br>

<label>Remark (Optional):</label>
<input class = 'form-control w-50' type="text" name="activity_remark"><br><br>

<div class ='text-center mt-3 w-50'>
<button class = 'btn btn-outline-info' type = 'submit' value = 'submit' name= 'create_activity'>Submit</button>
</div>
</div>
</div>
</form>
</div>
</body>
</html>


