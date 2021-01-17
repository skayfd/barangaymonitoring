<?php
	session_start();
	$title = "Add Person";
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once '../include/header.php';

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	$person = new Person($db);

	if(isset($_POST['submit'])){
		date_default_timezone_set("Asia/Manila");
		$person->daterecorded = date("Y-m-d h:i:s");
		$person->firstname = $_POST['firstname'];
		$person->middlename = $_POST['middlename'];
		$person->lastname = $_POST['lastname'];
		$person->gender = $_POST['gender'];
		$person->contactno = $_POST['contactno'];
		$person->address = $_POST['address'];
		$person->referral = $_SESSION['referral'];
		$person->uid = $_SESSION['uid'];
		
		if($person->createperson()){
			echo '
			<script>
				alert("Person Added!");
				window.location.replace("viewpeoplelist");
			</script>
			';
		}
		else {
			echo "ERROR: Something's Wrong";
		}
	}
?>
<br>
<div class="container">
	<div class="container">
	<center><a href="viewpeoplelist" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a></center><br>
	<form method="POST" action="personAdd.php">
      <div class="jumbotron bg-secondary">
      	<h1 class="display-4">Add Person</h1>
		<div class="row">
			<div class="col-md-4">
				<label>First Name</label>
				<input type="text" class="form-control" name="firstname" pattern="[A-Za-z]{3,}" title="3 or more letters required" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
			</div>
			<div class="col-md-4">
				<label>Middle Name</label>
				<input type="text" class="form-control" name="middlename" pattern="[A-Za-z]{3,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
			</div>
			<div class="col-md-4">
				<label>Last Name</label>
				<input type="text" class="form-control" name="lastname" pattern="[A-Za-z]{3,}" title="3 or more letters required" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>'required>
			</div>			
		</div><br>
		<div class="row">
			<div class="col-md-6">
				<label>Contact Number</label>
				<input type="text" class="form-control" pattern=".{11,}" title="Please enter a valid contact number which contains 11 numbers." name="contactno" required>
			</div>
			<div class="col-md-6">
				<label>Gender</label>
				<select class="custom-select" name = "gender" required>
				  <option selected></option>
				  <option value="Female">Female</option>
				  <option value="Male">Male</option>
				</select>
			</div>
		</div><br>
		<div class="row">
			<div class="col-sm-12">
				<label>Address</label>
				<textarea class="form-control" name="address" pattern="[A-Za-z]{3,}" title="3 or more letters required" value='<?php echo isset($_POST['address']) ? $_POST['address'] : '' ?>' required></textarea>
			</div>
		</div><br>

		<input type="submit" name="submit" class="btn btn-primary" value="Create">
        <a href="viewpeoplelist.php" class="btn btn-danger" data-dismiss="modal">Back</a>
      </div>	      	
    </form>
	</div>
</div>
<?php
	include_once '../include/footer.php';
?>