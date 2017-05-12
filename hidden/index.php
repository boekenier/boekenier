<?php
session_start();
if(!isset($_SESSION['user'])){
  echo "<script>window.location.href = '../403.html';</script>";
}
require_once('../config/db.php');
if(isset($_GET['search']) && !empty($_GET['search'])){
  $sql = "SELECT * FROM books WHERE name LIKE '%$_GET[search]%'";
} else {
  $sql = "SELECT * FROM books ORDER BY created_at DESC";
}
$result = $conn->query($sql);
function formatBytes($bytes, $precision = 2){
  $units = array('B','KB', 'MB', 'GB', 'TB');

  $bytes = max($bytes, 0);
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
  $pow = min($pow, count($units) - 1);
  $bytes /= pow(1024, $pow);
  return round($bytes, $precision).' '.$units[$pow];
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
          <table class="table table-striped table-hover">
            <tr>
              <th>Name</th>
              <th>Author</th>
              <th>Size</th>
              <th>Uploaded at</th>
              <th>Version</th>
              <?php if($_SESSION['user'] == 1) { ?>
                <th>
                  Action
                </th>
                <?php } ?>
            </tr>
            <?php if($result->num_rows > 0 && strtolower($_GET['search']) != 'je moeder' && strtolower($_GET['search'] != 'space invaders')){ ?>
              <?php while($row = $result->fetch_assoc()){ ?>
                <tr>
                <td>
                  <a href="<?php echo '../files/'.$row['filename'].'.bkcrypt';?>"><?php echo $row['name'];?></a>
                </td>
                <td>
                  <?php echo $row['author']; ?>
                </td>
                <td>
                  <?php echo formatBytes(filesize('../files/'.$row['filename'].'.bkcrypt')); ?>
                </td>
                <td>
                  <?php echo date('d-m-Y H:i:s', strtotime($row['created_at']));?>
                </td>
                <td>
                  <?php echo $row['version'];?>
                </td>
                <?php if($_SESSION['user'] == 1) { ?>
                  <td>
                    <button id="remove" onclick="deleteItem(<?php echo $row['id'];?>)" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete '<?php echo $row['name'];?>'">
                      <span class="fa fa-times"></span>
                    </button>
                  </td>
                  <?php } ?>
                <?php
              }
            } elseif(strtolower($_GET['search']) == 'je moeder'){
              echo "<div class='text-center'><img src='http://childhoodobesitynews.com/wp-content/uploads/2015/06/eat-block-of-cheese.jpg'/><br />'";
              echo "<h3><b>HIERRR</b> ".$_GET['search']."</h3></div>";
            } elseif(strtolower($_GET['search']) == 'space invaders'){
              echo "<div class='text-center'><br/><iframe src='/config/spaceinvaders.html' width='640px' height='640px'/></div>";
            } else { ?>
              <td colspan="6">
              <?php echo "We didn't find any books"; ?>
            </td>
            </tr>
             <?php } ?>
            </table>
          </div>
        </div>
      </div>
      <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });

        function deleteItem(id){
          $.ajax({
            type: "POST",
            url: "../config/delete.php",
            data: {id},
            success: function(){
              location.reload();
            }
          });
        }

        function donate(){
          $('#donate').fadeToggle();
          $('#donateBtn').toggle();
        }
      </script>
  </body>
  <hr/>
  <footer>
    <div class="text-center">
      <div id="donate" style="display: none">
        <a href="bitcoin:1GWnGHPzVej7kFknEWGUvknQtMdcxeoW5V?amount=0.5&label=Donation%20Boekenier">
          <img src="../css/qrcode.jpg" width="100" height="100">
        </a>
          <p>1GWnGHPzVej7kFknEWGUvknQtMdcxeoW5V</p>
      </div>
      <div class="row">
        <div class="col-xs-1 offset-xs-1" style="margin-left: 47.3%;">
          <button id="donateBtn" class="btn btn-success btn-block btn-sm" onclick="donate()"><span class="fa fa-bitcoin"></span> Donate</button>
        </div>
      </div>
    </div>
  </footer>
</html>
