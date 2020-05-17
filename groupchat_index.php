//display the chat dialog box and corresponding information when users click on the group chat index page
//functions are included in this page 

<?php
    session_start();
    include('chatdatabase_connection.php');
    ?>

<style>
        ul {
            display:inline-block;
            vertical-align: top;
        }

        body {
            background-image: url('img/background.jpg');
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>

//displaying the header

<body>
<img src="img/logo.png" alt="Habitracker" height="50">

<br>

<ul>
<li><a href="index.php">Home</a></li>
</ul>

<ul>
<li><a href="user_leaderboard.php">Leaderboard</a></li>
<li><a href="search_goal.php">Search goals</a></li>
<li><a href="create_goal.php">Create goal</a></li>
<li><a href="mygoals.php">View my goals</a></li>
<li><a href="goal_progress_today.php">My progress today</a></li>
<li><a href="user_weekly_report.php">My weekly report</a></li>
</ul>

<ul>
<li><a href="activity_show_all_public_activities.php">Search activities</a>
<li><a href="activity_create_nonrecurring.php">Create non-recurring activity</a>
<li><a href="activity_create_new_event.php">Create recurring activity</a>
<li><a href="activity_view_mine.php">View my activities</a></li>
</ul>

<ul>
<li><a href="chatindex.php">Chat</a></li>
</ul>

<ul>
<li><a href="groupchat_index.php">Group chat</a></li>
</ul>

<ul>
<li><a href="profile_display.php">My profile</a></li>
<li><a href="user_setting.php">Settings</a></li>
<li><a href="change-password.php">Change password</a></li>
<?php
    if (isset($_SESSION['user_id'])){
        echo '<li><a href="includes/logout.inc.php">Logout</a></li>';
    }
    ?>
</ul>

<?php
    if(!isset($_SESSION['user_id'])) {
        header("location:index.php");
    }
    ?>

<html>
<head>
    <title>Chat with other users of Habitracker in the same activity</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div class="container">
    <br/>
    <h3 align="center">Chat with other users of Habitracker in the same activity</a></h3><br />
    <br/>

    <!--
        <input type="hidden" id="is_active_group_chat_window" value="no" />
        <button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs">Group Chat1</button> calling depends on id but not name-->
    

    <div class="table-responsive">
    <p align="right">Hi - <?php echo $_SESSION['username'];  ?></p>
    <div id="activity_details"></div>      <!--changed from user to activity-->
    <div id="user_model_details"></div>
    </div>
    </div>
</body>
</html>  


<script>  
//running the following functions every 5 seconds for real time chating 
//chat messages will be automatically updated at every interval 
    
$(document).ready(function(){

 fetch_activity(); //fetch activity details on webpage 

 setInterval(function(){
    update_last_activity();
    fetch_activity();
    update_chat_history_data();
    //fetch_group_chat_history();
 }, 5000);

 //fetch the activity details that one joined for display 
 function fetch_activity() 
 {
   
  $.ajax({
    url:"groupchat_fetch_user.php", 
    method:"POST",
    success:function(data){
    $('#activity_details').html(data); 
   }
  })
 }

//create a chat dialog box when one starts chating with users in the same activity
 function make_activity_dialog_box(activity_id, activity_name)
 {
  var modal_content = '<div id="activity_dialog_'+activity_id+'" class="user_dialog" title="You have chat with participants in '+activity_name+'">';
  modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-activityid="'+activity_id+'" id="chat_history_'+activity_id+'">';
  modal_content += fetch_activity_chat_history(activity_id);
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+activity_id+'" id="chat_message_'+activity_id+'" class="form-control chat_message"></textarea>';
  modal_content += '</div><div class="form-group" align="right">';
  modal_content+= '<button type="button" name="send_chat" id="'+activity_id+'" class="btn btn-info send_chat">Send</button></div></div>';
  $('#user_model_details').html(modal_content); //#is from html div tag line 66
 }
 
//create a dialog box when one clicks on the start group chat button
 $(document).on('click', '.start_group_chat', function(){     
    var activity_id = $(this).data('activityid');       //data- in fetch_user.php
    var activity_name = $(this).data('activityname');   //data- in fetch_user.php
    make_activity_dialog_box(activity_id, activity_name);   //using the upper two lines variable
    $("#activity_dialog_"+activity_id).dialog({            
    autoOpen:false,  //hide dialog on webpage
    width:400
    });
    $('#activity_dialog_'+activity_id).dialog('open'); //pop up chat dialog on webpage
 });
 
 //display one's chat message and corresponding informatino of the message when one sends a message by clicking the send button 
 //related information including content of text message, sender and time sent
 $(document).on('click', '.send_chat', function(){ 
  var activity_id = $(this).attr('id'); //activity_id is the POST in groupchat_insert chat.php, id not yet know
  var activity_chat_message = $('#chat_message_'+activity_id).val(); //fetch data from chat area field and store in this variable
  $.ajax({
   url:"groupchat_insert_chat.php",
   method:"POST",
   data:{activity_id:activity_id, activity_chat_message:activity_chat_message},
   success:function(data)   //success if can retrieve data from server
   {
    $('#chat_message_'+activity_id).val('');   //clear text area value, not sure #chat message refer to what, same with below
    $('#chat_history_'+activity_id).html(data);  
   }
  })
 });

/fetch the chat history of a certain activity
function fetch_activity_chat_history(activity_id) 
 {
  $.ajax({
   url:"groupchat_fetch_user_chat_history.php",
   method:"POST",
   data:{activity_id:activity_id}, //choose what variable to send to sever
   success:function(data){ //can receive chat history from server if success
    $('#chat_history_'+activity_id).html(data);
   }
  })
 }

 function update_chat_history_data() //display chat history of every chatbox opened in webpage for each interval
 {
    $('.chat_history').each(function(){ 
    var activity_id = $(this).data('activityid');  //data- in fetch_user.php
    fetch_activity_chat_history(activity_id);
    });
 }

 //hide the activity chat dialog box when one clicks the "cross" button 
 $(document).on('click', '.ui-button-icon', function(){
  $('.user_dialog').dialog('destroy').remove();
 });



});  
</script>

 
