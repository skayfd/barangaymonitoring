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
		$person->pid=$pid;
		$stmt =  $person->selectHS();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$record->healthStatus = $row['personStatus'];
		$record->reason = $_POST['reason'];
		$record->status = $_POST['status'];
		$record->temp = $_POST['temp'];
		$record->pointoforigin = $_POST['pointoforigin'];
		$record->addressto = $_POST['addressto'];
		$record->addressto2 = $_POST['addressto2'];
		$record->addressto3 = $_POST['addressto3'];
		$record->daterecorded = date("Y-m-d h:i:s");
		$record->pid = $pid;
		}
		$person->pid = $pid;
		$person->readspecPerson($person->pid);

		$brgycertfile = 0;
		$healthfile = 0; 
		$medfile = 0; 
		$travelfile = 0;

		$brgycertsize = 0;
		$healthsize = 0;
		$medsize = 0;
		$travelsize = 0;


		//brgycert
		if (!file_exists($_FILES['brgycert']['tmp_name']) || !is_uploaded_file($_FILES['brgycert']['tmp_name'])){
		    $temp = explode(".", $_FILES["brgycert"]["name"]);
			$newfilename = substr(md5(microtime()),rand(0,26),21) . '.' . end($temp);
			move_uploaded_file($_FILES['brgycert']['tmp_name'], "../../assets/img/".$newfilename);
			$imgname = "../../assets/img/".$newfilename;
			$record->brgycert = $imgname;
		}
		else {
			if($_FILES['brgycert']['type'] == 'image/jpeg' || $_FILES['brgycert']['type'] == 'image/jpg' || $_FILES['brgycert']['type'] == 'image/png'){
				//check size
				if($_FILES['brgycert']['size'] > 1*MB){
					$brgycertsize = 1;
				}
				else {
					$temp = explode(".", $_FILES["brgycert"]["name"]);
					$newfilename = substr(md5(microtime()),rand(0,26),21) . '.' . end($temp);
					move_uploaded_file($_FILES['brgycert']['tmp_name'], "../../assets/img/".$newfilename);
					$imgname = "../../assets/img/".$newfilename;
					$record->brgycert = $imgname;
				}			
			}
			else {
				$brgycertfile = 1;
			}
		}

		//healthdeclaration
		if(!file_exists($_FILES['healthdeclaration']['tmp_name']) || !is_uploaded_file($_FILES['healthdeclaration']['tmp_name'])){
			$temp2 = explode(".", $_FILES["healthdeclaration"]["name"]);
			$newfilename2 = substr(md5(microtime()),rand(0,26),22) . '.' . end($temp2);
			move_uploaded_file($_FILES['healthdeclaration']['tmp_name'], "../../assets/img/".$newfilename2);
			$imgname2 = "../../assets/img/".$newfilename2;
			$record->healthdeclaration = $imgname2;
		}
		else {
			if($_FILES['healthdeclaration']['type'] == 'image/jpeg' || $_FILES['healthdeclaration']['type'] == 'image/jpg' || $_FILES['healthdeclaration']['type'] == 'image/png'){
				//check size
				if($_FILES['healthdeclaration']['size'] > 1*MB){
					$healthsize = 1;
				}
				else {
					$temp2 = explode(".", $_FILES["healthdeclaration"]["name"]);
					$newfilename2 = substr(md5(microtime()),rand(0,26),22) . '.' . end($temp2);
					move_uploaded_file($_FILES['healthdeclaration']['tmp_name'], "../../assets/img/".$newfilename2);
					$imgname2 = "../../assets/img/".$newfilename2;
					$record->healthdeclaration = $imgname2;
				}
			}
			else {
				$healthfile = 1;
			}
		}
		//medcert
		if(!file_exists($_FILES['medcert']['tmp_name']) || !is_uploaded_file($_FILES['medcert']['tmp_name'])){
			$temp3 = explode(".", $_FILES["medcert"]["name"]);
			$newfilename3 = substr(md5(microtime()),rand(0,26),24) . '.' . end($temp3);
			move_uploaded_file($_FILES['medcert']['tmp_name'], "../../assets/img/".$newfilename3);
			$imgname3 = "../../assets/img/".$newfilename3;
			$record->medcert = $imgname3;
		}
		else {
			if($_FILES['medcert']['type'] == 'image/jpeg' || $_FILES['medcert']['type'] == 'image/jpg' || $_FILES['medcert']['type'] == 'image/png'){
				//check size
				if($_FILES['medcert']['size'] > 1*MB){
					$medsize = 1;
				}
				else {
					$temp3 = explode(".", $_FILES["medcert"]["name"]);
					$newfilename3 = substr(md5(microtime()),rand(0,26),24) . '.' . end($temp3);
					move_uploaded_file($_FILES['medcert']['tmp_name'], "../../assets/img/".$newfilename3);
					$imgname3 = "../../assets/img/".$newfilename3;
					$record->medcert = $imgname3;
				}
			}
			else {
				$medfile = 1;
			}
		}
		//travelauth
		if(!file_exists($_FILES['travelauth']['tmp_name']) || !is_uploaded_file($_FILES['travelauth']['tmp_name'])){
			$temp4 = explode(".", $_FILES["travelauth"]["name"]);
			$newfilename4 = substr(md5(microtime()),rand(0,26),26) . '.' . end($temp4);
			move_uploaded_file($_FILES['travelauth']['tmp_name'], "../../assets/img/".$newfilename4);
			$imgname4 = "../../assets/img/".$newfilename4;
			$record->travelauth = $imgname4;
		}
		else {
			if($_FILES['travelauth']['type'] == 'image/jpeg' || $_FILES['travelauth']['type'] == 'image/jpg' || $_FILES['travelauth']['type'] == 'image/png'){
				//check size
				if($_FILES['travelauth']['size'] > 1*MB){
					$travelsize = 1;
				}
				else {
					$temp4 = explode(".", $_FILES["travelauth"]["name"]);
					$newfilename4 = substr(md5(microtime()),rand(0,26),26) . '.' . end($temp4);
					move_uploaded_file($_FILES['travelauth']['tmp_name'], "../../assets/img/".$newfilename4);
					$imgname4 = "../../assets/img/".$newfilename4;
					$record->travelauth = $imgname4;
				}
			}
			else {
				$travelfile = 1;
			}
		}
		//check if file is valid
		if($brgycertfile == 1 || $healthfile == 1 || $medfile == 1 || $travelfile == 1){
			echo '
			<script>
				alert("INVALID FILE! Please check if the file is an image.");
				window.location.replace("viewlist");
			</script>
			';
		}
		else {
			//check if file exceeds size
			if($brgycertsize == 1 || $healthsize == 1 || $medsize == 1 || $travelsize == 1){
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
					echo "Record is Existing already";
				}
			}
		}	
	}
	
