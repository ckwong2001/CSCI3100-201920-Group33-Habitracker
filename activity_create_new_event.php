<!doctype html>
<html lang="en">
<head>

  <?php
  //activity_create_new_event is the code to create new event
  //Contributed by Ivan Lai (1155143433)
  //this php fits in the create activity of the "Activities" section
  //this is written on 22 April 2020
  //this program allows users to pick time and date and name for activities
  //the program reads date and some string inputs to desrcibe the event
  require 'header.php';
  ?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="activity_create_new_event.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#timepicker1" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );
  $( function() {
    $( "#timepicker2" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );  $( function() {
    $( "#timepicker3" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );  $( function() {
    $( "#timepicker4" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );  $( function() {
    $( "#timepicker5" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );  $( function() {
    $( "#timepicker6" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );  $( function() {
    $( "#timepicker7" ).timepicker({interval: 15,timeFormat: 'HH:mm:ss',startTime: new Date(0,0,0,0,0,0) });
  } );
  </script>

</head>

<body>

<div class="loginbox">
<div><h1>Create recurring activity</h1></div>
<div><h3>- <?php echo $_SESSION['username']?>, create a recurring activity now and meet some new hobby-buddies!(ง •̀_•́)ง</h3></div>
  <p style="font-weight:normal;">A recurring activity happens once, twice or even more times per week. This can make you stick to an activity and form a new habit</p>
  <form action="includes/recurring_created.php" method="POST">
    <h3>Basic information of the activity</h3>
    <p>Name: <input type="text" name="activityName" placeholder="Name of the activity" required></p>
    <div class="widget">


      <h3>On which day(s) of the week do you want to host this activity?</h3>
      <p style="font-weight:normal;">Choose the time of the activity under each day of the week that you want to host it.</p>
      <p style="font-weight:normal;">An activity can only occur three times per week at max, if you want to do something on a daily basis, <a href="create_goal.php">start a goal</a>.</p>
        <ul>
        <div class="select-time">
          <li>Monday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker1" id="timepicker1"></p>

          <li>Tuesday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker2"  id="timepicker2"></p>

          <li>Wednesday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker3"  id="timepicker3"></p>

          <li>Thursday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker4" id="timepicker4"></p>

          <li>Friday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker5" id="timepicker5"></p>

          <li>Saturday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker6" id="timepicker6"></p>

          <li>Sunday</li>
          <p>Select Time: <input type="text" placeholder="time not selected" name="timepicker7" id="timepicker7"></p>
          </div>
        </ul>
      </div>
      <h3>Supplementary details of this activity</h3>
        <p>Location:
        <select name="Locationnumber" id="Locationnumber">
            <option>Islands</option>
            <option>Kwai Tsing</option>
            <option>Kwai Tsing</option>
            <option>North</option>
            <option>Sai Kung</option>
            <option>Sha Tin</option>
            <option>Tai Po</option>
            <option>Tsuen Wan</option>
            <option>Tuen Mun</option>
            <option>Yuen Long</option>
            <option>Kowloon City</option>
            <option>Kwun Tong</option>
            <option>Sham Shui Po</option>
            <option>Wong Tai Sin</option>
            <option>Yau Tsim Mong</option>
            <option>Central & Western</option>
            <option>Eastern</option>
            <option>Southern</option>
            <option>Wan Chai</option>
            <option>Online</option>
        <option selected="selected">Others</option>
        </select></p>

      <p><br />Remark on the date and time (Optional): <input type="text" name="timeRemark" placeholder="Time remark of the activity"></p>

      <p>General Remark (Optional): <input type="text" name="Remark" placeholder="General remark of the activity"> </p><br/>

        <button type="submit" name="submitRecur">Create!</button>

      </form>
      </div>

      <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    </body>
    </html>
