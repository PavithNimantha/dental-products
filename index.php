<?php 
	session_start();
?>

<?php 
include "includes/database_config.php";
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

    $query="SELECT * FROM products WHERE deleted = 'no'";
    $products_query = mysqli_query($conn, $query);

    $products=""; //declare products variable

    if($products_query){ //assign variable to show products in webpage

        while ($productsAssoc = mysqli_fetch_assoc($products_query)) {

        
        $products.="<div class=\"col-12 col-md-6 col-xl-4\"><a href=\"import.php?product_id={$productsAssoc['product_id']}\"><img src=\"uploads/products/{$productsAssoc['product_image']}\" class=\"mx-auto d-block img-fluid\" alt=\"{$productsAssoc['product_name']}\" style=\"width: 250px; height:250px;\">
                    <p class=\"text-center\">{$productsAssoc['product_name']}</p></a>";
        $products.="</div>";
        

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR12csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD8512KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/footer.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- <link rel="shortcut icon" href="images/exlogo.ico" alt="test"> -->
    <title>Imports</title>
    
</head>
<body>
    <?php include "includes/headerHead.php"; ?>       
        <span class="d-inline-block d-lg-none"><a href="#" class="text-primary site-menu-toggle js-menu-toggle py-5"><span class="icon-menu h3 text-white"></span></a></span>
            <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li class="active"><a href="index.php" class="nav-link">Import</a></li>
                  <!-- <li><a href="#" class="nav-link">Export</a></li> -->
                  <li><a href="about_us.php" class="nav-link">About Us</a></li>
                  <li><a href="login.php" id="userLog" class="nav-link">Sign In</a></li>
                  <li><a id="admin" class="nav-link"></a></li>
                </ul>
            </nav>
    <?php include "includes/headerFoot.php"; ?>
    
    <div class="container">
        <div class="row mt-5">
            <?php echo $products; ?>
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