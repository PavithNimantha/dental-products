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

$table = ''; //declare user table variable
$uid = ''; //declare serarch user table variable

if ( isset($_GET['uid'])) { //input data from search user id

  $uid = mysqli_real_escape_string($conn, $_GET['uid']);
  
  if(empty($uid)){
      header('Location: table_users.php'); //if empty enter redirect to table_user page
  }else{
        $query = "SELECT * FROM users WHERE user_id LIKE '{$uid}' AND deleted = 'no' ORDER BY user_id DESC"; //search user id tuple from database
        $users = mysqli_query($conn, $query);

        if ($users) {
        while ($user = mysqli_fetch_assoc($users)) { //show search tuple on webpage
        
        $table .= "<tr>";
        $table .= "<th scope=\"row\">{$user['user_id']}</th>";
        $table .= "<td>{$user['first_name']}</td>";
        $table .= "<td>{$user['last_name']}</td>";
        $table .= "<td>{$user['email']}</td>";
        $table .= "<td><a class=\"btn btn-danger\" href=\"delete-user.php?user_id={$user['user_id']}\" onclick=\"return confirm('Do you want to delete user {$user['user_id']}?');\">Delete</a></td>";
        $table .= "</tr>";
        }
      }
    } 
  }else{

          $query = "SELECT * FROM users WHERE deleted = 'no' ORDER BY user_id DESC"; //if visit the pure page without seaching(all active users)
          $users = mysqli_query($conn, $query);

          if ($users) {
              while ($usersAssoc = mysqli_fetch_assoc($users)) {
              
                  $table .= "<tr>";
                  $table .= "<th scope=\"row\">{$usersAssoc['user_id']}</th>";
                  $table .= "<td>{$usersAssoc['first_name']}</td>";
                  $table .= "<td>{$usersAssoc['last_name']}</td>";
                  $table .= "<td>{$usersAssoc['email']}</td>";
                  $table .= "<td><a class=\"btn btn-danger\" href=\"delete-user.php?user_id={$usersAssoc['user_id']}\" onclick=\"return confirm('Do you want to delete user {$usersAssoc['user_id']}?');\">Delete</a></td>";
                  $table .= "</tr>";
              
                 }
            }
        }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
<?php include 'adminHeader.php'; ?>

      <form action="table_users.php" method="GET">
				<p>
					<input id="search" class="form-control m-3 w-50 text-info" style="background-color:#2a2b3d;" type="text" name="uid" id="" placeholder="Enter User ID" value="<?php echo $uid ?>" autofocus>
				</p>
			</form>

    <div class="container-fluid pt-4 px-4"> <!--table start -->

      <div class="row">
        <div class="col-12">
          <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Users</h6>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
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