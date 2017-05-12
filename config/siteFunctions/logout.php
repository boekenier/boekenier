<?php
// Logout script
session_start();
session_unset('user');
session_destroy();
if(!isset($_SESSION['user'])){
  echo "<script>window.location.href = '../../';</script>";
} else {
  echo "not logged out";
}

?>
