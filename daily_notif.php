<?php

//when daily notification is triggered

$connect = new PDO("mysql:host=localhost;dbname=Habitracker", "root", "");
session_start();

$query = "SELECT * FROM login where receive_dailyreminder = '1'";
//for query above WHERE boolean of sending daily notif is true

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
    $username = $row['username'];
    $today = date("Y-m-d", time());
    //select goals of the user that are not ended
    $query = "SELECT * FROM goals WHERE username = '$username' and goal_enddate >= '$today'";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result_2 = $statement->fetchAll();
    
    //details of the email
    $to = $row['email'];
    $url = "localhost/habitracker/login.php";

    $subject = '[Habitracker] Your daily reminder';
    $message = '<img src="cid:logo" width="200">';
    $message .= '<p>Hello '.$row['username'].',</p>';
    $message .= '<p>Keep up with your good work with the help of Habitracker!';
    $message .= '<p>Habit is a cable; we weave a thread each day, and at last we cannot break it. -Horace Mann';
    $message .= '<p>Keep up with your goals and track your habits today! </br>';
    $message .= '<p>Your goal(s) today include:</br>';

    $message .= '<ul>';
    foreach($result_2 as $row_2){
        $message .= '<li>'.$row_2['goal_name'].'';
    }
    $message .= '</ul>';
    
    $message .= '<p>It is never too late to start a habit! Want to equip yourself with a new skill or pick up a new interest?';
    $message .= '<p>Do not hesitate and create your new habit in ';
    $message .= '<a href="' . $url . '"> Habitracker</a>!</p>';

    $message .= '<p>Please send an email to noreply-habitracker@gmail.com if you have any queries.';
    $message .= '<p> ';
    
    $message .= '<p>Cheers,';
    $message .= '<p>Team Habitracker';

    require_once('PHPMailer-5.2-stable/PHPMailerAutoload.php');

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true; //tell phpmailer to authenticate with gmail
    $mail->SMTPSecure = 'ssl'; //to use gmail need to connect sll
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username = 'noreply.habitracker@gmail.com';//your own email address
    $mail->Password = 'csci3100';
    //$mail->SetFrom('no-reply@howcode.org');
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($to);
    $mail->AddEmbeddedImage('img/logo.png','logo');

    $mail->Send();

    }
