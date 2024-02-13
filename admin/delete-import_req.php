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


if (isset($_GET['request_id'])) {
    // getting the information
    $request_id = mysqli_real_escape_string($conn, $_GET['request_id']);

    $query = "UPDATE import_request
              SET deleted = 'yes'
              WHERE request_id = $request_id;"; //update query for delete(deleted column change to 'yes')

    $result = mysqli_query($conn, $query);

        if ($result) {
            // deleted
            header('Location: ../admin/table_import_request.php');
        } else {
            header('Location: ../admin/table_import_request.php');
        }
    }
    
else {
    header('Location: ../admin/table_import_request.php');
    }



?>