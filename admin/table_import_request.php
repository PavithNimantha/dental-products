<?php 
	session_start();
?>


<?php 

include '../includes/database_config.php';

if (!isset($_SESSION['user_id'])) {   

  header('Location: ../login.php'); //check user logged in
}

else{
if($_SESSION['user_id'] != 1){

  header('Location: ../login.php'); //check admin logged in
}
}

$query = "SELECT * FROM import_request WHERE deleted = 'no' ORDER BY request_id DESC";
$exReq = mysqli_query($conn, $query);

$table = '';

if ($exReq) {
    while ($exReqAssoc = mysqli_fetch_assoc($exReq)) {

        $table .= "<tr>";
        $table .= "<th scope=\"row\">{$exReqAssoc['request_id']}</th>";
        $table .= "<td>{$exReqAssoc['user_id']}</td>";
        $table .= "<td>{$exReqAssoc['product_id']}</td>";
        $table .= "<td>{$exReqAssoc['request_details']}</td>";
        $table .= "<td><a id=\"permission\"class=\"btn btn-success\" href=\"permission-import_req.php?request_id={$exReqAssoc['request_id']}&permission={$exReqAssoc['permission']}\">{$exReqAssoc['permission']}</a></td>";
        $table .= "<td><a class=\"btn btn-danger\" href=\"delete-import_req.php?request_id={$exReqAssoc['request_id']}\" onclick=\"return confirm('Do you want to delete request {$exReqAssoc['request_id']}?');\">Delete</a></td>";
        $table .= "</tr>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Import Requests</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
<?php include 'adminHeader.php'; ?>

    <div class="container-fluid pt-4 px-4"> <!--table start -->

      <div class="row">
        <div class="col-12">
          <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Import Requests</h6>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Request Details</th>
                    <th scope="col">Permission</th>
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


  </section>
  <!-- partial -->

  <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'></script>
  <script src="../js/admin.js"></script>

</body>

</html>