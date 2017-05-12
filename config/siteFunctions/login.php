<?php
session_start();
require_once('../db.php');
if(isset($_POST['username']) && isset($_POST['password'])){
  $sql = "SELECT * FROM users WHERE username = '$_POST[username]'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $passwd = hash('sha256', $_POST['password']);
    if($row['username'] == $_POST['username'] && $row['password'] == $passwd) {
      $_SESSION['user'] = $row['id'];
      $_SESSION['rank'] = $row['rank'];
      echo "<script>window.location.href = '../../hidden/index.php';</script>";
    } else {
      $_SESSION['error'] = "Username or Password is incorrect";
      $_SESSION['username'] = $_POST['username'];
      echo "<script>window.location.href = '../../';</script>";
    }
  } else {
    $_SESSION['error'] = "Username or Password is incorrect";
    echo "<script>window.location.href = '../../';</script>";
  }
} else {
  $_SESSION['error'] = "You need to login first";
  echo "<script>window.location.href = '../../';</script>";
}
?>
