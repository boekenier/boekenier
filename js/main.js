$(document).ready(function(){
  $('#commandbar').focus();
  bootUp()
});

var motdList = ["Enter help for the help page"];

var commandList = ["clear", "version", "ls"];
var firstboot = true;

function bootUp(){
  $('#screen').append('<b>jsOS 0.1</b>')
  motd()
}

function main(){
  if(firstboot){
      var dash = "-";
    for(var i=1; i <= 49; i++){
      dash += "-";
    }
    $('#screen').append(dash);
    firstboot = false;
  }
  $("#commandbar").keyup(function(event){
      if(event.keyCode == 13){
          getInput();
      }
  });
}

function motd(){
  if (motdList.length > 1) {
    var motdItem = motdList[Math.random(0, motdList.length)];
  } else {
    var motdItem = motdList[0];
  }
    if(firstboot){
      $('#screen').append("<br/>"+motdItem+"<br/>");
    } else {
      $('#screen').append("<br/>"+motdItem);
    }
    main();
}

function getInput(){
  var command = $('#commandbar').val();
  $('#screen').append("<br/>> "+ command);
  $('#commandbar').val("");
  checkCommand(command)
}

function checkCommand(cmd){
  if($.inArray(cmd, commandList) != -1) {
    executeCommand(cmd);
  } else if(cmd != ''){
    $('#screen').append("<br/> Command '"+cmd+"' not found");
  }
}

function executeCommand(command){
  switch (command) {
    case "clear":
        $('#screen').html("");
      break;
    case 'version':
      $('#screen').append('<br/><b>jsOS 0.1</b>');
      break;
    case 'ls':
      $.getJSON("http://localhost/test-projects/jsOS/config/files.json", function(data){
        var files = [];
        $.each(data.files, function(key, val){
            files.push(val);
        });
        for(i = 0; i < files.length; i++){
          if(files[i]["folder"] == 0){
            $('#screen').append("<br/>"+files[i]['filename']+"."+files[i]["type"]+"-----"+files[i]['size']+"B");
          } else {
            $('#screen').append("<br/>[D]"+files[i]['filename']+"-----"+files[i]['size']+"B");
          }
        }
      });
    break;
  }
}
