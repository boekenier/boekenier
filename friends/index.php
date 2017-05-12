<!-- this file is deprecated
     if you want to use it
     then you need to kill
     the bug first -->
<?php
session_start();
include_once('../config/siteFunctions/allowedCheck.php');
require_once('../config/db.php');
$sql = "SELECT users.id, users.username, users.profile_pic, friends.* FROM friends LEFT JOIN users ON friends.friend1 WHERE friends.friend1 = '$_SESSION[user]' OR friends.friend2 = '$_SESSION[user]'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier</title>
    <?php
    include_once '../css/head.html';
    ?>
  </head>
  <?php
  include_once('../css/nav.php');
  ?>
  <style>
    .friends-img {
      margin: 5px;
    }
    .friends-name {
      display: block;
    }
    div.item {
      vertical-align: top;
      display: inline-block;
      text-align: center;
      width: 120px;
    }
    a {
      color: black;
    }

    a:hover {
     text-decoration-style: none;
    }
  </style>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-md-10 offset-md-1">
          <div class="card">
            <div class="card-block">
              <h5 class="text-center">My Friends</h5>
              <?php
                  if($result != false && $result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                ?>
                <?php if($row['id'] != $_SESSION['user']){?>
                <a href="../users/?user=<?php echo $row['username'];?>">
                  <div class="item">
                    <img class="friends-img" src="../user/img/profile_pics/<?php echo $row['profile_pic'] == NULL ? 'default.png' : $row['profile_pic'];?>" alt="<?php echo $row['username'];?>" width="100" height="100">
                    <span class="friends-name"><?php echo $row['username'];?></span>
                  </div>
                </a>
                <?php
                  }
                }
              } else {
                echo "<p>Oow, boohoo you don't have any friends</p>
                <p>Then go find them moron</p><br/><img src='https://i.imgur.com/frgOnVX.jpg' width='250' height='250'>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
      <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
      </script>
      <script src="../js/main.js"></script>
  </body>
</html>
