function deleteItem(id){
  // Send id to delete.php via ajax
  $.ajax({
    type: "POST",
    url: "../config/bookFunctions/delete.php",
    data: {id},
    // if success then reload page
    success: function(){
      location.reload();
    }
  });
}

function deleteUser(id){
  // Send id to deleteUser.php via ajax
  $.ajax({
    type: "POST",
    url: "../config/userFunctions/deleteUser.php",
    data: {id},
    success: function(data){
      // if success then reload page
      if(data == "success"){
        location.reload();
      } else {
        // else show error
        $('#output').html(data);
        $('#output').show('slow');
      }
    }
  });
}

function updateRank(id){
  // send id and id to updateRank.php via ajax
  var rank = $('#rank'+id+' option:selected').val();
  $.ajax({
    type: "POST",
    url: "../config/userFunctions/updateRank.php",
    data: {
      id: id,
      rank: rank
    },
    success: function(data){
      // if success then reload page
      if(data == "success"){
        location.reload();
      } else {
        // else show error
        $('#output').html('Failed: '+data);
        $('#output').show('slow');
      }
    }
  });
}

function closemsg(){
  $('#successmsg').hide(500);
}

// Open filebrowser
function openFile(){
  $('#userImage').click();
}
// If input has changed show uploadbar
$('input[type=file]').change(function(e){
  var filename = $(this).val().split("\\");
  $('#fileLocation').html(filename[2]);
  if($('#progress-bar').width() != '0%'){
    $("#progress-bar").width('0%');
    $("#progress-bar").html('');
  }
});


var codeGenerated = false;
var themeColor = "";
  // Get themeColor in hex
  function colorPick(){
    themeColor = $('#themeColor').val();
  }
  // if themeColor is empty set themeColor to white (#ffffff)
  function changeUser(type, id){
    if(themeColor == ""){
      themeColor = "#FFFFFF";
    }
    // if previewSrc is not empty submit form
    if(($("#previewSrc")[0].currentSrc) != ""){
      $("#input").submit();
    } else {
    // send variables to changeUser.php via ajax
    var currentPass = $('#oldpassword').val();
    var pass1 = $('#password').val();
    var pass2 = $('#password2').val();
    var username = $('#username').html();
      $.ajax({
        type: 'POST',
        url: '../config/userFunctions/changeUser.php',
        data: {
          oldPasswd: currentPass,
          pass: pass1,
          pass2: pass2,
          type: type,
          data: themeColor,
          id: id,
          username: username
        },
        // if success and type is theme then reload page
        success: function(data){
          if(data == 'success' && type == 'theme'){
            location.reload();
            // if success and type is password then empty input fields, and show message
          } else if(data == 'success' && type == 'password'){
            $('#oldpassword').val('');
            $('#password').val('');
            $('#password2').val('');
            $('#output').html('Password has been changed');
            $('#output').addClass('alert alert-success');
            $('#output').show('slow');
          } else {
            // else empty input fields and show error message
            $('#oldpassword').val('');
            $('#password').val('');
            $('#password2').val('');
            $('#output').html(data);
            $('#output').addClass('alert alert-danger');
            $('#output').show('slow');
          }
        }
      });
    }
  }
  // if background form is submitted
  $('#imageTheme').on('submit', (function(e){
    e.preventDefault();
    // Send form data to uploadBackground.php via ajax
    $.ajax({
      url: '../config/userFunctions/uploadBackground.php',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
        // if success then reload page
        if(data == "File has been uploaded"){
          location.reload();
        } else {
          // else show error message
          $('#output').html(data);
          $('#output').addClass('alert alert-danger');
          $('#output').show('slow');
        }
      },
      error: function(data){
        // if error show error message
        $('#output').html(data);
        $('#output').addClass('alert alert-danger');
        $('#output').show('slow');
      },
    });
  }));

  // if upload form is submitted
  $('#uploadForm').on('submit', (function(e){
    e.preventDefault();
    // Send form data to uploadProfilePic.php via ajax
    $.ajax({
      url: '../config/userFunctions/uploadProfilePic.php',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
          // if success then reload page
        if(data == "File has been uploaded"){
          location.reload();
        } else {
            // else show error message
          $('#fileOutput').html(data);
          $('#fileOutput').addClass('alert alert-danger');
          $('#fileOutput').show('slow');
        }
      },
      error: function(data){
          // if error show error message
        $('#fileOutput').html(data);
        $('#fileOutput').addClass('alert alert-danger');
        $('#fileOutput').show('slow');
      },
    });
  }));

  // if fileupload is changed submit form
  $('#fileupload').on('change', function(){
    $('#fileupload').submit();
  });

