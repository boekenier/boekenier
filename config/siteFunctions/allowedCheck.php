<?php
// if user is not logged in show 403 error
if(!isset($_SESSION['user'])){
  header("Location: ../403.html");
}
?>
