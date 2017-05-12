<!-- this file has not been used in the original boekenier -->
<?php
$message = "
<html>
<head>
<meta charset='utf-8'>
</head>
<body>
<h2>".$_POST['category']."</h2>
<p>".$_POST['message']."</p>
<p>Email: ".$_POST['mail']."</p>
<p>Naam: ".$_POST['naam']."</p>
</body>
</html>
";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  if(mail('change@me.com', $_POST['category'], $message, $headers)){
    echo "success";
  } else {
    echo "Mail was not sent";
  }
?>
