<?php 
	session_start();
?>


<?php 
  include '../includes/database_config.php';
?>

<?php 
if (!isset($_SESSION['user_id'])) {   

  header('Location: ../login.php'); //check user logged in
}

else{
if($_SESSION['user_id'] != 1){

  header('Location: ../login.php'); //check admin logged in
}
}


  $query = "SELECT COUNT(product_id) AS active_products FROM products where deleted='no'"; //show products for count all active products
  $products_count = mysqli_query($conn, $query);

  if ($products_count) {
    
    $productsAssoc = mysqli_fetch_assoc($products_count);
    $allproducts = $productsAssoc['active_products'];
  
  }

  $query = "SELECT COUNT(user_id) AS active_users FROM users where deleted='no'"; //show users for count all active users
  $users_count = mysqli_query($conn, $query);

  if ($users_count) {
    
    $usersAssoc = mysqli_fetch_assoc($users_count);
    $allusers = $usersAssoc['active_users'];
  
  }

?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'><link rel="stylesheet" href="../css/admin.css">

</head>
<body>
  
<?php include 'adminHeader.php'; ?>

  <div class="p-4">
    <div class="welcome">
      <div class="content rounded-3 p-3">
        <h1 class="fs-3">Welcome to Dashboard</h1>
        <p class="mb-0">Hello Rashi, welcome to your awesome dashboard!</p>
      </div>
    </div>

    <section class="statistics mt-4">
      <div class="row">
        <div class="col-lg-4">
          <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
            <i class="uil-file fs-2 text-center bg-danger rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                <h3 class="mb-0"><?php echo $allproducts ?></h3> <span class="d-block ms-2">Products</span>
              </div>
              <p class="fs-normal mb-0">Active Products</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="box d-flex rounded-2 align-items-center p-3">
            <i class="uil-users-alt fs-2 text-center bg-success rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                <h3 class="mb-0"><?php echo $allusers ?></h3><span class="d-block ms-2">Users</span>
              </div>
              <p class="fs-normal mb-0">Registered Users</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="admins mt-4">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <!-- <h4>Admins:</h4> -->
            <div class="admin d-flex align-items-center rounded-2 p-3 mb-4">
              <div class="img">
              <img src="../images/admin_pro_pic/wijerathna.jpg" alt="admin Profile Image" style="width: 70px; height:70px; border-radius:50%">
              </div>
              <div class="ms-3">
                <h3 class="fs-5 mb-1">Rashi</h3>
                <p class="mb-0">Admin</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'></script>
<script src="../js/admin.js"></script>

</body>
</html>
