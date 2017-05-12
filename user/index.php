<?php
session_start();
include_once('../config/siteFunctions/allowedCheck.php');
require_once('../config/db.php');
$sql = "SELECT * FROM users WHERE id = '$_SESSION[user]'";
$result = $conn->query($sql);
if($result->num_rows == 0){
  echo "<script>window.location.href = '../403.html';</script>";
}
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - <?php echo $row['username'];?></title>
    <?php
    include_once '../css/head.html';
    ?>
    <style>
    .form-group img {
      cursor: pointer;
    }
    </style>
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
                <div id="output" style="display: none;"></div>
                <div class="form-group">
                  <form action="../config/userFunctions/uploadProfilePic.php" class="hidden" id="uploadForm">
                    <label for="fileupload">
                      <img src="img/profile_pics/<?php echo $row['profile_pic'] == NULL ? "default.png" : $row['profile_pic'];?>" width="100" height="100"/>
                    </label>
                  <input id='fileupload' type="file" name="profile_pic" class="hidden" accept="image/*" style="display: none;">
                  <input id="name" type="hidden" name="name" value="<?php echo $row['username'];?>">
                </form>
                  <span id="fileOutput" style="display: none;"></span>
                </div>
                <h3 id='username'><?php echo $row['username'];?></h3>
                <br/>
                <h5>Change password</h5>
                <hr/>
                <div class="form-group">
                  <input type='password' id='oldpassword' class="form-control" placeholder="Enter old password"/>
                </div>
                <div class="form-group">
                  <input type='password' id='password' class="form-control" placeholder="Enter new password"/>
                </div>
                <div class="form-group">
                  <input type="password" id="password2" class="form-control" placeholder="Repeat password"/>
                </div>
                <div class="form-group">
                  <button type="button" onclick='changeUser("password", <?php echo $row['id'];?>)' class="btn btn-warning">Change password</button>
                </div>
                <hr/>
                <br/>
                <h5>Theme</h5>
                <hr/>
                <form action="../config/userFunctions/uploadBackground.php" id="imageTheme">
                  <input type="file" id="input" name="background" accept="image/*" class="hidden">
                  <input id="name" type="hidden" name="name" value="<?php echo $row['username'];?>">
                </form>
                <div id="preview" style="display: none;">
                  <img src="" id="previewSrc">
                </div>
                <br/>
                <input type="color" id="themeColor"  value="<?php echo $row['theme_color'] == NULL ? '#ffffff' : $row['theme_color'];?>" onchange="colorPick()" style="width:100%;"/>
                <br/>
                <button type='button' onclick="changeUser('theme', <?php echo $row['id'];?>)" class="btn btn-warning">Change theme</button>
                <hr/>
                <br/>
                <?php if($row['rank'] >= 2) {?>
                  <h5>Invite a friend</h5>
                  <hr/>
                  <div style="display: none;" id="generatedCode"></div>
                  <div class="form-group">
                    <button onclick="getCode()" type="button" class="btn btn-warning"><span class="fa fa-refresh"></span> Generate code</button>
                  </div>
                  <?php } ?>
                  <hr/>
                  <br/>
                  <h5>Download app</h5>
                  <hr/>
                  <a href="https://s3.amazonaws.com/gonativeio/static/58c58496727ade5e2efb21d7/app-release.apk"><img src="../css/android.png" width="100" height="100" alt="Android"/></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="../js/main.js"></script>
  </body>
</html>
