<?php 
	session_start();
?>


<?php 

include 'includes/database_config.php';

$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['user_id'])) { //check user logged in
     
  header('Location: login.php');
   
}

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

if (isset($_GET['message'])){

  if($_GET['message'] == 'sent'){
    ?>
        <script>
          alert("Message Sent Succefull")
        </script>
    <?php
  }elseif($_GET['message'] == 'not_sent'){
    ?>
        <script>
          alert("Message Send failed")
        </script>
    <?php
}
  }

  $sizeerror ='';
  if (isset($_GET['sizeerror'])){

    //display file size restriction (10MB)
    $sizeerror .= '<p class="text-warning">-File size should be less than 10MB</p>';
  }


if (isset($_GET['product_id'])){

$query = "SELECT * FROM products WHERE product_id = '{$_GET['product_id']}'"; //show product informations for fetch more info URL
$products = mysqli_query($conn, $query);

if ($products) {
    $productsAssoc = mysqli_fetch_assoc($products);

    $productId = $productsAssoc['product_id'];
    $moreInfoSiteLink = $productsAssoc['moreinfo_site_link'];
    $moreInfoFacebookLink = $productsAssoc['moreinfo_facebook_link'];
    
}
}
//file upload
if(isset($_POST['fileSubmit'])){

  $productIdFile = mysqli_real_escape_string($conn, $_POST['productIdFile']);

  $file_name = $_FILES['document']['name']; //fetch upload file information
  $file_type = $_FILES['document']['type'];
  $file_size = $_FILES['document']['size'];
  $temp_name = $_FILES['document']['tmp_name'];

  $upload_to = 'uploads/import_docs/';

  $destination = '011-'. $file_name;

  if($file_size > 10000000){ //file size check(should be less than 10MB)

      header("Location: import.php?sizeerror&product_id=$productIdFile");
  }

  if (empty($errors)) {
      move_uploaded_file($temp_name, $upload_to .$destination); //upload files

      $query = "INSERT INTO import_request_file (user_id,product_id,file_name,deleted) VALUES ('{$_SESSION['user_id']}','$productIdFile','$destination','no')"; //save upload file info to database
      $result_set = mysqli_query($conn, $query);
      ?>
        <script>
            window.location.href = "import.php?product_id=<?php echo $productIdFile ?>";
        </script>

      <?php
  }
}

  //request upload
  if(isset($_POST['submit'])){
    $confRequest = mysqli_real_escape_string($conn, $_POST['confRequest']);
    $productIdForm = mysqli_real_escape_string($conn, $_POST['productIdForm']);

    $query ="INSERT INTO import_request (user_id,product_id,request_details,permission,deleted)
             VALUES('{$_SESSION['user_id']}','$productIdForm','$confRequest','Not Approved','no')"; //request permission to submit details
    $result_set = mysqli_query($conn, $query);

    ?>
    
    <script>
      window.location.href = "import.php?product_id=<?php echo $productIdForm ?>";
    </script>

    <?php
  }

  $query="SELECT * FROM import_request WHERE user_id={$_SESSION['user_id']} AND product_id = $productId;"; //fetch request data from users for check approval
  $result_set = mysqli_query($conn, $query);

  $approve = ''; //variable declaration

  if ($result_set){
    if(mysqli_num_rows($result_set)){

      $import_request=mysqli_fetch_assoc($result_set);
    
      if($import_request['permission']=='Approved'){ //if user permission is approved, give permission to submit files

        $approve.= "<div class=\"row\">";
        $approve.="<form action=\"import.php\" method=\"post\" enctype=\"multipart/form-data\">";
        $approve.="<lable class=\"form-label text-success\" for=\"document\">Your request is approved. Now you are eligible to send your documents.</label>";
        $approve.="<input class=\"form-control mt-3\" type=\"file\" name=\"document\">";
        $approve.="<input type=\"hidden\" name=\"productIdFile\" value=\"{$productId}\">";
        $approve.="<p class=\"text-danger\">Note: If you want send more than one files. Please compress those files before submit (ex: .rar, .zip)</p>";
        $approve.="<button class=\"btn btn-success mb-3 mt-3\" type\"submit\" name=\"fileSubmit\">Submit</button>";
        $approve.="</form>";
        $approve.="</div>";
        ?>
    
        <script>
          function hideRequestInput(){ //hide request permission text area
            $("#requestAccess").hide();
          };
        </script>
    
        <?php
      }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/footer.css">

    <link rel="shortcut icon" href="img/imlogo.ico" alt="test">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <title>Import</title>
    
</head>
<body>

<?php include 'includes/headerHead.php'; ?>              
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
    <?php include 'includes/headerFoot.php'; ?>
<div class="container">

<div class="row mt-5">
  <p class="text-info h4">For More Info</p>

</div>

<div class="row">
    <a class="col-5 btn btn-outline-danger" href="<?php echo $moreInfoSiteLink; ?>">Visit</a>
    <p class="col-2"></p>
    <a class="col-5 btn btn-outline-primary  fa fa-facebook" href="<?php echo $moreInfoFacebookLink; ?>"></a>
</div>

<div class="row mt-5">
<form id="requestAccess" action="import.php" method="post"> <!-- text area for request approval -->
    <label class="form-label text-success h2" for="confRequest">Request Access</label>
    <textarea class="form-control" name="confRequest" cols="70" rows="7" required></textarea>
    <input type="hidden" name="productIdForm" value="<?php echo $productId; ?>">
    <button class="btn btn-primary mb-3 mt-3" name="submit" type="submit">Submit</button>
</form>
</div>

<?php 

echo $sizeerror;

?>

<?php 
  echo $approve; //if approved user, show the file input
?>

<div class="row mt-5">

<p class="text-info h1">Contact Us</p>
<form action="contact_us.php" method="post"> <!-- contact us form -->

			<div class="form-floating">		
				<input class="form-control" type="text" name="fullname" id="fullname" placeholder="Full Name" required>
        <label class="form-label" for="fullname">Full Name</label>
			</div>

			<div class="form-floating mb-3 mt-3">			
				<input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
        <label class="form-label" for="email">Email</label>
			</div>

			<div class="form-floating mb-3 mt-3">				
				<input class="form-control" type="text" name="subject" id="subject" placeholder="Subject" required>
        <label class="form-label" for="subject">Subject</label>
			</div>

			<div class="mb-3 mt-3">
				<textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Message" required></textarea>
			</div>

      <input type="hidden" name="productIdEmail" value="<?php echo $productId; ?>">

      <input type="hidden" name="userId" value="<?php echo $_SESSION['user_id']; ?>">

			<div>
				<button class="btn btn-primary" type="submit" name="submit">Send Message</button>
			</div>
</div>
		</form>

</div>

<?php include "includes/footer.php"; ?>

<script>hideRequestInput();</script>

<script> window.onload = userlog();</script>
<script> window.onload = adminbutton();</script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/main.js"></script>
</body>
</html>