?>
<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="../../assets/sweetalert/sweetalert.min.js"></script>

<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">


<form method="POST" action="addRecord.php?pid=<?php echo $person->pid; ?>" enctype="multipart/form-data">
<div class="row">
	<div class="col-6">
		<div class='row'>
			<div class='col-sm-4'>
				<label>Person Type: </label>
			</div>
			<div class='col-sm-8'>
				<input type="radio" name="status" id="apor" value="APOR" required> APOR
				<br>
				<input type="radio" name="status" id="resident" value="Resident" required> Resident
			</div>
		</div>
		<br>
		<div class='row'>
			<div class='col-sm-4'>
				<label>Reason: </label>
			</div>
			<div class='col-sm-8'>
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name='reason' required></textarea>
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
	</div>

	<div class="col-6">
	<div class='row'>
		<div class='col-sm-12'>
			<label>Destination: </label>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-2'>
			<label>#1: </label>
		</div>
<<<<<<< HEAD
		<div class='col-sm-10'>
			<textarea class="form-control" id="exampleFormControlTextarea3" rows="2" name='addressto'></textarea>
			
=======
		<div class='col-sm-8'>
			<textarea class="form-control" id="exampleFormControlTextarea3" rows="2" name='addressto' required></textarea>
>>>>>>> parent of 3ffc982 (new ui)
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-2'>
			<label>#2: </label>
		</div>
		<div class='col-sm-10'>
			<textarea class="form-control" id="exampleFormControlTextarea4" rows="2" name='addressto2'></textarea>
		</div>
	</div>
	<br>
	<div class='row'>
		<div class='col-sm-2'>
			<label>#3: </label>
		</div>
		<div class='col-sm-10'>
			<textarea class="form-control" id="exampleFormControlTextarea5" rows="2" name='addressto3'></textarea>
		</div>
	</div>
