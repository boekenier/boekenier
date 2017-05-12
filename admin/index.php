<?php
session_start();
include_once('../config/allowedCheck.php');
require_once('../config/db.php');
$sql = "SELECT id, username, rank FROM users ORDER BY rank DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - Controlpanel</title>
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
            <div class="card-block">
              <div class="alert alert-danger" id="output" style="display: none;"></div>
              <?php if($result->num_rows > 0){ ?>
                total accounts: <?php echo $result->num_rows;?>
            <table class="table table-striped table-hover">
              <tr>
                <th>Username</th>
                <th>Action</th>
                <th>Rank</th>
              </tr>
                <?php while($row = $result->fetch_assoc()){ ?>
                  <tr>
                  <td>
                    <b><?php echo $row['username']?></b>
                  </td>
                  <td>
                    <select onchange="updateRank(<?php echo $row['id'];?>)" class="form-control" id="rank<?php echo $row['id'];?>">
                      <?php for($j = 1; $j <= 4; $j++){?>
                        <option <?php echo $row['rank'] == $j ? "selected" : "";?> value="<?php echo $j;?>">Set rank to: <?php echo $j;?></option>
                      <?php } ?>
                    </select>
                  <td>
                    <button id="remove" onclick="deleteUser(<?php echo $row['id'];?>)" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete '<?php echo $row['username'];?>'">
                      <span class="fa fa-times"></span>
                    </button>
                  </td>
                  <?php
                }
              } else { ?>
                <td colspan="6">
                <?php echo "We didn't find any users"; ?>
              </td>
              </tr>
               <?php } ?>
              </table>
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
