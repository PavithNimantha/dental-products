<?php 
	session_start();
?>

<?php 
	include 'includes/database_config.php';
	
	if(isset($_POST['submit'])){

		$email    = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$hashed_password = sha1($password);


	$query = "SELECT * FROM users
			  WHERE email = '{$email}'
			  AND password = '{$hashed_password}'
			  LIMIT 1";
			  
	$result_set = mysqli_query($conn, $query);
	
	if ($result_set){
		
		if(mysqli_num_rows($result_set) == 1){ //check email & password
			
			$user = mysqli_fetch_assoc($result_set);
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['first_name'] = $user['first_name'];
			$_SESSION['last_name'] = $user['last_name'];
			$_SESSION['email'] = $user['email'];

			if($_SESSION['user_id'] == 1){
				header('Location: admin/admin.php');
			}

			else{
				header("Location: " . $_SESSION['current_page']."?login=success");
			}
		
		}
		
		else{
			
			$errors[] = 'Invalid Email or Password';
		}
	}
	
	else{
		$errors[] = 'Databse Query Failed';
	}}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrapper">

    <form class="form-signin" method="post" action="login.php">     

    
      <h2 class="form-signin-heading">Login</h2>

      <?php 
		if (isset($errors) && !empty($errors)) {
			
			echo '<p class="text-danger">Invalid Email or Password</p>';
		}
	
	
	?>

      <input type="email" class="form-control mt-1" name="email"placeholder="Email" required>

      <input type="password" id="logPassword" class="form-control" name="password" placeholder="Password" required>      

      <label class="checkbox" for="showpassword">Show Password</label>
      <input type="checkbox" id="showpassword" name="showpassword" onclick="myFunction()">

      <div class="row">
          <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Login</button>   
      </div>

      <br>

      <a href="register.php" style="text-decoration: none;"><center>Create account</center></a><br>
      
    </form>

  </div>
<!-- partial -->

<script>
function myFunction() {
    var x = document.getElementById("logPassword");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
  </script>
</body>

</html>