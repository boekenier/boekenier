<?php
session_start();
require_once("../config/db.php");
$sql = "UPDATE requests SET done = '$_POST[state]' WHERE id = '$_POST[id]'";
if($conn->query($sql) === true){
  echo "success";
} else {
  echo $conn->error;
}
?>
