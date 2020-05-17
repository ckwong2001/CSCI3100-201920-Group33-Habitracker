<!--backend application when user submit a change password request to the server-->
<?php

session_start();
$username = $_SESSION['username'];
//$username = $_SESSION['userUid'];

//allocate variables to store the input by the user in the frontend page
if (isset($_POST["change-password-submit"])) {
    $existPassword = $_POST["exist-pwd"];
    $newPassword = $_POST["new-pwd"];
    $repeatPassword = $_POST["repeat-pwd"];
 
    //redirect user back to the change password page with different url according to their corresponding invalid input 
    if (empty($existPassword) || empty($newPassword) || empty($repeatPassword) ) {
        header("Location: ../change-password.php?changepwd=empty");
        exit();

    } else if ($newPassword != $repeatPassword) {
        header("Location: ../change-password.php?changepwd=pwdnotsame");
        exit();
    }

    require 'dbh.inc.php';

    //to retrieve and change users' password in the database 
    $sql = "SELECT * FROM login WHERE username=?;";
    $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            echo "There was an error!";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username); 
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) { 
                echo "You need to re-submit your reset request.";
                exit();

            } else {
                //check if the current password entered by the user is correct for security reason
                $passwordCheck = password_verify($existPassword, $row["password"]);
                //$passwordCheck = password_verify($existPassword, $row["pwdUsers"]);
                if ($passwordCheck === false){
                    
                    header("Location: ../change-password.php?changepwd=wrongpwd");
                    exit();
                } else if ($passwordCheck === true){

                    //update the new password entered by the user in the database 
                    $sql = "UPDATE login SET password=? WHERE username=?;";
                    //$sql = "UPDATE users SET pwdUsers=? WHERE uidUsers=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)){
                            echo "There was an error!";
                            exit();
                        } else {
                            //redirect the user back to the change password front page after successful update 
                            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash, $username); 
                            mysqli_stmt_execute($stmt);
                            header("Location: ../change-password.php?changepwd=passwordupdated");
                    
                        }
                }
            }
        }
    }



?>
