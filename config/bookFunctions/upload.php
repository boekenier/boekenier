<?php
session_start();
require_once('../db.php');
date_default_timezone_set('Europe/Amsterdam'); // Set timezone to Amsterdam
$valid_file = true;
if($_FILES['file']['name']){
  if(!$_FILES['file']['error']){
    $new_file_name = hash('sha256',$_FILES['file']['tmp_name']);
    if($_FILES['file']['size'] > (1000000000)){ // Check file size
      $valid_file = false; // If file is too big set valid_file false
      $_SESSION['message'] = "It appears that the file is to large";
      echo "It appears that the file is to large";
      echo "<script>window.location.href = '../admin';</script>";
    }
    $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if($type != 'zip') { // Check if extension is zip
      $valid_file = false; // else set false
    }
    if($valid_file){ // if valid_file is true
        // Move file to folder
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../files/'.$new_file_name.'.bkcrypt')){
          echo "File has been uploaded";
        } else {
          $_SESSION['message'] = "Couldn't move file";
        }
      }
      $date = new DateTime(); // set DateTime
      $date = date_format($date, 'Y-m-d H:i:s'); // Format date to Y-m-d H:i:s
      // Add book info to database
      $sql = "INSERT INTO books (name, author, filename, version, type, created_at) VALUES ('$_POST[title]', '$_POST[author]', '$new_file_name', '$_POST[version]', '$type', '$date')";
      if($conn->query($sql) === false){
        // If inserting failed show message
        $_SESSION['message'] = 'Something went wrong uploading the file';
        echo "Something went wrong uploading the file";
        echo "<script>window.location.href = '../admin';</script>";
      }
    } else {
      // If file is not zipped show message
      $_SESSION['message'] = 'File is not zipped';
      echo "File is not ziped";
      echo "<script>window.location.href = '../admin';</script>";
    }
  }
?>
