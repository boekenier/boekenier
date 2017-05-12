<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Boekenier</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/hidden/index.php">Home</a>
      </li>
      <?php if(isset($_SESSION['user']) && $_SESSION['user'] == 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="/admin/index.php">Admin</a>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a title="Temporary disabled, will be enabled soon" data-toggle="tooltip" data-placement="bottom" class="nav-link disabled" href="/contact/index.php">Contact/Request</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/config/logout.php">Logout</a>
      </li>
    </ul>
    <form method="get" action="/hidden/index.php" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
