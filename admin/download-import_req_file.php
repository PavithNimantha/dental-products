<?php 
	session_start();
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

        if(!empty($_GET['file_name'])){
            $filename = basename($_GET['file_name']);
            $filepath = '../uploads/import_docs/' . $filename;
            echo $filename.'<br>';
            echo $filepath.'<br>';

            if(!empty($filename) && file_exists($filepath)){
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Type: application/octet-stream");
                header("Content-Transfer-Encoding: Binary"); 
                header("Content-Disposition: attachment; filename=$filename"); 
                ob_clean();
                flush();
                readfile($filepath);
                exit;

            }
            else {
                header('location: ../admin/table_import_request_file.php?download=error');            
            }
        }

    ?>