<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - Chat</title>
    <?php include_once('../css/head.html');?>
  </head>
  <body>
    <?php include_once('../css/nav.php');?>
    <!-- load irc -->
    <iframe src="https://kiwiirc.com/client/chat.freenode.com/?nick=<?php echo $userRow['username'];?>&theme=cli#boekenier" style="border:0; width:100%; height:500px;"></iframe>
  </body>
</html>