// if background image is loaded in, show as preview
var URL = window.URL || window.webkitURL;
var input = document.querySelector('#input');
var previewSrc = document.querySelector('#previewSrc');
input.addEventListener('change', function(){
  previewSrc.src = URL.createObjectURL(this.files[0]);
});

previewSrc.addEventListener('load', function(){
  console.log("line 157");
  URL.revokeObjectURL(this.src);
  if(this.height > 250){
    $("#previewSrc").attr('height','250px');
  }
  $("#preview").show('slow');
});


  // Random generate invite code and send via ajax
  function getCode(){
    if(!codeGenerated){
      var length = 80;
      var inviteCode = "";
      var characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
      for (var p = 0;  p < length; p++){
        inviteCode += characters.charAt(Math.floor(Math.random() * characters.length));
      }
      $('#generatedCode').html(inviteCode);
      $('#generatedCode').show('slow');
      $.ajax({
        type: 'POST',
        url: '../config/userFunctions/insertCode.php',
        data: {
          code: inviteCode
        }
      });
    } else {
      $('#generatedCode').append("<br/>Code is already generated");
    }
    codeGenerated = true;
  }

  function send(to, from){
    var subject = $('#subject').val(); // get subject
    var message = CKEDITOR.instances['message'].getData(); // get message
    if(subject != "" && subject != undefined && message != "" && message != undefined){ // check if subject and message is not empty
      // send to sendMessage via ajax
      $.ajax({
        url: '../config/messageFunctions/sendMessage.php',
        type: "POST",
        data: {
          to: to,
          from: from,
          subject: subject,
          message: message
        },
        // if success show message and reset input fields
        success: function(data){
          if(data == "Message send"){
            $('#output').html(data);
            $('#output').addClass('alert alert-success');
            $('#output').show('slow');
            $('#subject').val("");
            CKEDITOR.instances['message'].setData("");
          } else {
            // else show error message
            $('#output').html(data);
            $('#output').addClass('alert alert-danger');
            $('#output').show('slow');
          }
        },
        // if error show error message
        error: function(data){
          $('#output').html(data);
          $('#output').addClass('alert alert-danger');
          $('#output').show('slow');
        }
      });
    } else {
      // Show message if subject or message is empty
      $('#output').html("Subject and message has to be filled in");
      $('#output').addClass('alert alert-danger');
      $('#output').show('slow');
    }
  }

// Show login form
function showLogin(){
  $('#registerfield').hide('slow');
  $('#loginfield').show('slow');
  $('#output').hide('slow');

}

// Show register form
function showRegister(){
  $('#registerfield').show('slow');
  $('#loginfield').hide('slow');
}

function register(){
  var username = $('#username').val(); // get username
  var password = $('#password').val(); // get password
  var password2 = $('#password2').val(); // get password2
  var code = $('#inviteCode').val(); // get invite code

  // if password length is 8 or more continue
  if(password.length >= 8){
    //  check if passwords match
    if(password == password2){
      // send data to register.php via ajax
      $.ajax({
        type: "POST",
        url: 'config/siteFunctions/register.php',
        data: {
          username: username,
          password: password,
          code: code
        },
        // if success then show thank you message and reset fields
        success: function(data){
          if(data === "success"){
            $('#output').html('<div class="alert alert-success">Thank you for registering '+username+'</div>');
            $('#username').val('');
            $('#password').val('');
            $('#password2').val('');
            $('#inviteCode').val('');
          } else {
            // else show error message and reset password and invite fields
            $('#output').html('<div class="alert alert-danger">'+data+'</div>');
            $('#password').val('');
            $('#password2').val('');
            $('#inviteCode').val('');
          }
        }
      });
      // if passwords do not match show error message
    } else {
      $('#output').html('<div class="alert alert-danger">Passwords do not match</div>');
      $('#password').val('');
      $('#password2').val('');
    }
  } else {
    // if password length is not 8 or more show error message
    $('#output').html('<div class="alert alert-danger">Password has to be 8 characters or longer</div>');
    $('#password').val('');
    $('#password2').val('');
  }
}


