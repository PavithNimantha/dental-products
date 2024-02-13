<?php 
	session_start();
?>

<?php 
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['user_id'])) {
        
    ?>
            <script type = "text/javascript">
                function userlog(){
                    document.getElementById("userLog").innerHTML = "Sign Out";
                    document.getElementById("userLog").href = "includes/logout_process.php";
                    
                    // document.getElementById("userButton").href = "user.php";
            }
            </script>
    <?php
    if($_SESSION['user_id'] == 1){
        ?>
            <script type = "text/javascript"> //add admin page link if admin log captured
                function adminbutton(){
                    document.getElementById("admin").innerHTML = "Admin";
                    document.getElementById("admin").href = "admin/admin.php";
                    
            }
            </script>
    <?php
    }

        }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa+Ink&family=Ms+Madi&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>About Us</title>
</head>
<body style="background-color: #eb4d55;max-height: 10px;">
    <?php include "includes/headerHead.php"; ?>              
        <span class="d-inline-block d-lg-none"><a href="#" class="text-primary site-menu-toggle js-menu-toggle py-5"><span class="icon-menu h3 text-white"></span></a></span>
            <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li><a href="index.php" class="nav-link">Import</a></li>
                  <!-- <li><a href="#" class="nav-link">Export</a></li> -->
                  <li class="active"><a href="about_us.php" class="nav-link">About Us</a></li>
                  <li><a href="login.php" id="userLog" class="nav-link">Sign In</a></li>
                  <li><a id="admin" class="nav-link"></a></li>
                </ul>
            </nav>
    <?php include "includes/headerFoot.php"; ?>


    
    <div class="container mt-5">
    <div class="row">
        <p class="h5 mt-5 text-white col-md-6" style="line-height:35px; font-family: 'Aref Ruqaa Ink', serif;">Rashi International       Import Export Pvt Ltd is established in 2022 by a phamacist to import medical and dental equipment as well as to export srilankan spices and agri products to international markets.
        The dental chairs brand haiyue from china is a major  product of our import line and this brand has been in our market since 2007. We bid for government tenders and supply all kinds of hospital disposables equipment at very competitive prices. We are a service oriented organisation. After sales service will be provided 24/7 to customer satisfaction</p>
        <img src="images/admin_pro_pic/wijerathna.jpg" style="border-radius:50%;" height="500" width="500" alt="Photo of the owner" class="img-fluid col-md-6">
    </div>
    </div>

        <?php include "includes/footer.php"; ?>

<script> window.onload = userlog();</script>
<script> window.onload = adminbutton();</script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/main.js"></script>

</body>
</html>