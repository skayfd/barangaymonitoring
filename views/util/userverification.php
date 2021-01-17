<html>
<title>Email Verify</title>
<head>
	<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">
</head>
<body class="bg-dark">&nbsp &nbsp
<?php
//get verification
  if(isset($_SESSION['uid'])){
    if($_SESSION['type'] == 1){
      header("Location: bhead/headhome");
    }
    if($_SESSION['type'] == 2){
      header("Location: bhead/memhome");
    }
    if($_SESSION['type'] == 3){
      header("Location: bhead/reqhome");
    }
  }
include_once '../../config/database.php';
include_once '../../classes/user.php';

if(isset($_GET['key'])){
	$token = $_GET['key'];

	$database = new Database();
	$db = $database->getConnection();
	$user = new User($db);

	if($user->checkEmailValid($token) == 1){
		if($user->verifyEmail($token)){
			echo '	  		  
		    <div class="container">
		      <div class="row">
		        <div class="col-md-4"></div>
		        <div class="col-md-4">
		        <center>
		          <p class="h1 text-light">Email Verified!</p>
		        </center>
		        <div class="card">
				  <div class="card-body">
				  	<center><i class="fas fa-user-check" style="font-size:120px;"></i><br>
				    <h5 class="card-title">Your Email Address is now <font class="text-success">verified!</font></h5>
				    <p class="card-text">You can now use your account fully.</p>&nbsp
				    <p>We recommend you to log out your account and log back in again.</p>
				    </center>
				  </div>
				</div>
		        </div>
		        <div class="col-md-4"></div>
		      </div>
		    </div>
			';
		}
		else{
			echo "ERROR";
		}
	}
	else {
		header("Location: ../../index");
	}
}
elseif(isset($_SESSION['uid'])) {
	header("Location: ../../index");
}
else {
	echo "WRONG!";
}
?>
</body>
</html>