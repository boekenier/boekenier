function deleteItem(id){
  $.ajax({
    type: "POST",
    url: "../config/bookFunctions/delete.php",
    data: {id},
    success: function(){
      location.reload();
    }
  });
}

function deleteUser(id){
  $.ajax({
    type: "POST",
    url: "../config/userFunctions/deleteUser.php",
    data: {id},
    success: function(data){
      if(data == "success"){
        location.reload();
      } else {
        $('#output').html(data);
        $('#output').show('slow');
      }
    }
  });
}

function updateRank(id){
  var rank = $('#rank'+id+' option:selected').val();
  $.ajax({
    type: "POST",
    url: "../config/userFunctions/updateRank.php",
    data: {
      id: id,
      rank: rank
    },
    success: function(data){
      if(data == "success"){
        location.reload();
      } else {
        $('#output').html('Failed: '+data);
        $('#output').show('slow');
      }
    }
  });
}

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


var codeGenerated = false;
var themeColor = "";

  function colorPick(){
    themeColor = $('#themeColor').val();
  }

  function changeUser(type, id){
    if(themeColor == ""){
      themeColor = "#FFFFFF";
    }
    if(($("#previewSrc")[0].currentSrc) != ""){
      $("#input").submit();
    } else {
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
        success: function(data){
          if(data == 'success' && type == 'theme'){
            location.reload();
          } else if(data == 'success' && type == 'password'){
            $('#oldpassword').val('');
            $('#password').val('');
            $('#password2').val('');
            $('#output').html('Password has been changed');
            $('#output').addClass('alert alert-success');
            $('#output').show('slow');
          } else {
            console.log("Error: "+data);
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

  $('#imageTheme').on('submit', (function(e){
    e.preventDefault();
    $.ajax({
      url: '../config/userFunctions/uploadBackground.php',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
        if(data == "File has been uploaded"){
          location.reload();
        } else {
          console.log("Error: "+data);
        }
      },
      error: function(data){
        console.log("Error: "+data);
      },
    });
  }));

  $('#uploadForm').on('submit', (function(e){
    e.preventDefault();
    $.ajax({
      url: '../config/userFunctions/uploadProfilePic.php',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
        if(data == "File has been uploaded"){
          location.reload();
        } else {
          $('#fileOutput').html(data);
          $('#fileOutput').addClass('alert alert-danger');
          $('#fileOutput').show('slow');
        }
      },
      error: function(data){
        $('#fileOutput').html(data);
        $('#fileOutput').addClass('alert alert-danger');
        $('#fileOutput').show('slow');
      },
    });
  }));

  $('#fileupload').on('change', function(){
    $('#fileupload').submit();
  });
var URL = window.URL || window.webkitURL;
var input = document.querySelector('#input');
var previewSrc = document.querySelector('#previewSrc');
input.addEventListener('change', function(){
  console.log("line 152");
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
    var subject = $('#subject').val();
    var message = CKEDITOR.instances['message'].getData();
    if(subject != "" && subject != undefined && message != "" && message != undefined){
      $.ajax({
        url: '../config/messageFunctions/sendMessage.php',
        type: "POST",
        data: {
          to: to,
          from: from,
          subject: subject,
          message: message
        },
        success: function(data){
          if(data == "Message send"){
            $('#output').html(data);
            $('#output').addClass('alert alert-success');
            $('#output').show('slow');
            $('#subject').val("");
            CKEDITOR.instances['message'].setData("");
          } else {
            $('#output').html(data);
            $('#output').addClass('alert alert-danger');
            $('#output').show('slow');
            $('#subject').val("");
            $('#message').val("");
          }
        },
        error: function(data){
          $('#output').html(data);
          $('#output').addClass('alert alert-danger');
          $('#output').show('slow');
        }
      });
    } else {
      $('#output').html("Subject and message has to be filled in");
      $('#output').addClass('alert alert-danger');
      $('#output').show('slow');
    }
  }

function showLogin(){
  $('#registerfield').hide('slow');
  $('#loginfield').show('slow');
  $('#output').hide('slow');

}

function showRegister(){
  $('#registerfield').show('slow');
  $('#loginfield').hide('slow');
}

function register(){
  var username = $('#username').val();
  var password = $('#password').val();
  var password2 = $('#password2').val();
  var code = $('#inviteCode').val();

  if(password.length >= 8){
    if(password == password2){
      $.ajax({
        type: "POST",
        url: 'config/siteFunctions/register.php',
        data: {
          username: username,
          password: password,
          code: code
        },
        success: function(data){
          if(data === "success"){
            $('#output').html('<div class="alert alert-success">Thank you for registering '+username+'</div>');
            $('#username').val('');
            $('#password').val('');
            $('#password2').val('');
            $('#inviteCode').val('');
          } else {
            $('#output').html('<div class="alert alert-danger">'+data+'</div>');
            $('#password').val('');
            $('#password2').val('');
            $('#inviteCode').val('');
          }
        }
      });
    } else {
      $('#output').html('<div class="alert alert-danger">Passwords do not match</div>');
      $('#password').val('');
      $('#password2').val('');
    }
  } else {
    $('#output').html('<div class="alert alert-danger">Password has to be 8 characters or longer</div>');
    $('#password').val('');
    $('#password2').val('');
  }
}


function deleteMsg(msg_id, pivot_id){
  $.ajax({
    url: '../config/messageFunctions/deleteMsg.php',
    type: 'POST',
    data: {
      msg_id: msg_id,
      pivot_id: pivot_id
    },
    success: function(data){
      if(data === "Message deleted"){
        location.reload();
      } else {
        $('#output').html(data);
        $('#output').addClass('alert alert-danger');
        $('#output').show('slow');
      }
    },
  });
}

function showRequestForm(){
  $('#requestForm').show(750);
  $('#formBtn').hide(750);
}

function requestDelete(id){
  $.ajax({
    type: 'POST',
    url: '../requests/deleteRequests.php',
    data: {
      id: id
    },
    success: function(data){
      if(data == "success"){
        window.location = 'index.php';
      } else {
        $('#error').show(750);
        $('#msg').val('Error: '+date);
      }
    }
  });
}

function request(){
  var title = $('#title').val();
  if(title != ''){
    $.ajax({
      type: 'POST',
      url: '../requests/addRequests.php',
      data: {
        title: title
      },
      success: function(data){
        if(data == "success"){
          window.location = 'index.php';
        } else {
          $('#error').show(750);
          $('#msg').val('Error: '+data);
        }
      }
    });
  } else {
    $('#error').show(750);
    $('#msg').val('Please fill in the title');
  }
}

function changeState(id){
  var state = $("#done"+id).val();
  console.log(state);
  $.ajax({
    url: "../requests/changeState.php",
    type: "POST",
    data: {
      id: id,
      state: state
    },
    success: function(data){
      if(data == "success"){
        location.reload();
      } else {
        console.log("[ERROR] "+data);
      }
    }
  });
}

$("#changelog").on('click', function(e){
  e.preventDefault();
  console.log("Clicked");
  $("#changelog-modal").modal('toggle');
});


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

function getUrlParameter(sParam){
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
