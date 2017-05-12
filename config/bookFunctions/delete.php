<?php
session_start();
require_once('../db.php');
$sql = "SELECT * FROM books WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
if($result->num_rows > 0){
  $row = $result->fetch_assoc();
  $filename = '/files/'.$row['filename'].'.bkcrypt';
  $sql = "DELETE FROM books WHERE id = '$_POST[id]'";
  if($conn->query($sql) === true){
    if(file_exists('../'.$filename)){
      unlink('../'.$filename);
    } else {
      echo "We couldn't find the file";
    }
  } else {
    echo "We couldn't delete the book";
  }
} else {
  echo "This is not the file you were looking for";
}
?>
