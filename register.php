<?php 
	session_start();
?>


<?php 
include 'includes/database_config.php';
?>

<?php
if(isset($_POST['submit'])){
$fname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lname = mysqli_real_escape_string($conn, $_POST['lastname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$hashed_password = sha1($password);


$Check_username_indb_query = "SELECT * FROM users WHERE email = '{$email}'"; //check the email for duplicate
$result_check = mysqli_query($conn,$Check_username_indb_query);
if(mysqli_num_rows($result_check)==1)
{
  $errors[] = "Registration failed, this email is already taken";
}
else{

    $query ="INSERT INTO users (first_name,last_name,email,password,deleted)
    VALUES('$fname','$lname','$email','$hashed_password','no')"; //insert data to the database

    $result_set = mysqli_query($conn, $query);


    $query2 = "SELECT * FROM users
			  WHERE email = '{$email}'
			  AND password = '{$hashed_password}'
			  LIMIT 1"; //transfer data to (user.php)

			$result_set = mysqli_query($conn, $query2);


			$user = mysqli_fetch_assoc($result_set);
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['first_name'] = $user['first_name'];
			$_SESSION['last_name'] = $user['last_name'];
			$_SESSION['email'] = $user['email'];
            
    header("Location: " . $_SESSION['current_page']."?register=success");
}
}
?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'><link rel="stylesheet" href="css/login.css">
</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrapper">

    <form class="form-signin" method="post" action="register.php">     

    
      <h2 class="form-signin-heading">Register</h2>

      <?php 
		if (isset($errors) && !empty($errors)) {
			
			echo '<p class="text-danger">This Email is Already Taken</p>';
		}
	  ?>

      <input type="text" class="form-control" name="firstname"placeholder="First Name" required>

      <input type="text" class="form-control" name="lastname"placeholder="Last Name" required>

      <input type="email" class="form-control mt-1" name="email"placeholder="Email" required>

      <input type="password" id="logPassword" class="form-control" name="password" placeholder="Password" required>      

      <label class="checkbox" for="showpassword">Show Password</label>
      <input type="checkbox" id="showpassword" name="showpassword" onclick="myFunction()">

      <div class="row">
          <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Register</button>   
      </div>

      <br>

      <a href="login.php" style="text-decoration: none;"><center>Existing User</center></a><br>

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
