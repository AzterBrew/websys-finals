<nav class="navbar navbar-expand-lg shadow custom-nav">
    <div class="container-fluid ms-3">
      <a id="logo-ssite-1" href="../home.php">
        <img src="images/Keepy-White.png" alt="Keepy Logo" style="width:110px;height:auto;">
        </a>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <!-- SIDEBAR CALL -->
        <a class="btn btn-primary" href="#" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
          <b>Menu</b>
        </a>

        <ul class="navbar-nav me-auto">
          <li class="nav-item active" id="home-admin">
            <a class="nav-link" href="home.php"><b>Home</b> <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active" id="home-admin">
            <a class="nav-link" href="#"><b>Account</b> <span class="sr-only">(current)</span></a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li> -->
        </ul>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
        <ul class="navbar-nav ms-auto">
        <label for="">
          <?php 

          $query = "SELECT * FROM administrators WHERE admin_id = ?";
          $stmt = $con->prepare($query);
          $stmt->bind_param("i", $_SESSION['uid']
        );
          if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $item = $result->fetch_assoc();
                $user_fullname = $item['admin_firstname'] .' ' . $item['admin_surname'];
            }
          }
          echo $user_fullname;
          ?>

          </label>


          <li class="nav-item" id="admin-logout">
              <a class="nav-link active" href="back-end/back_logout.php"><i class="fa-solid fa-right-from-bracket fa-1x"></i> Sign Out</a>
          </li>
        </ul>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li> -->
          <!-- <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
          </li> -->

        <!-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
      </div>
    </div>
  </nav>
</div>