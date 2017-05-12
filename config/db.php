<?php
$host = "localhost";
$user = "root";
$passwd = "root";
$db = "boekenier";

$conn = new mysqli($host, $user, $passwd, $db);
if($conn->connect_error) {
  die("Couldn't connect <br/> Error: ".$conn->connect_error);
}
