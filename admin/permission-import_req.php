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
    if ($_GET['permission'] == "Not Approved") {
    $request_id = mysqli_real_escape_string($conn, $_GET['request_id']);

    $query = "UPDATE import_request
              SET permission = 'Approved'
              WHERE request_id = $request_id"; //update query for give permission(permission column change to 'Approved')

    $result = mysqli_query($conn, $query);

        if ($result) {
            // Approved
            header('Location: ../admin/table_import_request.php');
        } else {
            header('Location: ../admin/table_import_request.php');
        }
    }
    
    elseif(($_GET['permission'] == "Approved")) {
        $request_id = mysqli_real_escape_string($conn, $_GET['request_id']);

    $query = "UPDATE import_request
              SET permission = 'Not Approved'
              WHERE request_id = $request_id;"; //update query for remove permission(permission column change to 'Not Approved')

    $result = mysqli_query($conn, $query);

        if ($result) {
            // Not Approved
            header('Location: ../admin/table_import_request.php');
        } else {
            header('Location: ../admin/table_import_request.php');
        }
    }
    
else {
    header('Location: ../admin/table_import_request.php');
    }
}


?>