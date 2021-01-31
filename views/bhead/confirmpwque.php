<?php
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/user.php";

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);

	if(isset($_POST['save'])){
		// $uid = $_GET['rowid'];
		$user->password = $_POST['password'];
		$user->uid = $_SESSION['uid'];
		$user->authorizeu();
		if($user->confirmuser($user->password)){
			
			echo 
			"<script>
				alert('Correct Password!');
				window.location.href = 'promoteuser';
			</script>";
		}
		else {
			echo
			"<script>
				alert('Wrong Pass!');
				window.location.href = 'viewpeoplein';
			</script>";
		}
	}
?>
<form method="POST" action="confirmpwque.php?pid=<?php echo $_SESSION['uid']; ?>">
	<center><i class="far fa-question-circle" style="font-size:150px;"></i></center>
	<p class="lead">We need to confirm your password. This is to prove that it's you.</p>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Password: </label>
		</div>
		<div class='col-sm-8'>
			<input class="form-control" type="password" name='password' required></input>
		</div>
	</div>
	<br>

	<div class="form-row float-right">
		<div class="col-lg-12 mb-3">  
		  <input type="submit" class="btn btn-success ml-2" name="save" value="Enter"/>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
  	</div>  
</form>