function deleteMsg(msg_id, pivot_id){
  // send msg_id and pivot_id to deleteMsg via ajax
  $.ajax({
    url: '../config/messageFunctions/deleteMsg.php',
    type: 'POST',
    data: {
      msg_id: msg_id,
      pivot_id: pivot_id
    },
    success: function(data){
      // if success reload page
      if(data === "Message deleted"){
        location.reload();
      } else {
        // else show error
        $('#output').html(data);
        $('#output').addClass('alert alert-danger');
        $('#output').show('slow');
      }
    },
  });
}

// Show request form
function showRequestForm(){
  $('#requestForm').show(750);
  $('#formBtn').hide(750);
}

function requestDelete(id){
  // send id to deleteRequests via ajax
  $.ajax({
    type: 'POST',
    url: '../requests/deleteRequests.php',
    data: {
      id: id
    },
    success: function(data){
      // if success then reload page
      if(data == "success"){
        location.reload();
      } else {
        // else show error
        $('#error').show(750);
        $('#msg').val('Error: '+data);
      }
    }
  });
}

function request(){
  var title = $('#title').val(); // get request title
  if(title != ''){ // check if title is not empty
    // send title to addRequests via ajax
    $.ajax({
      type: 'POST',
      url: '../requests/addRequests.php',
      data: {
        title: title
      },
      success: function(data){
        // if success then reload page
        if(data == "success"){
          location.reload();
        } else {
          // else show error message
          $('#error').show(750);
          $('#msg').val('Error: '+data);
        }
      }
    });
  } else {
    // if title is empty show message
    $('#error').show(750);
    $('#msg').val('Please fill in the title');
  }
}

function changeState(id){
  var state = $("#done"+id).val(); // get state
  $.ajax({
    // send state and id to changeState via ajax
    url: "../requests/changeState.php",
    type: "POST",
    data: {
      id: id,
      state: state
    },
    success: function(data){
      // if success then reload page
      if(data == "success"){
        location.reload();
      } else {
        // else show error
        $('#error').show(750);
        $('#msg').val('Error: '+data);
      }
    }
  });
}

/* These functions are deprecated
 * if you want to use it
 * then you need to kill the bugs first

function addFriend(receivingId, requestId){
  // Send via ajax
  $.ajax({
    url: "../config/friendFunctions/addFriend.php",
    type: "POST",
    data: {
      receiveId: receivingId,
      sendId: requestId
    },
    success: function(data) {
      if(data === "success"){
        location.reload();
      } else {
        $("#output").addClass('alert alert-danger');
        $("#output").html(data);
        $("#output").show('slow');
      }
    }
  });
}


function cancelFriend(receivingId, requestId){
  $.ajax({
    url: "../config/friendFunctions/deleteFriend.php",
    type: "POST",
    data: {
      receiveId: receivingId,
      sendId: requestId
    },
    success: function(data) {
      if(data === "success"){
        location.reload();
      } else {
        $("#output").addClass('alert alert-danger');
        $("#output").html(data);
        $("#output").show('slow');
      }
    }
  });
}

function deleteFriend(receivingId, requestId){
  $.ajax({
    url: "../config/friendFunctions/deleteFriend.php",
    type: "POST",
    data: {
      receiveId: receivingId,
      sendId: requestId
    },
    success: function(data) {
      if(data === "success"){
        location.reload();
      } else {
        $("#output").addClass('alert alert-danger');
        $("#output").html(data);
        $("#output").show('slow');
      }
    }
  });
}
*/

function getUrlParameter(sParam){
  // Get url parameter
  var sPageUrl = decodeURIComponent(window.location.search.substring(1)),
      sURLVariables = sPageUrl.split('&'),
      sParametername,
      i;

  for(i = 0; i < sURLVariables.length; i++){
    sParametername = sURLVariables[i].split('=');

    if(sParametername[0] === sParam){
      return sParametername[1] === undefined ? true : sParametername[1];
    }
  }
};
