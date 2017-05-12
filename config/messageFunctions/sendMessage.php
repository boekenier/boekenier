<?php
require_once('../db.php');
// Escape subject and strip tags
$subject = $conn->real_escape_string(strip_tags($_POST['subject']));
// Escape message, because of wysiwg xss is not possible so no strip_tags
$message = $conn->real_escape_string($_POST['message']);
// Insert message into database
$sql = "INSERT INTO Messages (subject, message) VALUES ('$subject','$message')";
if($conn->query($sql) === true){
  $lastId = $conn->insert_id; // Get last inserted id

  // Insert message id, and two user ids into database
  $sql2 = "INSERT INTO message_pivot (from_id, to_id, message_id) VALUES ('$_POST[from]', '$_POST[to]', '$lastId')";
  if($conn->query($sql2) === true){
    echo "Message send";
  } else {
    echo "Couldn't send message <br/>Error: $conn->error</br>".$sql2;
  }
} else {
  echo "Couldn't send message <br/>Error: $conn->error";
}
?>
