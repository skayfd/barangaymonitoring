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

	if(isset($_POST['rid'])){
		$record->rid = $_POST['rid'];
	}

	if(isset($_POST['save'])){
		$date = $_POST['date'];
		$time = $_POST['time'];
		$combinedDT = date('Y-m-d h:i:s', strtotime("$date $time"));

		$record->timeout = $combinedDT;
		$record->rid = $_GET['rid'];


		$person->rid = $_GET['rid'];
		$person->readspecPersonRecord($person->rid);

		//history
		date_default_timezone_set("Asia/Manila");
		$history->daterecorded = date("Y-m-d h:i:s");
		$avar = "Time Out record of";
		$into = "from records.";
		$history->action = $avar.' '.$person->firstname.' '.$person->lastname.' '.$into;
		$history->createPersonHis();

		if($record->timeoutrecord()){
			//does not pass here but executes for some reason
		}
		else {
			// echo 
			// 	"<script>
			// 		alert('Manually Timed Out!');
			// 		window.location.href = 'viewlist.php';
			// 	</script>";
			echo 
				"<script>
					alert('Manually Timed Out!');
				</script>";
			header("Location: viewrecordlist.php?id=" . $person->pid);
		}

		// $date = $_POST['date'];
		// $time = $_POST['time'];
		// $combinedDT = date('Y-m-d h:i:s', strtotime("$date $time"));

		// echo $record->rid."<br>";
		// echo $combinedDT;
	}

?>
<form method="POST" action="timeout.php?rid=<?php echo $record->rid; ?>">
	<?php 
		// echo $record->rid."<br>";
		// echo $person->firstname;
		
	?>
	<div class='row'>
		<div class='col-sm-4'>
			<label for="email">Date:</label>
		</div>
		<div class='col-sm-8'>
		    <input type="text" class="form-control date" name="date" required>				    
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Time: </label>
		</div>
		<div class='col-sm-8'>
			<input id="timepicker1" type="time" class="form-control input-small without_ampm" name="time" required>
		</div>
	</div>
	<br>

	<div class="form-row float-right">
		<div class="col-lg-12 mb-3">  
		  <input type="submit" class="btn btn-success ml-2" name="save" value="Time Out"/>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
  	</div>  
</form>

<script>
//datepicer script
$(document).ready(function() {
	$('.date').datepicker();
});
</script>