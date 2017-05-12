<?php
require_once('../db.php');
// Get senders username
$sqlUsers = "SELECT username FROM users WHERE id = '$_POST[sendId]'";
$result = $conn->query($sqlUsers);
$row = $result->fetch_assoc();

// check if user has already a friend request
$sql = "SELECT * FROM friends_pivot WHERE receiver_user_id = '$_POST[sendId]' AND request_user_id = '$_POST[receiveId]'";
$result = $conn->query($sql);
// if user has a friend request then accept it.
if($result->num_rows > 0 && $result != false){
  $sql = "UPDATE friends_pivot SET request_accepted = 1 WHERE receiver_user_id = '$_POST[sendId]' AND request_user_id = '$_POST[receiveId]'";
  if($conn->query($sql) === true){
    $sql = "INSERT INTO friends (friend1, friend2) VALUES ('$_POST[sendId]', '$_POST[receiveId]')";
    if($conn->query($sql) === true){
      echo "success";
    } else {
      echo "Something went wrong<br/>$conn->error";
    }
  } else {
    echo "Something went wrong<br/>$conn->error";
  }
} else {
  // Insert friend request in friends_pivot table
  $sql = "INSERT INTO friends_pivot (request_user_id, receiver_user_id) VALUES ('$_POST[sendId]', '$_POST[receiveId]')";
  // If friend request has been created send a message to the receiving user
  if($conn->query($sql) === true){
    $msg = "<h2>Friend Request</h2>
    <p>$row[username] wants to be friends with you</p>
    <p>Click the link to accept, other just delete this message</p>
    <p><a href='../users?user=$row[username]&request=yes' class='btn btn-success'>Accept</a></p>";
    $msg = $conn->real_escape_string($msg);
    $sql = "INSERT INTO Messages (subject, message) VALUES ('$row[username] wants to be friends', '$msg')";
      if($conn->query($sql) === true){
        $lastId = $conn->insert_id;
        $sql = "INSERT INTO message_pivot (from_id, to_id, message_id) VALUES ('$_POST[sendId]', '$_POST[receiveId]', '$lastId')";
        if($conn->query($sql) === true){
          echo "success";
        } else {
          echo "Something went wrong<br/>$conn->error";
        }
      } else {
        echo "Something went wrong<br/>$conn->error";
      }
  } else {
    echo "Something went wrong<br/>$conn->error";
  }
}
?>
