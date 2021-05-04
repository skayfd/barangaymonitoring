<?php
	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);

	ini_set('display_errors', 1);

	session_start();
	$title = "Add Person";
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once '../../classes/history.php';
	include_once '../include/header.php';


	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	$person = new Person($db);
	$history = new History($db);

	if(isset($_POST['submit'])){
		date_default_timezone_set("Asia/Manila");

		$person->daterecorded = date("Y-m-d h:i:s");
		$person->firstname = trim($_POST['firstname']);
		$person->middlename = trim($_POST['middlename']);
		$person->lastname = trim($_POST['lastname']);
		$person->gender = $_POST['gender'];
		$person->contactno = trim($_POST['contactno']);
		$person->address = trim($_POST['address']);
		$person->referral = $_SESSION['referral'];
		$person->uid = $_SESSION['uid'];
		
		if($person->createperson()){		
			$history->daterecorded = date("Y-m-d h:i:s");
			$avar = "Added";
			$into = "into listed people.";
			$history->action = $avar.' '.$_POST['firstname'].' '.$_POST['lastname'].' '.$into;
			$history->createPersonHis();
			echo '
			<script>
				alert("Person Added!");
				window.location.replace("viewlist");
			</script>
			';
		}
		else {
			echo "Something's Wrong";
		}
	}
?>
<br>
<div class="container">
	<div class="container">
		<div class="container">
			<center><a href="viewlist" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a></center><br>
			<form method="POST" action="personAdd" enctype="multipart/form-data">
		      <div class="jumbotron bg-secondary">
		      	<h1 class="display-4">Add Person</h1>
		      	<p><small>* are shown as required.</small></p>
		      	<hr>
				<div class="row">
					<div class="col-md-4">
						<label>First Name*</label>
						<input type="text" class="form-control" name="firstname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
					</div>
					<div class="col-md-4">
						<label>Middle Name</label>
						<input type="text" class="form-control" name="middlename" pattern="[A-Za-z\s]{3,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
					</div>
					<div class="col-md-4">
						<label>Last Name*</label>
						<input type="text" class="form-control" name="lastname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>'required>
					</div>			
				</div><br>
				<div class="row">
					<div class="col-md-6">
						<label>Contact Number*</label>
						<input type="text" class="form-control" pattern=".{11,}" title="Please enter a valid contact number which contains 11 numbers." name="contactno" value='<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : '' ?>' required>
					</div>
					<div class="col-md-6">
						<label>Gender*</label>
						<select class="custom-select" name = "gender" required>
						  <option selected></option>
						  <option value="Female">Female</option>
						  <option value="Male">Male</option>
						</select>
					</div>
				</div><br>
				<div class="row">
					<div class="col-sm-12">
						<label>Address*</label>
						<textarea class="form-control" name="address" pattern="[A-Za-z]{3,}" title="3 or more letters required" required><?php echo isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>
					</div>
				</div><br>
				<hr>
				<input type="submit" name="submit" class="btn btn-primary" value="Create">
		        <a href="viewlist" class="btn btn-danger" data-dismiss="modal">Back</a>
		      </div>	      	
		    </form>
		</div>
	</div>
</div>
<?php
	include_once '../include/footer.php';
?>