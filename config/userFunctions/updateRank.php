<?php
// Update users rank by givin id
require_once('../db.php');
$sql = "UPDATE users SET rank = '$_POST[rank]' WHERE id = '$_POST[id]'";
if($conn->query($sql) === TRUE){
  echo "success";
} else {
  echo $conn->error;
}
?>
