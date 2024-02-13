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
//edit products
if(isset($_POST['submitEdits'])){

  $productId = mysqli_real_escape_string($conn, $_POST['productId']); //get edited product infomations from the form
  $productname = mysqli_real_escape_string($conn, $_POST['productname']); 
  $infosite = mysqli_real_escape_string($conn, $_POST['infosite']);
  $infopage = mysqli_real_escape_string($conn, $_POST['infopage']);
  
  $query = "UPDATE products SET product_name = '$productname', moreinfo_site_link = '$infosite', moreinfo_facebook_link = '$infopage' WHERE product_id = $productId"; //save updated product info to database without the image
  $result_set = mysqli_query($conn, $query);
  
  $query = "SELECT * FROM products WHERE product_id = $productId";
  $products = mysqli_query($conn, $query);
  
  if ($products) {

    $productsAssoc = mysqli_fetch_assoc($products);
  
    $file_name = $_FILES['productimage']['name']; //fetch product image file information
    $file_type = $_FILES['productimage']['type'];
    $file_size = $_FILES['productimage']['size'];
    $temp_name = $_FILES['productimage']['tmp_name'];
  
    if (!empty($file_name)){ //check input file is not empty

    $upload_to = '../uploads/products/';
  
    $destination = $productsAssoc['product_id'].'-'. $file_name;
  
    if($file_size > 7000000){ //file size check(should be less than 10MB)
        $errors[] = 'File size should be less than 10MB';
    }

    if(($file_type != 'image/jpeg') && ($file_type != 'image/png')){ //file size check(should be less than 10MB)
      $errors[] = 'File type should be an image';
    }
  
    if (empty($errors)) {
        move_uploaded_file($temp_name, $upload_to .$destination); //upload files
  
        $query = "UPDATE products SET product_image = '{$destination}' WHERE product_id = $productId"; //save upload file info to the database
        $result_set = mysqli_query($conn, $query);
  
        ?>
  
      <script>
        window.location.href = window.location.href;
      </script>
    
      <?php
    }
  }
  }
  
}


//add products
if(isset($_POST['submit'])){

$productname = mysqli_real_escape_string($conn, $_POST['productname']); //get product info from the form
$infosite = mysqli_real_escape_string($conn, $_POST['infosite']);
$infopage = mysqli_real_escape_string($conn, $_POST['infopage']);

$query = "INSERT INTO products (product_name,moreinfo_site_link,moreinfo_facebook_link,deleted) VALUES ('$productname','$infosite','$infopage','no')"; //save new product info to database without the image
$result_set = mysqli_query($conn, $query);

$query = "SELECT * FROM products WHERE product_id = (SELECT max(product_id) FROM products)";
$products = mysqli_query($conn, $query);

if ($products) {
  $productsAssoc = mysqli_fetch_assoc($products);

  $file_name = $_FILES['productimage']['name']; //fetch product image file information
  $file_type = $_FILES['productimage']['type'];
  $file_size = $_FILES['productimage']['size'];
  $temp_name = $_FILES['productimage']['tmp_name'];

  $upload_to = '../uploads/products/';

  $destination = $productsAssoc['product_id'].'-'. $file_name;

  if($file_size > 10000000){ //file size check(should be less than 10MB)
      $errors[] = 'File size should be less than 10MB';

  }

  if(($file_type != 'image/jpeg') && ($file_type != 'image/png')){ //file size check(should be less than 10MB)
    $errors[] = 'File type should be an image';
  }

  if (empty($errors)) {
      move_uploaded_file($temp_name, $upload_to .$destination); //upload files

      $query = "UPDATE products SET product_image = '{$destination}' WHERE product_id = (SELECT max(product_id) FROM products)"; //save upload file info to the database
      $result_set = mysqli_query($conn, $query);

      ?>

    <script>
      window.location.href = window.location.href;
    </script>
  
    <?php
  }
}

}
$query = "SELECT * FROM products WHERE deleted = 'no' ORDER BY product_id DESC"; //show all product informations on admin
$products = mysqli_query($conn, $query);

$table = '';
$editModal='';

