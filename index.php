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
        <img src="/css/logo.png" width="240" height="240px"/>
        <h4 style="color: white;">Scientia sit Potentia</h4>
      </div>
      <?php if($_SESSION['error']) {?>
      <div class="alert alert-danger">
        <?php echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
      </div>
      <?php } ?>
      <div class="card">
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
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
