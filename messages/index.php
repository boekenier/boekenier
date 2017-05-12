<?php
session_start();
include_once('../config/siteFunctions/allowedCheck.php');
require_once('../config/db.php');
$sql = "SELECT message_pivot.*, Messages.*, users.*
        FROM message_pivot
          LEFT JOIN Messages
          ON message_pivot.message_id=Messages.msg_id
          LEFT JOIN users
          ON message_pivot.from_id=users.id
        WHERE message_pivot.to_id = '$_SESSION[user]'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boekenier - Messages</title>
    <?php
    include_once('../css/head.html');
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
                <div id="output"></div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                <?php if($result->num_rows > 0){ ?>
                  <ul class="list-group">
                    <?php while($row = $result->fetch_assoc()){?>
                      <div class="card">
                        <div class="card-header" role="tab" id="heading<?php echo $row['msg_id'];?>">
                          <h5 class="mb-0">
                            <button data-toggle="tooltip" title="Delete message" onclick="deleteMsg(<?php echo $row['msg_id'];?>,<?php echo $row['pivot_id'];?>)" class="btn btn-danger btn-sm"><span class="fa fa-times"></span></button>
                            <a data-toggle="collapse" data-parent="#accordion" href="#message<?php echo $row['msg_id'];?>" aria-expanded="true" aria-controls="message<?php echo $row['msg_id'];?>">
                              <?php echo $row['username'].":"?>
                              <?php echo "<div class='pull-right'>".$row['subject']."</div>";?>
                            </a>
                          </h5>
                        </div>
                        <div id="message<?php echo $row['msg_id'];?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $row['msg_id'];?>">
                         <div class="card-block">
                           <?php echo $row['message'];?>
                           <br/>
                           <a class="btn btn-primary" href="/users/?user=<?php echo $row['username'];?>&reply=1&title=<?php echo $row['subject'];?>">Reply</a>
                         </div>
                       </div>
                     </div>
                    <?php } ?>
                  </ul>
                  <?php } else { ?>
                    <center>
                      You don't have any messages
                    </center>
                  <?php } ?>
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
