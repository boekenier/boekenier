<!-- this file has not been used in the original boekenier -->
<?php
session_start();
if(!isset($_SESSION['user'])){
  echo "<script>window.location.href = '../403.html';</script>";
}
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
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-md-10 offset-1">
          <div class="card">
            <div class="text-center">
            <img src="../css/logo.png" width="180" height="180" class="card-img-top">
          </div>
            <div class="card-block">
              <div class="text-center"><h4 class="card-title">Contact</h4></div>
              <div id="error" class="alert alert-danger alert-dismissable" style="display: none;">
                <span style="cursor: pointer;" href="#" onclick="closeMsg('error')" class="close" aria-label="close">&times</span>
                <ul id='error-list'>
                </ul>
              </div>
              <div id="success" class="alert alert-success alert-dismissable" style="display: none;">
                <span style="cursor: pointer;" href="#" onclick="closeMsg('success')" class="close" aria-label="close">&times</span>
              </div>
              <div class="form-group">
                <label class="control-label">Firstname</label>
                <input id="fname" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label class="label-control">Lastname</label>
                <input id="lname" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label">Email</label>
                <input type="text" id="mail" class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label">Subject</label>
                <select class="form-control" id='category'>
                  <option value="">Choose a subject</option>
                  <option value="request">Request</option>
                  <option value="question">Question</option>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">Message</label>
                <textarea class="form-control" name="message" id="message" rows="10" placeholder="If you're requesting a book send the title, author and the isbn"></textarea>
              </div>
              <div class="form-group">
                <button onclick="send()" class="btn btn-success"><span class="fa fa-send"></span> Verstuur</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>

      function send(){
        var ok = true;
        $('#error-list').html('');
        var vnaam = $('#fname').val();
        var anaam = $('#lname').val();
        var email = $('#mail').val();
        var cat = $('#category').val();
        var msg = CKEDITOR.instances['message'].getData();

        if(vnaam == ""){
          $('#error-list').append('<li>Enter your firstname</li>');
          ok = false;
        }
        if(anaam == ""){
          $('#error-list').append('<li>Enter your lastname</li>');
          ok = false;
        }
        if(email == ""){
          $('#error-list').append('<li>Enter your email</li>');
          ok = false;
        }
        if(cat == ""){
          $('#error-list').append('<li>Choose a subject</li>');
          ok = false;
        }
        if(msg == ""){
          $('#error-list').append('<li>Message has to be filled in</li>');
          ok = false;
        }

        if(ok){
          $.ajax({
            type: 'POST',
            url: '/contact/contact.php',
            data: {
              naam: vnaam + ' ' + anaam,
              mail: email,
              category: cat,
              message: msg
            },
            success: function(data){
              if(data == "success"){
                $('#success').append('<p>Thank you for your '+cat+'</p>');
                $('#success').show(500);
                $('#fname').val('');
                $('#lname').val('');
                CKEDITOR.instances['message'].setData('');
                $('#category').val('');

                if($('#error').show()){
                  $('#error').hide();
                }
              } else {
                $('#error').html(data);
              }
            }
          });
        } else {
          $('#error').show(750);
        }
      }

      function closeMsg(id){
        $('#'+id).hide(750);
      }

      CKEDITOR.replace('message');
    </script>
  </body>
</html>
