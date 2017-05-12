<?php
session_start();
include_once('../config/allowedCheck.php');
require_once('../config/db.php');
$itemsPerPage = 30;
// get current page
if(isset($_GET['page'])){ $page = $_GET['page']; } else { $page = 1;}
$start_from = ($page-1)* $itemsPerPage;
// Get search
if(isset($_GET['search']) && !empty($_GET['search'])){
  // Search books and users by givin search request
  $sql = "SELECT * FROM books WHERE name LIKE '%$_GET[search]%'";
  $sql2 = "SELECT * FROM users WHERE username LIKE '%$_GET[search]%'";
} else {
  // Get all books, limited by 30
  $sql = "SELECT * FROM books ORDER BY created_at DESC LIMIT $start_from, $itemsPerPage";
}
$result = $conn->query($sql);
// set result2 if get is search
if(isset($_GET['search'])){
  $result2 = $conn->query($sql2);
}

// Format bytes to corresponding file size
function formatBytes($bytes, $precision = 2){
  $units = array('B','KB', 'MB', 'GB', 'TB');

  $bytes = max($bytes, 0);
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
  $pow = min($pow, count($units) - 1);
  $bytes /= pow(1024, $pow);
  return round($bytes, $precision).' '.$units[$pow];
}

// Calculate totalItems
$totalItems = $result->num_rows;
// Calculate the pages
$pages = ceil($totalItems/30);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier</title>
    <?php
    include_once '../css/head.html';
    ?>
    <style>
      #footer {
        position:absolute;
        bottom:0;
        width:100%;
        height:60px;
      }
      #donateBtn {
        margin-top: 35%;
        margin-left: 875%;
      }
    </style>
  </head>
  <?php
  include_once('../css/nav.php');
  ?>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-md-10 offset-md-1">
          <div class="card">
            <div class="card-block">
              <table class="table table-striped table-hover table-responsive">
                <tr>
                  <th>Name</th>
                  <th>Author</th>
                  <th>Size</th>
                  <th>Uploaded at</th>
                  <th>Version</th>

                  <?php if($_SESSION['rank'] == 4) { //if user is rank 4 show action ?>
                    <th>
                      Action
                    </th>
                    <?php } ?>
                </tr>
                <?php if($result->num_rows > 0 && strtolower($_GET['search']) != 'je moeder' && strtolower($_GET['search'] != 'space invaders')){ // if search is not 'je moeder' or 'space invaders' then show books and users?>
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
                    <?php if($_SESSION['rank'] == 4) { ?>
                      <td>
                        <button id="remove" onclick="deleteItem(<?php echo $row['id'];?>)" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete '<?php echo $row['name'];?>'">
                          <span class="fa fa-times"></span>
                        </button>
                      </td>
                      <?php } ?>
                    <?php
                  }
                } elseif(isset($_GET['search']) && strtolower($_GET['search']) == 'je moeder'){ // if search is 'je moeder' then show an image
                  echo "<div class='text-center'><img src='http://childhoodobesitynews.com/wp-content/uploads/2015/06/eat-block-of-cheese.jpg'/><br />'";
                  echo "<h3><b>HIERRR</b> ".$_GET['search']."</h3></div>";
                } elseif(isset($_GET['search']) && strtolower($_GET['search']) == 'space invaders'){ // if search is 'space invaders' then load space invaders
                  echo "<div class='text-center'><br/><iframe src='/config/spaceinvaders.html' width='640px' height='640px'/></div>";
                } else { ?>
                  <td colspan="6">
                  <?php echo "We didn't find any books"; ?>
                </td>
                </tr>
                 <?php } ?>
                </table>
                <?php if(isset($result2) && $result2->num_rows > 0){
                  echo "<hr/><h4>Users</h4><ul>";
                  while($row2 = $result2->fetch_assoc()){
                    echo "<li><a href='../users/?user=".$row2['username']."'>".$row2['username']."</a></li>";
                  }
                  echo "</ul>";
                }
                  ?>
            <div class="col-md-12 offset-md-5">
            <nav aria-label="pagination">
              <ul class="pagination">
                <li class="page-item <?php echo $page == 1 ? 'disabled' : '';?>">
                  <a href="?page=<?php echo $page - 1;?>" class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <?php
                if($pages < 1){ $pages = 1;}
                for($i = 1; $i <= $pages; $i++){
                ?>
                  <li class="page-item"><a class="page-link" href="?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php } ?>
                <li class="page-item <?php echo $page >= $pages ? 'disabled' : '';?>">
                  <a href="?page=<?php echo $page + 1;?>" class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
      <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
      </script>
      <script src="../js/main.js"></script>
  </body>
</html>
