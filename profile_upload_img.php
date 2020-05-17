
<!--user can upload their profile picture after they select a valid picture from their computer and click the upload button-->

<?php
session_start();

require 'db_key.php';
$conn = connect_db();
$id = $_SESSION['user_id'];


//check the validity of one's uploaded image such as the file type and the file size
if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allowed = array('jpg','jpeg','png','pdf');

    
  //direct the user back to the profile display page after they have uploaded their profile picture
  
    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if ($fileSize < 500000){
                $fileNameNew = "profile".$id.".".$fileActualExt;
                $fileDestination = 'upload_image/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE login SEt image_status=0 WHERE user_id = '$id';";
                $search_result = $conn->query($sql);
                
                header("Location: ../habitracker/profile_display.php?upload=success");
                
//change the url into corresponding error names for the display profile page to display error messages
                
            } else {
                header("Location: ../habitracker/profile_display.php?error=filetoobig");
            }

        } else {
            header("Location: ../habitracker/profile_display.php?error=error");
        }

    } else {
        header("Location: ../habitracker/profile_display.php?error=wrongtype");
    }
}


