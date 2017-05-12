<?php
require_once('../config/db.php');
$cUser = "SELECT username, theme_color, profile_pic, background FROM users WHERE id = '$_SESSION[user]'";
$Userresult = $conn->query($cUser);
$userRow = $Userresult->fetch_assoc();

$getMsg = "SELECT * FROM message_pivot WHERE to_id = '$_SESSION[user]'";
$resultMsg = $conn->query($getMsg);
?>
<?php
if($userRow['theme_color'] == NULL && $userRow['background'] == NULL){
    echo "<style>body{background-color:#ffffff;}</style>";
} elseif($userRow['theme_color'] != NULL) {
    echo "<style>body{background-color:".$userRow['theme_color']."</style>";
} elseif($userRow['background'] != NULL){
    echo "<style>body{background:url(../user/img/profile_pics/".$userRow['background'].") no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;}</style>";
}
?>
<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Boekenier</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="../hidden/index.php">Home</a>
      </li>
      <?php if(isset($_SESSION['user']) && $_SESSION['rank'] == 4){ ?>
      <li class="nav-item">
        <a class="nav-link" href="../admin/index.php">Admin</a>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="../upload/index.php">Upload</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../requests/index.php">Requests</a>
      </li>
    </ul>
    <div class="dropdown" style="padding-right: 15px;">
      <img style="cursor: pointer;" src="../user/img/profile_pics/<?php echo $userRow['profile_pic'] == NULL ? 'default.png' : $userRow['profile_pic'];?>" width="48" height="48" class="img-circle dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"/>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#"><?php echo $userRow['username'];?></a>
        <div class="dropdown-divider"></div>
        <a href="../chat/" class="dropdown-item">IRC Chat</a>
        <!-- <a href="../friends/" class="dropdown-item disabled" disabled="true">Friends</a> -->
        <a href="../messages/" class="dropdown-item">Messages <?php if($resultMsg->num_rows > 0){?><span class="badge badge-pill badge-primary"><?php echo $resultMsg->num_rows;?></span><?php } ?></a>
        <a class="dropdown-item" href="../user/">Settings</a>
        <a class="dropdown-item" href="../config/siteFunctions/logout.php">Logout</a>
      </div>
    </div>
    <form method="get" action="/hidden/index.php" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
