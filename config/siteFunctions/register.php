<?php
// Register script
require_once('../db.php');
// Check if invite code exists
$code = "SELECT * FROM invites WHERE invite_code = '$_POST[code]'";
$result = $conn->query($code);
if($result->num_rows > 0){
  $row = $result->fetch_assoc();
  if($row['used'] != 1){
    $passwd = hash('sha256', $_POST['password']);
    $sql = "INSERT INTO users (username, password) VALUES ('$_POST[username]', '$passwd')";
    // If everything is alright set invite to used
    $upd = "UPDATE invites SET used = 1 WHERE id = '$row[id]'";
    if($conn->query($upd) === true){
      if($conn->query($sql) === true){
        echo "success";
      } else {
        echo "Username already in use";
      }
    } else {
      echo "Oops something went wrong";
    }
  } else {
    echo "Code is already in use";
  }
} else {
  echo "Code does not exists";
}
?>
