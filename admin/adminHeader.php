  <!-- partial:index.partial.html -->
  <aside class="sidebar position-fixed top-0 left-0 overflow-auto h-100 float-left" id="show-side-navigation1">
  <a class="btn btn-secondary m-2" href="../index.php">Home </a> <!-- home button -->
    <i class="uil-bars close-aside d-md-none d-lg-none" data-close="show-side-navigation1"></i>
    <div class="sidebar-header d-flex justify-content-center align-items-center px-3 py-4">
      
    <div class="ms-2">
      <h5 class="fs-6 mb-0">
        <img src="../images/admin_pro_pic/wijerathna.jpg" alt="admin Profile Image" style="width: 50px; height:50px; border-radius:50%" srcset="">
        <a class="text-decoration-none" href="#">Rashi International</a>
      </h5>
        <p class="mt-1 mb-0">Lorem ipsum dolor sit amet consectetur.</p>
      </div>
    </div>

    <ul class="categories list-unstyled">
      <li class="has-dropdown">
        <i class="uil-panel-add"></i><a href="#"> Tables</a>
        <ul class="sidebar-dropdown list-unstyled">
          <li><a onclick="window.location.href='table_import_request.php'" href="table_import_request.php">Import Requests</a></li>
          <li><a onclick="window.location.href='table_import_request_file.php'" href="table_import_request_file.php">Import Request Files</a></li>
          <li><a onclick="window.location.href='table_products.php'" href="table_products.php">Products</a></li>
          <li><a onclick="window.location.href='table_users.php'" href="table_users.php">Users</a></li>
        </ul>
      </li>
    </ul>
  </aside>

  <section id="wrapper">
    <nav class="navbar navbar-expand-md">
      <div class="container-fluid mx-2">
        <div class="navbar-header">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggle-navbar" aria-controls="toggle-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="uil-bars text-white"></i>
          </button>
          <a class="navbar-brand" href="admin.php">admin<span class="main-color">kit</span></a>
        </div>
        <div class="collapse navbar-collapse" id="toggle-navbar">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i data-show="show-side-navigation1" class="uil-bars show-side-btn"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>