</div>
</div>

	<hr>
	<p><small><i class="fas fa-exclamation-circle"></i><em> Files must be an Image(jpg/png) and under 1MB</em></small></p>
<div class="row">
    <div class="col">
    
		<div class='row'>
			<div id="pictures" class='col-sm-12'>
				<label>Picture of Barangay Certificate: </label>
<<<<<<< HEAD
				<input type="file" class="form-control-file" accept='image/*' name="brgycert" >
=======
			</div>
			<div class='col-sm-8'>
				<input type="file" class="form-control-file" accept='image/*' name="brgycert" required>
>>>>>>> parent of 3ffc982 (new ui)
			</div>
		</div>
		<hr>
		<div class='row'>
<<<<<<< HEAD
			<div id="pictures" class='col-sm-12'>
			<label>Picture of Health Declaration Form: </label>
				<input type="file" class="form-control-file" accept='image/*' name="healthdeclaration" >
=======
			<div class='col-sm-4'>
				<label>Picture of Health Declaration Form: </label>
			</div>
			<div class='col-sm-8'>
				<input type="file" class="form-control-file" accept='image/*' name="healthdeclaration" required>
>>>>>>> parent of 3ffc982 (new ui)
			</div>
		</div>
		<hr>
		<div class='row'>
			<div id="pictures" class='col-sm-8'>
				<label>Picture of Medical Certificate: </label>
<<<<<<< HEAD
				<input type="file" class="form-control-file" accept='image/*' name="medcert" >
=======
			</div>
			<div class='col-sm-8'>
				<input type="file" class="form-control-file" accept='image/*' name="medcert" required>
>>>>>>> parent of 3ffc982 (new ui)
			</div>
		</div>
    </div>
    <div class="col">
      	
		<div class='row'>
			<div id="pictures" class='col-sm-8'>
				<label>Picture of Travel Authority: </label>
<<<<<<< HEAD
				<input type="file" class="form-control-file" accept='image/*' name="travelauth" >
			</div>
		</div>
		<hr>
		<div id="pictures2">
			<div class='row'>
				<div class='col-sm-8'>
					<label>Picture of Valid ID: </label>
					<input type="file" class="form-control-file" accept='image/*' name="workingid" >
				</div>
=======
			</div>
			<div class='col-sm-8'>
				<input type="file" class="form-control-file" accept='image/*' name="travelauth" required>
			</div>
		</div>
	</div>

	<div id="pictures2">
		<div class='row'>
			<div class='col-sm-4'>
				<label>Picture of Valid ID: </label>
			</div>
			<div class='col-sm-8'>
				<input type="file" class="form-control-file" accept='image/*' name="workingid" required>
>>>>>>> parent of 3ffc982 (new ui)
			</div>
		</div>
		<hr>
		<div class="form-row" align="center">
			<div class="col-lg-12 mb-3">  
			<input type="submit" class="btn btn-success ml-2" name="save" value="Add Record"/>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
  		</div>  
    </div>
</div>	
</form>

<script>
$(document).ready(function() {
	var x = document.getElementById("pictures");
	var y = document.getElementById("pictures2");
    $('input:radio[name=status]').change(function() {
        if (this.value == 'APOR') {
            y.style.display = "none";
            x.style.display = "block";
         	$("#pictures2 :input").prop('required',null);          
        }
        else if (this.value == 'Resident') {
            x.style.display = "none";
            y.style.display = "block";
            $("#pictures :input").prop('required',null);  
        }
    });
});
</script>