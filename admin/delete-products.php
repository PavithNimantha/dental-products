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

if (isset($_GET['product_id'])) {
    // getting the information
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

    $query = "UPDATE products
              SET deleted = 'yes'
              WHERE product_id = $product_id;"; //update query for delete(deleted column change to 'yes')

    $result = mysqli_query($conn, $query);

        if ($result) {
            // deleted
            header('Location: ../admin/table_products.php');
        } else {
            header('Location: ../admin/table_products.php');
        }
    }
    
else {
    header('Location: ../admin/table_products.php');
    }



?>