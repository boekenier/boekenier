<?php
require_once('../db.php');
$sql = "DELETE FROM friends_pivot WHERE receiver_user_id = '$_POST[sendId]' AND request_user_id = '$_POST[receiveId]' OR request_user_id = '$_POST[sendId]' AND receiver_user_id = '$_POST[receiveId]'";
if($conn->query($sql) === true){
  echo "success";
} else {
  echo "Something went wrong<br/>$conn->error";
}
?>
