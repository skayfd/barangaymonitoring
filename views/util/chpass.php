<html>
<title>Change Password</title>
<head>
	<!--FAVICON-->
	<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">
	<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">
	<script src="../../assets/sweetalert/sweetalert.min.js"></script>
</head>
<body class="bg-dark">&nbsp &nbsp
<?php
include_once '../../config/database.php';
include_once '../../classes/user.php';
include_once '../../classes/pwd_reset.php';

if(isset($_GET['key'])){
	$token = $_GET['key'];
	// echo $token;

	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);
	$pwd_reset = new pwd_reset($db);

	$pwd_reset->token = $token;//token from link to compare at database

	if($pwd_reset->checkEmailValid($token) == 1){
		if(isset($_POST['submit'])){
			$newpass = $_POST['newpass'];
			$confpass = $_POST['confpass'];
			$hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
			//compare password
			if($newpass == $confpass){
				$user->password = $hashed_password;
				if($user->chPassFromEmail($token)){
					$pwd_reset->removeResetToken($token);
					echo '
					<script type="text/javascript">
						alert("Password Changed Successfully!!");
						window.location.replace("../login");
					</script>
					';
				}
				else {
					echo "BRUH";
				}
				
			}
			else {
				echo 
				'<script type="text/javascript">
		        	swal({ 
		        		icon: "error",
		        		title: "Password Mismatch!",
		        	});
			    </script>';
			}
		}
	}
	else {
		echo "ERROR 404";
	}
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    <center>
      <p class="h1 text-light">Change Password</p><br>
    </center>
    <div class="card">
	  <div class="card-body">
	  	<form method="POST" action="chpass.php?key=<?php echo $token; ?>">
		    <label for="exampleInputPassword1" class="form-label">New Password</label>
			<input type="password" name="newpass" class="form-control" id="exampleInputPassword1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

			<label for="exampleInputPassword2" class="form-label">Confirm Password</label>
			<input type="password" name="confpass" class="form-control" id="exampleInputPassword2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br>

		    <button type="submit" name="submit" class="btn btn-primary btn-block" type="button">Change My Password</button>
	    </center>
	    </form>
	  </div>
	</div>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>

</body>
</html>