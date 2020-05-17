<!doctype html>
<html lang="en">
<?php
	
	  //this is the code to  store some important functions of activity modification
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the backend operation activity of the "Activities" section
  //this is written on 21 April 2020
  //this program allows users to edit specific event
  //the program reads the activity_id and query it in mysql 
    require 'header.php';
    ?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" >
	<meta charset="utf-8">
	<title>Index Page of Activity</title>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

	<style type="text/css">
		table.tableizer-table {
			font-size: 12px;
			border: 1px solid #CCC;
			font-family: Arial, Helvetica, sans-serif;
		}
		.tableizer-table td {
			padding: 4px;
			margin: 3px;
			border: 1px solid #CCC;
		}
		.tableizer-table th {
			background-color: #B8D5BF;
			color: #FFF;
			font-weight: bold;
		}
	</style>

	<style >



	fieldset {
		border: 0;
	}
	label {
		display: block;
		margin: 30px 0 0 0;
	}
	.overflow {
		height: 200px;
	}

</style>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!--
<script>
$( function() {
	$( "#tabs" ).tabs();
} );
</script>



</head>
<body>

	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Introduction</a></li>
			<li><a href="#tabs-2">View My Activities</a></li>
			<li><a href="#tabs-3">Join exisitng activities</a></li>
			<li><a href="#tabs-4">Create a new non-recurring activity</a></li>
			<li><a href="#tabs-5">Create a new recurring activity</a></li>
		</ul>

		<div id="tabs-1">
			<p>
				Introducing why we have this function
			</p>
			<ul>
				<li>List item one</li>
				<li>List item two</li>
				<li>List item three</li>
			</ul>
		</div>

		<div id="tabs-2">
			<p>
				<?php
				include_once "activity_view_mine.php";
				?>
			</p>
		</div>

		<div id="tabs-3">
			<p>
				<?php

				include_once "activity_show_all_public_activities.php";


				?>
			</p>
		</div>

		<div id="tabs-4">
			<p>You can also try an event for once and see if it suits your interest or whether you enjoy your new hobby-buddy</p>
			<?php include_once "activity_create_nonrecurring.php"; ?>
		</div>

		<div id="tabs-5">
			<p>Recurring is an event that happens once, twice or even more times per week. This can make you stick to an activity and form a new habit</p>
			<?php include_once "activity_create_new_event.php"; ?>
		</div>


	</div>

</body>
-->
<?php
function displayOneOff($data,$username){



$conn = mysqli_connect("localhost","root","","Habitracker");

if($username==NULL){
	$sql = "SELECT * FROM activity_table WHERE activity_repetition = ".$data." ";
}else{
	$sql = "SELECT * FROM activity_table WHERE activity_repetition = ".$data." AND username = '".$username." '";
}
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

			echo" <tr>";

				if($row['activity_status_open'] == 1 ){

					if($data == 0){
					echo "<td>&nbsp;</td><th>".$row['activity_name']."  </th>";
					$date = date('yy:m:d-h:i', strtotime($row['activity_one_off_datetime']));
					echo "<th>".$date."  </span>";
					}


					echo "<th>".$row['activity_location']."  </th>";


					echo "<th>".$row['username']."</th>";



					$id = $row['activity_id'];

					echo '<th> <a href = "activity_display_details.php?id='.$id.'">Click Here </a> </th>';

					echo '<th> <a href = "activity_display_joined_users.php?id='.$id.'">Click Here</a> </th>';


					// echo '<form action = "activity_display_joined_users.php" method="GET">
					// 		<button type="submit" name="id" value='.$id.'> Member Lists </button> </form></th>';
				}
			echo"</tr>";
		}
}
	function displayRecurring($data,$username){



	$conn = mysqli_connect("localhost","root","","Habitracker");

	if($username==NULL){
		$sql = "SELECT * FROM activity_table WHERE activity_repetition = ".$data." ";
	}else{
		$sql = "SELECT * FROM activity_table WHERE activity_repetition = ".$data." AND username = '".$username." '";
	}


	$result = mysqli_query($conn,$sql);

	while($row = mysqli_fetch_assoc($result)){

				echo" <tr>";

					if($row['activity_status_open'] == 1 ){

						if($data >= 1){
						echo "<td>&nbsp;</td><th>".$row['activity_name']."  </th>";
						echo "<th>".$row['activity_recurring_date_0']."  </th>";
						$date = date('h:i', strtotime($row['activity_recurring_time_0']));
						echo "<th>".$date."  </span>";
						}

						if($data >= 2){
						echo "<th>".$row['activity_recurring_date_1']."  </th>";
						$date = date('h:i', strtotime($row['activity_recurring_time_1']));
						echo "<th>".$date."  </span>";
						}

						if($data >= 3){
						echo "<th>".$row['activity_recurring_date_2']."  </th>";
						$date = date('h:i', strtotime($row['activity_recurring_time_2']));
						echo "<th>".$date."  </span>";
						}


						echo "<th>".$row['activity_location']."  </th>";


						echo "<th>".$row['username']."</th>";



						$id = $row['activity_id'];

						echo '<th> <a href = "activity_display_details.php?id='.$id.'">Click Here </a> </th>';

						echo '<th> <a href = "activity_display_joined_users.php?id='.$id.'">Click Here</a> </th>';


						// echo '<form action = "activity_display_joined_users.php" method="GET">
						// 		<button type="submit" name="id" value='.$id.'> Member Lists </button> </form></th>';
					}
				echo"</tr>";
			}
	}
?>
</html>
