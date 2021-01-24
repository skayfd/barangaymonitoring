<?php
	session_start();
	$title = "Barangay Staff";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	include_once '../include/header.php';
	include_once '../../classes/user.php';

	$user = new User($db);

	if(isset($_POST['submit'])){
		$currpass = $_POST['currpass'];
		$confpass = $_POST['confpass'];
		$newpass = $_POST['newpass'];

		

		if($currpass == $confpass){
			if($confpass == $newpass){
				echo
				"
				<div class='container'>
				<div class='alert alert-danger alert-dismissible fade show' role='alert'>
				  <strong>Same Old Password!</strong> You're password is the same...
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				    <span aria-hidden='true'>&times;</span>
				  </button>
				</div>
				</div>
				";
			}
			elseif($user->verifyPass($currpass)){
				$hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
				$user->password = $hashed_password;
				$user->chPass();
				echo '
				<script type="text/javascript">
					alert("Password Changed!");
					window.location = "memprofile.php";
				</script>   
				';
			}
			else {
				echo "
				<div class='alert alert-warning alert-dismissible fade show' role='alert'>
				  <strong>Something Went Wrong!</strong> Try it again...
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				    <span aria-hidden='true'>&times;</span>
				  </button>
				</div>
				";
			}
		}
		else {
			echo 
			"
			<div class='container'>
			<div class='alert alert-danger alert-dismissible fade show' role='alert'>
			  <strong>Wrong Password!</strong> Password doesn't seem to match, please check your fields...
			  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			    <span aria-hidden='true'>&times;</span>
			  </button>
			</div>
			</div>
			";
		}
	}
?>
&nbsp
<div class="container">
	<center><h1 class="display-5">Change Password</h1></center>
	<form method="POST" action="changepass.php">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<!-- Password input-->
		  <label class="control-label" for="CurrPass">Current Password</label>
		  <input id="CurrPass" name="currpass" type="password" placeholder="" class="form-control input-md" required>  
		</div>
		<div class="col-md-3"></div>
	</div>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<!-- Password input-->
		  <label class="control-label" for="NewPass">Confirm Password</label>
		  <input id="NewPass" name="confpass" type="password" placeholder="" class="form-control input-md" required>
		</div>
		<div class="col-md-3"></div>	
	</div>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<!-- Password input-->
		  <label class="control-label" for="NewPassRepeat">New Password</label>
		  <input id="NewPassRepeat" name="newpass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" type="password" placeholder="" class="form-control input-md" required>
		</div>
		<div class="col-md-3"></div>	    
	</div>&nbsp	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		  <center>
		  <!-- Button (Double) -->
		  <button type="submit" name="submit" class="btn btn-success">Submit</button>
		  <a href="memprofile.php" class="btn btn-danger">Cancel</a>
		  </center>
		</div>
		<div class="col-md-3"></div>
	</div>
	</form>
</div>


<?php
	include_once '../include/footer.php';
?>