<?php
require_once('../db.php');
$sql = "DELETE FROM Messages WHERE msg_id = '$_POST[msg_id]'";
if($conn->query($sql) === true){
  $sql = "DELETE FROM message_pivot WHERE pivot_id = '$_POST[pivot_id]'";
  if($conn->query($sql) === true){
    echo "Message deleted";
  } else {
    echo "Couldn't delete message";
  }
} else {
  echo "Couldn't delete message";
}
?>
