<?php
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";
	include_once "../../classes/history.php";


	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		header("Location: ../bmember/memhome.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}
	$database = new Database();
	$db = $database->getConnection();

	$person = new Person($db);
	$record = new Record($db);
	$history = new History($db);

	if(isset($_POST['pid'])){
		$person->pid = $_POST['pid'];
	}
	
	if(isset($_POST['save'])){
		date_default_timezone_set("Asia/Manila");

		$pid = $_GET['pid'];
		$record->reason = $_POST['reason'];
		$record->status = $_POST['status'];
		$record->temp = $_POST['temp'];
		$record->pointoforigin = $_POST['pointoforigin'];
		$record->addressto = $_POST['addressto'];
		$record->daterecorded = date("Y-m-d h:i:s");
		$record->pid = $pid;

		$person->pid = $pid;
		$person->readspecPerson($person->pid);

		//history
		$history->daterecorded = date("Y-m-d h:i:s");
		$avar = "Added record for";
		$into = "in the system.";
		$history->action = $avar.' '.$person->firstname.' '.$person->lastname.' '.$into;	
		$history->pid = $pid;
		$history->createPersonHis();

		$record->createRecord();

		echo 
		"<script>
			alert('Record Added!');
			window.location.href = 'viewlist.php';
		</script>";
	}
	
?>
<form method="POST" action="addRecord.php?pid=<?php echo $person->pid; ?>">
	<div class='row'>
		<div class='col-sm-4'>
			<label>Reason: </label>
		</div>
		<div class='col-sm-8'>
			<input class="form-control" id="exampleFormControlTextarea1" rows="2" name='reason' required>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Person Type: </label>
		</div>
		<div class='col-sm-8'>
			<select class="custom-select" name="status" required>
			  <option></option>
			  <option value="APOR">APOR</option>
			  <option value="LSI">LSI</option>
			  <option value="PUI">PUI</option>
			  <option value="PUM">PUM</option>
			</select>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Temperature: </label>
		</div>
		<div class='col-sm-8'>
			<input class="form-control" type="number" step="0.01" name="temp" required>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Point of Origin: </label>
		</div>
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name='pointoforigin' required></textarea>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Address Headed to: </label>
		</div>
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name='addressto' required></textarea>
		</div>
	</div>
	<br>

	<div class="form-row float-right">
		<div class="col-lg-12 mb-3">  
		  <input type="submit" class="btn btn-success ml-2" name="save" value="Add Record"/>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
  	</div>  
</form>