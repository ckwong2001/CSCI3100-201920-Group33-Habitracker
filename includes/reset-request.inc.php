<!--backend code when one submit request for resetting password-->

<?php

if (isset($_POST["reset-request-submit"])) {

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

    //create a unique url for each password reset request 
$url = "localhost/habitracker/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
$expires = date("U") + 1800; //30 min from now

require 'dbh.inc.php'; //my database connection file

$userEmail = $_POST["email"]; 

$sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?;";  //make sure no existing token of the same user in database
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)){
    echo "There was an error!";
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $userEmail); 
    mysqli_stmt_execute($stmt);
}

    //update the database about the reset request 
$sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)){
    echo "There was an error!";
    exit();
} else {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires); 
    mysqli_stmt_execute($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

//send email to users for resetting their password automatically after they request 
$to = $userEmail; //send email to users

$subject = 'Reset your password for habitracker';

$message = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email or let us know.</p>';
$message .= '<p>The password reset is only valid for the next 30 minutes.</br>';
$message .= '<p>Here is your password reset link: </br>'; // .= means to continue the previous message
$message .= '<a href="' . $url . '">' . $url . '</a></p></br>';
$message .= '<p>Please send an email to noreply-habitracker@gmail.com if you have any queries.';

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
$mail->Subject = $subject;;
$mail->Body = $message;
$mail->AddAddress($to);

$mail->Send();

header("Location: ../reset-password.php?reset=success");

} else {
    header("Location: ../index.php");
}
