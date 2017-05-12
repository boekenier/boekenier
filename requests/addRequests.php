<?php
require_once('../config/db.php');
$sql = "INSERT INTO requests (requestTitle) VALUES ('$_POST[title]')";
if($conn->query($sql) === true){
  echo "success";
} else {
  echo $conn->error;
}
?>
