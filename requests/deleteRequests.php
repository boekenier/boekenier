<?php
require_once('../config/db.php');
$sql = "DELETE FROM requests WHERE id = '$_POST[id]'";
if($conn->query($sql) === true){
  echo "success";
} else {
  echo $conn->error;
}
?>
