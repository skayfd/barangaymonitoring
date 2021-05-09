<?php
	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";
	include_once "../../classes/history.php";
	include_once "../../classes/barangay.php";

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
	$barangay = new Barangay($db);

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
		$record->addressto2 = $_POST['addressto2'];
		$record->addressto3 = $_POST['addressto3'];
		$record->daterecorded = date("Y-m-d h:i:s");
		$record->pid = $pid;

		$person->pid = $pid;
		$person->readspecPerson($person->pid);


		$workfile = 0;
		$worksize = 0;

		//workid
		if (!file_exists($_FILES['workingid']['tmp_name']) || !is_uploaded_file($_FILES['workingid']['tmp_name'])){
		    $temp = explode(".", $_FILES["workingid"]["name"]);
			$newfilename = substr(md5(microtime()),rand(0,26),21) . '.' . end($temp);
			move_uploaded_file($_FILES['workingid']['tmp_name'], "../../assets/img/".$newfilename);
			$imgname = "../../assets/img/".$newfilename;
			$record->workingid = $imgname;
		}
		else {
			if($_FILES['workingid']['type'] == 'image/jpeg' || $_FILES['workingid']['type'] == 'image/jpg' || $_FILES['workingid']['type'] == 'image/png'){
				//check size
				if($_FILES['workingid']['size'] > 1*MB){
					$worksize = 1;
				}
				else {
					$temp = explode(".", $_FILES["workingid"]["name"]);
					$newfilename = substr(md5(microtime()),rand(0,26),21) . '.' . end($temp);
					move_uploaded_file($_FILES['workingid']['tmp_name'], "../../assets/img/".$newfilename);
					$imgname = "../../assets/img/".$newfilename;
					$record->workingid = $imgname;
				}			
			}
			else {
				$workfile = 1;
			}
		}

		//check if file is valid
		if($workfile == 1){
			echo '
			<script>
				alert("INVALID FILE! Please check if the file is an image.");
				window.location.replace("viewlist");
			</script>
			';
		}
		else {
			//check if file exceeds size
			if($worksize == 1){
				echo '
				<script>
					alert("A file exceeds 1MB! Please check the size of your files.");
					window.location.replace("viewlist");
				</script>
				';
			}
			else {
				if($record->createRecord()){
					//history
					$history->daterecorded = date("Y-m-d h:i:s");
					$avar = "Added record for";
					$into = "in the system.";
					$history->action = $avar.' '.$person->firstname.' '.$person->lastname.' '.$into;	
					$history->pid = $pid;
					$history->createPersonHis();

					echo 
					"<script>
						alert('Record Added!');
						window.location.href = 'viewlist.php';
					</script>";
				}
				else {
					echo "Something's Wrong";
				}
			}
		}
	}
	
?>
<form method="POST" action="addRecord2.php?pid=<?php echo $person->pid; ?>" enctype="multipart/form-data">
	<div class='row'>
		<div class='col-sm-4'>
			<label>Reason: </label>
		</div>
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name='reason' required></textarea>
		</div>
	</div>
	<!-- Hidden input here for Resident -->
	<input type="hidden" name="status" value="RESIDENT">
	<!-- <div class='row'>
		<div class='col-sm-4'>
			<label>Person Type: </label>
		</div>
		<div class='col-sm-8'>
			<select class="custom-select" name="status" required>
			  <option></option>
			  <option value="APOR">APOR</option>
			  <option value="PUI">PUI</option>
			  <option value="PUM">PUM</option>
			  <option value="LSI">LSI</option>
			</select>
		</div>
	</div> -->
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
			<select class="form-control" name="pointoforigin" required>
				<option selected></option>
				<?php
					$stmt = $barangay->readbar();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						echo "
						<option value='".$row['brgyname']."'>".$row['brgyname']."</option>";
					}
				?>
			</select>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Destination: </label>
		</div>
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea3" rows="2" name='addressto' required></textarea>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Destination 2: </label>
		</div>
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea4" rows="2" name='addressto2'></textarea>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Destination 3: </label>
		</div>
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea5" rows="2" name='addressto3'></textarea>
		</div>
	</div>
	<br>
	<p><small><i class="fas fa-exclamation-circle"></i><em> Files must be an Image(jpg/png) and under 1MB</em></small></p>
	<div class='row'>
		<div class='col-sm-4'>
			<label>Picture of Working ID: </label>
		</div>
		<div class='col-sm-8'>
			<input type="file" class="form-control-file" accept='image/*' name="workingid" required>
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