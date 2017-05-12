<?php
require_once('../db.php');
$subject = $conn->real_escape_string(strip_tags($_POST['subject']));
$message = $conn->real_escape_string($_POST['message']);
$sql = "INSERT INTO Messages (subject, message) VALUES ('$subject','$message')";
if($conn->query($sql) === true){
  $lastId = $conn->insert_id;
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