if ($products) {
    while ($productsAssoc = mysqli_fetch_assoc($products)) {

      //edit products
      $product_id=$productsAssoc['product_id'];
      $product_name=$productsAssoc['product_name']; 
      $product_image=$productsAssoc['product_image'];
      $moreinfo_site_link=$productsAssoc['moreinfo_site_link'];
      $moreinfo_facebook_link=$productsAssoc['moreinfo_facebook_link'];

        $table .= "<tr>";
        $table .= "<th scope=\"row\">{$product_id}</th>";
        $table .= "<td>{$product_name}</td>";
        $table .= "<td>{$product_image}</td>";
        $table .= "<td>{$moreinfo_site_link}</td>";
        $table .= "<td>{$moreinfo_facebook_link}</td>";
        $table .= "<td><a class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#editProducts{$product_id}\">Edit</a></td>";
        $table .= "<td><a class=\"btn btn-danger\" href=\"delete-products.php?product_id={$product_id}\" onclick=\"return confirm('Do you want to delete product id {$product_id}?');\">Delete</a></td>";
        $table .= "</tr>";


        // edit products modal
        // The Modal
        $editModal.="<div class=\"modal fade\" id=\"editProducts{$product_id}\">";
        $editModal.="  <div class=\"modal-dialog\">";
        $editModal.="    <div class=\"modal-content\">";

        $editModal.="      <!-- Modal Header -->";
        $editModal.="      <div class=\"modal-header\">";
        $editModal.="        <h4 class=\"modal-title\">Add Products</h4>";
        $editModal.="        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>";
        $editModal.="      </div>";

        $editModal.="      <!-- Modal body -->";
        $editModal.="      <form action=\"table_products.php\" method=\"post\" enctype=\"multipart/form-data\">";

        $editModal.="      <div class=\"modal-body\">";
        $editModal.="          <div>	";
        $editModal.="            <label class=\"form-label\" for=\"productname\">Product Name</label>";
        $editModal.="				    <input class=\"form-control\" type=\"text\" name=\"productname\" id=\"productname\" value=\"$product_name\">";
        $editModal.="			    </div>";

        $editModal.="          <div class=\"mt-4\">";
        $editModal.="            <label class=\"form-label\" for=\"infosite\">Information Webpage URL <span class=\"text-danger\">(ex: http://www.dentalchair-video.com)</span></label>	";		
        $editModal.="				    <input class=\"form-control\" type=\"text\" name=\"infosite\" id=\"infosite\" value=\"$moreinfo_site_link\">";
        $editModal.="			    </div>";    
        
        $editModal.="          <div class=\"mt-4\">";
        $editModal.="            <label class=\"form-label\" for=\"infopage\">Information Facebook Page URL <span class=\"text-danger\">(ex: http://www.facebook.com)</span></label>	";		
        $editModal.="				    <input class=\"form-control\" type=\"text\" name=\"infopage\" id=\"infopage\" value=\"$moreinfo_facebook_link\">";
        $editModal.="			    </div>";
        
        $editModal.="          <div class=\"mt-4\">";
        $editModal.="            <label class=\"form-label\" for=\"productimage\">Product Image</label>	";		
        $editModal.="				    <input class=\"form-control\" type=\"file\" name=\"productimage\" id=\"productimage\">";
        $editModal.="			    </div>";
        $editModal.="      </div>";

        $editModal.="           <input type=\"hidden\" name=\"productId\" value=\"$product_id\">";

        $editModal.="      <!-- Modal footer -->";
        $editModal.="      <div class=\"modal-footer\">";
        $editModal.="        <button type=\"submit\" name=\"submitEdits\" class=\"btn btn-success\">Submit</button>";
        $editModal.="        <button type=\"button\" class=\"btn btn-danger\" data-bs-dismiss=\"modal\">Close</button>";
        $editModal.="      </div>";
        
        $editModal.="      </form>";
        $editModal.="      </div>";
        $editModal.="  </div>";
        $editModal.="</div>";

    }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>
  <link rel="stylesheet" href="../css/admin.css">

</head>

<body>
<?php include 'adminHeader.php'; ?>

<div class="container row col-5 col-lg-3 m-3"> <!-- modal button -->
      <button type="button" data-bs-toggle="modal" data-bs-target="#addProducts" class="btn btn-info">Add Products +</button>
</div>

<!-- add new products modal -->
<!-- The Modal -->
<div class="modal fade" id="addProducts">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Products</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <form action="table_products.php" method="post" enctype="multipart/form-data">
        
      <div class="modal-body">
          <div>	
            <label class="form-label" for="productname">Product Name</label>		
				    <input class="form-control" type="text" name="productname" id="productname" required>
			    </div>

          <div class="mt-4">
            <label class="form-label" for="infosite">Information Webpage URL <span class="text-danger">(ex: http://www.dentalchair-video.com)</span></label>			
				    <input class="form-control" type="text" name="infosite" id="infosite" required>
			    </div>

          <div class="mt-4">
            <label class="form-label" for="infopage">Information Facebook Page URL <span class="text-danger">(ex: http://www.facebook.com)</span></label>			
				    <input class="form-control" type="text" name="infopage" id="infopage" required>
			    </div>

          <div class="mt-4">
            <label class="form-label" for="productimage">Product Image</label>			
				    <input class="form-control" type="file" name="productimage" id="productimage" required>
			    </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

      </form>
    </div>
  </div>
</div>

<?php 

if(!empty($errors)){ //display file size restriction (10MB)
 echo '<p class="text-danger h5">-File Not Updated';
 echo '<div class="text-warning">';
    foreach($errors as $error){
      echo '- ' . $error .'</br>';
    }
    echo '</div>';
} 

?>

    <div class="container-fluid pt-4 px-4"> <!--table start -->

      <div class="row">
        <div class="col-12">
          <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Products</h6>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Image Id</th>
                    <th scope="col">More Info Website</th>
                    <th scope="col">More Info Facebook</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                    <?php echo $table; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div> <!--table end -->
<?php echo $editModal ?>

  </section>
  <!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js'></script>
  <script src="../js/admin.js"></script>

</body>

</html>