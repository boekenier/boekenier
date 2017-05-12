<?php
session_start();
include_once('../config/allowedCheck.php');
require_once('../config/db.php');
// Get all requests
$sql = "SELECT * FROM requests ORDER BY request_date";
$result = $conn->query($sql);
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
        <div class="col-xs-6 col-md-10 offset-md-1">
          <div class="card">
            <div class="card-block">
              <div class="alert alert-danger alert-dismissable" id="error" style="display:none;">
                <span onclick='closemsg()' class="close" data-dismiss='alert' aria-label="close"><i class="fa fa-times"></i></span>
                <span id="msg"></span>
              </div>
              <?php if($result->num_rows > 0){?>
              <table class="table table-striped">
                <tr>
                  <th>Request</th>
                  <th>Requested at</th>
                  <?php if($_SESSION['rank'] == 4){ ?>
                    <th>Action</th>
                    <th>Done</th>
                  <?php } ?>
                </tr>
                <?php while($row = $result->fetch_assoc()){ ?>
                  <tr class='<?php echo $row['done'] == 1 ? "table-success" : "";?>'>
                    <td><?php echo $row['requestTitle'];?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($row['request_date']));?></td>
                    <?php if($_SESSION['rank'] == 4){?>
                      <td><button onclick="requestDelete(<?php echo $row['id'];?>)" class="btn btn-danger"><span class="fa fa-times"></span></button></td>
                      <td><select class="form-control" onchange="changeState(<?php echo $row['id'];?>)" id="done<?php echo $row['id'];?>">
                        <option <?php echo $row['done'] == 0 ? 'selected' : '';?> value="0">No</option>
                        <option <?php echo $row['done'] == 1 ? 'selected' : '';?> value="1">Yes</option>
                      </select></td>
                    <?php } ?>
                  </tr>
                  <?php }
                } else {?>
                  We didn't find any requests
                  <?php } ?>
              </table>
              <br/>
              <button onclick="showRequestForm()" id='formBtn' class='btn btn-primary'>Add Request</button>
              <div class="card" id="requestForm" style="display: none">
                <div class='card-block'>
                  <div class="form-group">
                    <input type="text" id="title" class="form-control" placeholder="The book's title">
                  </div>
                  <div class="form-group">
                    <button onclick="request()" class="btn btn-primary"><span class='fa fa-send'></span> Request</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="/js/main.js"></script>
  </body>
</html>
