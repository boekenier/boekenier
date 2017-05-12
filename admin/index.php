<?php
session_start();
if(!isset($_SESSION['user'])){
  echo "<script>window.location.href = '../index.php';</script>";
}
if($_SESSION['user'] != 1){
  echo "<script>window.location.href = '../hidden/index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - controlpanel</title>
    <?php include_once '../css/head.html'; ?>
  </head>
  <?php include_once('../css/nav.php'); ?>
  <body>
    <div class="container">
      <?php if(isset($_SESSION['message'])){?>
        <div class="alert alert-info">
          <?php echo $_SESSION['message'];
          unset($_SESSION['message']);
          ?>
        </div>
        <?php } ?>
        <div class="card">
          <div class="card-block">
            <h4 class="card-title">Upload book</h4>
            <form method="post" action="../config/upload.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label">Choose file</label>
                <input type="file" name="file" class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label">Title</label>
                <input type="text" name="title" class="form-control">
              </div>
          <div class="form-group">
            <label class="control-label">Author</label>
            <input type="text" name="author" class="form-control">
          </div>
          <div class="form-group">
            <label class="control-label">Version</label>
            <input type="number" name="version" value='1' step='1' min="1" class="form-control">
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="submit"><span class="fa fa-upload"></span> Upload</button>
          </div>
        </form>
      </div>
    </div>
    <script>
      function back(){
        window.location.href = '../hidden';
      }
    </script>
  </body>
</html>
