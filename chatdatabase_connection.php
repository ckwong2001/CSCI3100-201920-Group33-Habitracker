<?php

//to connect the database for the chat function 

$connect = new PDO("mysql:host=localhost;dbname=Habitracker", "root", "");

date_default_timezone_set('Asia/Hong_Kong');

//fetch users' last activity 
function fetch_user_last_activity($user_id, $connect)
{
 $query = "
 SELECT * FROM login_details 
 WHERE user_id = '$user_id' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}

//fetch chat messages from 2 people in the private chat dialog box and arrange the messages in chronological order
function fetch_user_chat_history($from_user_id, $to_user_id, $connect) 
{
 $query = "
 SELECT * FROM chat_message 
 WHERE (from_user_id = '".$from_user_id."' 
 AND to_user_id = '".$to_user_id."') 
 OR (from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."') 
 ORDER BY timestamp DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row) //fetch data from result
    {
        $user_name = '';
        if($row["from_user_id"] == $from_user_id) //sucess means particular user send a message
        {
         $user_name = '<b class="text-success">You</b>';
        }
        else
        {
         $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
        }
            //display chat message text and time of chat (below)
            $output .= '
            <li style="border-bottom:1px dotted #ccc">
            <p>'.$user_name.' - '.$row["chat_message"].'
            <div align="right">
                - <small><em>'.$row['timestamp'].'</em></small>
            </div>
            </p>
            </li>
            ';
            }
            $output .= '</ul>';
            $query = "
            UPDATE chat_message
            SET status = '0'
            WHERE from_user_id = '".$to_user_id."'
            AND to_user_id = '".$from_user_id."'
            AND status = '1' 
            "; //update message from unseen to seen by changing from 0 to 1
            $statement = $connect->prepare($query);
            $statement->execute();
            return $output; 
        }

        //fetch username of the user whom one is chating with and for displaying that user's name in the dialog box
        function get_user_name($user_id, $connect)
        {
         $query = "SELECT username FROM login WHERE user_id = '$user_id'";
         $statement = $connect->prepare($query);
         $statement->execute();
         $result = $statement->fetchAll();
         foreach($result as $row)
         {
          return $row['username'];
         }
        }

        //count number of unseen message received from a particular user 
        function count_unseen_message($from_user_id, $to_user_id, $connect)
        {
            $query = "
            SELECT * FROM chat_message
            WHERE from_user_id = '$from_user_id'
            AND to_user_id = '$to_user_id'
            AND status = '1'
            ";
            $statement = $connect->prepare($query);
            $statement->execute();
            $count = $statement->rowCount();
            $output = '';
            if($count > 0)
            {
                $output = '<span class="label label-success">' .$count. '</span>';
            }
            return $output;
        }


        //for displaying whether the user one is chating with is typing online
        function fetch_is_type_status($user_id, $connect)
        {
            $query ="
            SELECT is_type FROM login_details
            WHERE user_id = '".$user_id."'
            ORDER BY last_activity DESC
            LIMIT 1
            ";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $output = '';
            foreach($result as $row)
            {
                if($row["is_type"] == 'yes')
                {
                    $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
                }
            }
            return $output;
        }

//fetch chat history for groupchat system, similar to private chat system
function fetch_activity_chat_history($from_user_id, $activity_id, $connect) 
{

 $query = "
 SELECT * FROM activity_chat_message 
 WHERE activity_id = '".$activity_id."' 
 ORDER BY timestamp DESC
 ";

 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row) //fetch data from result
    {
        $user_name = '';
        if($row["from_user_id"] == $from_user_id) //sucess means particular user send a message
        {
         $user_name = '<b class="text-success">You</b>';
        }
        else
        {
         $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
        }
            //display chat message text and time of chat (below)
            $output .= '
            <li style="border-bottom:1px dotted #ccc">
            <p>'.$user_name.' - '.$row["chat_message"].'
            <div align="right">
                - <small><em>'.$row['timestamp'].'</em></small>
            </div>
            </p>
            </li>
            ';
            }
            $output .= '</ul>';
            $query = "
            UPDATE activity_chat_message
            SET status = '0'
            WHERE activity_id = '".$activity_id."' 
            AND status = '1' 
            "; //update message from unseen to seen by changing from 0 to 1
            $statement = $connect->prepare($query);
            $statement->execute();
            
            return $output; 
        }

?>
