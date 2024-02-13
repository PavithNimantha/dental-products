<?php 
	session_start();
?>

<?php 
    include '../includes/database_config.php';
?>

<?php
if (!isset($_SESSION['user_id'])) { //check user logged in
    header('Location: ../login.php');
}
else{
    if($_SESSION['user_id'] != 1){

        header('Location: login.php'); 
    }
}

if (isset($_GET['user_id'])) {
    // getting the user information
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    if ( $user_id == $_SESSION['user_id'] ) {
        // should not delete admin
        header('Location: ../admin/table_users.php?error=cannot_delete_admin'); 
    } else {
        // deleting the user
        $query = "UPDATE users
                  SET deleted = 'yes'
                  WHERE user_id = $user_id;";
                  $result = mysqli_query($conn, $query);

        if ($result) {
            // user deleted
            header('Location: ../admin/table_users.php?user_deleted=true');
        } else {
            header('Location: ../admin/table_users.php?user_deleted=false');
        }
    }
    
} else {
    header('Location: ../admin/table_users.php');
    }



?>