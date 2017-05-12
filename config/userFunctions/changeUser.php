<?php
require_once('../db.php');
$sql = "SELECT * FROM users WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pass = hash('sha256', $_POST['oldPasswd']);
  switch ($_POST['type']) {
    case 'password':
      if($pass == $row['password']){
        if($_POST['pass'] == $_POST['pass2']){
          if(strlen($_POST['pass']) >= 8){
            $pass = hash('sha256',$_POST['pass']);
            $sql = "UPDATE users SET password = '$pass' WHERE id = '$_POST[id]'";
            if($conn->query($sql) === true){
              echo "success";
            } else {
              echo "Error: ".$conn->error;
            }
          } else {
            echo "Passwords has to be 8 characters long";
          }
        } else {
          echo "Passwords do not match";
        }
      } else {
        echo "Password not recognized!";
      }
      break;
    case 'theme':
      $sql = "UPDATE users SET theme_color = '$_POST[data]' WHERE id = '$_POST[id]'";
      if($conn->query($sql) === true){
        echo "success";
      } else {
        echo "Something went wrong";
      }
      break;
    default:
      echo "Type unknown";
      break;
  }
?>
