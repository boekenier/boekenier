<?php
session_start();
if(isset($_SESSION['user'])){
  echo "<script>window.location.href = 'hidden/index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Boekenier</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include 'css/head.html'; ?>
  </head>
  <body>
    <div class="container" style="margin-top: 120px;">
      <div class="text-center">
        <img src="css/logo.png" width="240" height="240px"/>
        <h4 style="color: white;">Scientia sit Potentia</h4>
        <p style="color: white;" id="changelog" title="Click for changelog" data-toggle="tooltip">Version 2.5</p>
      </div>
      <?php if(isset($_SESSION['error'])) {?>
      <div class="alert alert-danger">
        <?php echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
      </div>
      <?php } ?>
      <div id="output">
      </div>
      <div id="loginfield" class="card">
        <div class="card-block">
          <form method="post" action="config/login.php">
            <div class="form-group">
              <label class="label-control">Username</label>
              <input autofocus name='username' type="text" class="form-control" placeholder="Enter username" value="<?php echo isset($_SESSION['error']) ? $_SESSION['username'] : '';?>">
              <?php unset($_SESSION['username']); ?>
            </div>
            <div class="form-group">
              <label class="label-control">Password</label>
              <input name='password' type="password" class="form-control" placeholder="Enter password" value="">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success"><span class="fa fa-sign-in"></span> Login</button>
              <button type="button" onclick="showRegister()" class="btn btn-primary"><span class="fa fa-pencil"></span> Register</span>
            </div>
          </form>
        </div>
      </div>
      <div id="registerfield" style="display: none;" class="card">
        <div class="card-block">
          <div>
            <div class="form-group">
              <label class="control-label">Username</label>
              <input class='form-control' type="text" name="username" id="username"/>
            </div>
            <div class="form-group">
              <label class="control-label">Password <span title="password must be atleast 8 characters long" data-toggle="tooltip" data-placement="right" class="fa fa-question-circle"></span></label>
              <input class='form-control' type="password" name="password" id="password"/>
            </div>
            <div class="form-group">
              <label class="control-label">Repeat password</label>
              <input class='form-control' type="password" name="password2" id="password2">
            </div>
            <div class="form-group">
              <label class="control-label">Invitation code</label>
              <input class='form-control' type="text" name="inviteCode" id="inviteCode">
            </div>
            <div class="form-group">
              <button type="button" onclick="register()" class="btn btn-success"><span class="fa fa-pencil"></span> Register</button>
              <button type="button" onclick="showLogin()" class="btn btn-primary"><span class="fa fa-sign-in"></span> Login</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="changelog-modal" tabindex="-1" role="diaog" aria-labelledby="ChangeLog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ChangeLog">Changelog</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h5>Future of Boekenier</h5>
              <p>
		Starting today (12-05-2017) , there won't be any updates containing new features,
              	the updates will only contain bug fixes and security patches.
		I've not decided yet that the site will be ported to a new language,
		if so then it will be Django/Python.
	     </p>
		<p>
		This decision has been made because I see no future in Boekenier,
		at this point I have no intension to shutdown the site, but if I do,
		then the source code will be available on Github
		</p>
	    <h5>Version 2.5</h5>
              <ul>
                <li>Added reply button to messages</li>
                <li>Fixed some errors that made the site difficult to use when you were on mobile devices</li>
              </ul>
              <h5>Version 2.4.1</h5>
              <ul>
                <li>Brought back requests page</li>
              </ul>
              <h5>Version 2.4</h5>
              <ul>
                <li>Smashed some bugs</li>
                <li>Added IRC using Freenode (check your profile menu)</li>
              </ul>
              <h5>Version 2.3</h5>
              <ul>
                <li>Smashed some bugs</li>
              </ul>
              <h5>Version 2.2</h5>
              <ul>
                <li>Smashed some bugs</li>
              </ul>
              <h5>Version 2.1</h5>
              <ul>
                <li>Smashed some bugs</li>
              </ul>
              <h5>Version 2.0</h5>
              <ul>
                <li>Added user accounts (you can only register when you have an invite)</li>
                <li>Added the possibility to add profile pics</li>
                <li>Added the possibility to change theme</li>
                <li>Added the possibility to upload books</li>
                <li>Added the possibility to change your password (be careful, you can't get password back if you forgot it)</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
	console.log("TEST");
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
    <script src="js/main.js"></script>
    <script>
        $("#changelog").on('click', function(e){
  	    e.preventDefault();
  	    console.log("Clicked");
  	    $("#changelog-modal").modal('toggle');
	});
    </script>
  </body>
</html>
