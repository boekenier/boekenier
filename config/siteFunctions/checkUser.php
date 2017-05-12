<?php
// Check if userpage exists otherwise show 404 error
if(!isset($_GET['user'])){
  header("Location: ../404.html");
}
?>
