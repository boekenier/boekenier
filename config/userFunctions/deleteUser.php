<?php
session_start();
require_once('../db.php');
if($_SESSION['user'] != $_POST['id']){
  $sql = "DELETE FROM users WHERE id = '$_POST[id]'";
  if($conn->query($sql) === true){
    echo "success";
  } else {
    echo "User was not deleted";
  }
} else {
  echo "You can't delete yourself, bitch";
}
?>
