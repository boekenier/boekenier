<?php
require_once('../db.php');
$sql = "INSERT INTO invites (invite_code) VALUES ('$_POST[code]')";
if($conn->query($sql) === true){
  echo "success";
} else {
  echo "Error: ".$conn->error;
}
?>
