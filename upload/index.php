<?php
session_start();
include_once('../config/allowedCheck.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - Upload</title>
    <?php include_once '../css/head.html'; ?>
    <script src="../js/jquery.form.js"></script>
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
            <p>Every file has to be zipped (not RAR, TAR or whatever. ZIP)</p>
            <form id="uploadForm" action="../config/upload.php" method="post">
              <div id='successmsg' class='alert alert-success alert-dismissable fade show' role='alert' style='display: none;'>
                <span onclick='closemsg();' class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </span>
                <div id="output"></div>
              </div>
              <div>
                <div class="progress">
                    <div id='progress-bar' class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; height: 20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-group">
                  <label class="control-label">Upload file</label>
                  <br/>
                  <button onclick="openFile();" type="button" class="btn btn-primary"><i class="fa fa-folder-open"></i> Browse</button>
                  <pre id="fileLocation"></pre>
                  <input hidden="true" name="file" id="userImage" type="file" class='form-control'/>
                </div>
                <div class="form-group">
                  <label class="control-label">Book Title</label>
                  <input id='title' type="text" name="title" class="form-control"/>
                </div>
                <div class="form-group">
                  <label class="control-label">Author</label>
                  <input id='author' type="text" name="author" class="form-control"/>
                </div>
                <div class="form-group">
                  <label class="control-label">Version</label>
                  <input id='version' type="number" name="version" class="form-control" min="0" step="0.5" value="1"/>
                </div>
              </div>
              <div><button type="submit" id='btnSubmit' class="btn btn-primary"/><i class="fa fa-upload"></i> Upload</button></div>
            </form>
          </div>
        </div>
      <script>
      $(document).ready(function() {
        $('#uploadForm').submit(function(e) {
        $('#progress-bar').width('0%');
        if($('#userImage').val()) {
          e.preventDefault();
            $(this).ajaxSubmit({
              target:   '#output',
              beforeSubmit: function() {
                $("#progress-bar").width('0%');
              },
              uploadProgress: function (event, position, total, percentComplete){
                $("#progress-bar").width(percentComplete + '%');
                $("#progress-bar").html(percentComplete+'%');
              },
              success: function(){
                $('#successmsg').show(500);
                $('#output').html('File has been uploaded');
                $('title').val('');
                $('author').val('');
                $('version').val('1');
              },
              resetForm: true
            });
            return false;
          }
        });
      });

      function closemsg(){
        $('#successmsg').hide(500);
      }

      function openFile(){
        $('#userImage').click();
      }
      $('input[type=file]').change(function(e){
        var filename = $(this).val().split("\\");
        $('#fileLocation').html(filename[2]);
        if($('#progress-bar').width() != '0%'){
          $("#progress-bar").width('0%');
          $("#progress-bar").html('');
        }
      });
      </script>
  </body>
</html>
