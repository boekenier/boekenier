<?php
session_start();
require_once('../db.php');
$valid_file = true;
if($_FILES['profile_pic']['name']){
  if(!$_FILES['profile_pic']['error']){
    $new_file_name = $_POST['name'];
    if($_FILES['profile_pic']['size'] > (5000000)){
      $valid_file = false;
      echo "It appears that the file is to large";
    }
    $type = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
    if($type != 'png' && $type != 'jpeg' && $type != 'jpg' && $type !='gif') {
      $valid_file = false;
    }

    if($valid_file){
        if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], '../user/img/profile_pics/'.$new_file_name.'.'.$type)){
          echo "File has been uploaded";
        } else {
          echo "Something went wrong!";
        }
      $sql = "UPDATE users SET profile_pic = '$new_file_name.$type' WHERE username='$_POST[name]'";
      if($conn->query($sql) === false){
        echo "Something went wrong uploading the file";
      }
    } else {
      echo "Image is not a png, jpeg/jpg or gif file";
    }
  }
}
?>
