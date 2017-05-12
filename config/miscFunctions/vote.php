<?php
/* Warning this is deprecated
 * If you want to use it, then you need to fix bugs
 */
require_once('../db.php');
switch($_POST['vote']){
  case '+':
    $vote = 1;
    break;
  case '-':
    $vote = -1;
    break;
  default:
    echo "error";
    break;
}

$sql1 = "SELECT vote FROM books WHERE id = '$_POST[id]'";
$result = $conn->query($sql1);
if($result->num_rows > 0){
  $row = $result->fetch_assoc();
  $vote = $row['vote'] + $vote;
  $sql = "UPDATE books SET vote = '$vote' WHERE id = '$_POST[id]'";
  if($conn->query($sql) === TRUE){
    $sql2 = "INSERT INTO `voted` (`user_id`, `book_id`) VALUES ('$_POST[user]', '$_POST[id]')";
    if($conn->query($sql2) === true){
      echo "success";
    } else {
      echo $_POST['user']." ".$_POST['id']."<br/>";
      echo "FAILED: ".$conn->error;
    }
  } else {
    echo "FAILED: ".$conn->error;
  }
} else {
  echo "Error: book not found";
}
