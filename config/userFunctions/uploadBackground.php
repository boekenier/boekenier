<?php
// Upload a background image provided by user
session_start();
require_once('../db.php');
$valid_file = true;
if($_FILES['background']['name']){
  if(!$_FILES['background']['error']){
    $new_file_name = $_POST['name'].'-background';
    if($_FILES['background']['size'] > (5000000)){
      $valid_file = false;
      echo "It appears that the file is to large";
    }
    $type = pathinfo($_FILES['background']['name'], PATHINFO_EXTENSION);
    if($type != 'png' && $type != 'jpeg' && $type != 'jpg' && $type !='gif') {
      $valid_file = false; // type is not png jpeg or gif then set valid_file false
    }

   if($valid_file){ // valid_file is true
      // move file to folder
        if(move_uploaded_file($_FILES['background']['tmp_name'], '../../user/img/profile_pics/'.$new_file_name.'.'.$type)){
          echo "File has been uploaded";
        } else {
          echo "Something went wrong!";
        }
        // if move is successfull set background to file location
      $sql = "UPDATE users SET background = '$new_file_name.$type', theme_color = NULL WHERE username='$_POST[name]'";
      if($conn->query($sql) === false){
        echo "Something went wrong uploading the file";
      }
    } else {
      echo "Image is not a png, jpeg/jpg or gif file";
    }
  }
}
?>
