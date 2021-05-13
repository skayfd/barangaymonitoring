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

	echo $_GET['pid'];
?>
<form target="_blank" method="POST" action="tracing?id=<?php echo $_GET['pid']; ?>"><!-- POSTS to tracing.php -->
	
	<div class='row'>
		<div class='col-sm-4'>
			<label for="email">Date:</label>
		</div>
		<div class='col-sm-8'>
		    <input type="text" class="form-control date" name="date" required>				    
		</div>
	</div>
	<br>
	<!-- <div class='row'>
		<div class='col-sm-4'>
			<label>Time: </label>
		</div>
		<div class='col-sm-8'>
			<input id="timepicker1" type="time" class="form-control input-small without_ampm" name="time" required>
		</div>
	</div>
	<br> -->

	<div class="form-row float-right">
		<div class="col-lg-12 mb-3">  
		  <input type="submit" class="btn btn-success ml-2" name="save" value="Trace"/>
		  <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
		</div>
  	</div>  
</form>
<script>
//datepicer script
$(document).ready(function() {
	$('.date').datepicker();
});
</script>