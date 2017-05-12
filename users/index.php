<?php
session_start();
include_once('../config/siteFunctions/allowedCheck.php');
include_once('../config/siteFunctions/checkUser.php');

require_once('../config/db.php');
// get other user data
$sql = "SELECT * FROM users WHERE username = '$_GET[user]'";
$result = $conn->query($sql);
if($result->num_rows == 0){
  echo "<script>window.location.href = '../404.html';</script>";
}
$row = $result->fetch_assoc();
if($row['id'] == $_SESSION['user']){
  echo "<script>window.location.href = '../user/';</script>";
}

/* this code is deprecated
   if you want to use it
   you need to kill the bugs first
$sql2 = "SELECT * FROM friends_pivot WHERE request_user_id = '$_SESSION[user]' AND receiver_user_id = '$row[id]' OR request_user_id = '$row[id]' AND receiver_user_id = '$_SESSION[user]'";
$result2 = $conn->query($sql2);
if($result2 != false && $result2->num_rows > 0){
  $row2 = $result2->fetch_assoc();
}
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - <?php echo $row['username'];?></title>
    <?php
    include_once '../css/head.html';
    ?>
    <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
  </head>
  <?php
  include_once('../css/nav.php');
  ?>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-md-10 offset-1">
            <div class="card">
              <div class="card-block">
                <div class="form-group">
                  <img src="../user/img/profile_pics/<?php echo $row['profile_pic'] == NULL ? "default.png" : $row['profile_pic'];?>" width="100" height="100"/>
                </div>
                <!-- <div class="pull-right">
                  <?php
                  if(isset($row2) && $row2['request_user_id'] == $_SESSION['user'] && $row2['request_accepted'] == 0){?>
                    <button id="cancelFriend" onclick="cancelFriend(<?php echo $row['id'];?>, <?php echo $_SESSION['user'];?>)" class="btn btn-primary"> Friend request sent</button>
                  <?php } elseif(isset($row2) && $row2['request_accepted'] == 1) { ?>
                    <button id="deleteFriend" onclick="deleteFriend(<?php echo $row['id'];?>, <?php echo $_SESSION['user'];?>)" class="btn btn-danger"> Unfriend</button>
                  <?php } else { ?>
                    <button id="addFriend" onclick="addFriend(<?php echo $row['id'];?>, <?php echo $_SESSION['user'];?>)" class="btn <?php echo isset($_GET['request']) && $_GET['request'] === 'yes' ? 'btn-warning' : 'btn-success';?>"><?php echo isset($_GET['request']) && $_GET['request'] === 'yes' ? 'Accept Friend Request' : 'Add as friend';?></button>
                  <?php } ?>
                </div> -->
                <div class="from-group">
                  <div id="output" style="display: none;">
                  </div>
                </div>
                <div class="form-group">
                  <h3 id='username'><?php echo $row['username'];?></h3>
                </div>
                <div class="form-group">
                  <input id="subject" type="text" class="form-control" placeholder="Subject">
                </div>
                <div class="form-group">
                  <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                  <button onclick="send(<?php echo $row['id'];?>, <?php echo $_SESSION['user'];?>)" class="btn btn-primary pull-right"><i class="fa fa-send"></i> Send</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="../js/main.js"></script>
      <script>CKEDITOR.replace('message');</script>
      <script>
      var reply = getUrlParameter('reply');
      var subject = getUrlParameter('title');
      if(reply == 1){
        $("#subject").val('RE: '+subject); // if message is a reply add RE: infront of subject
      }
      </script>
  </body>
</html>
