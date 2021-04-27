<?php
	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);

	session_start();
	$title = "Add Person";
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/history.php";
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
	$history = new History($db);

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
			$person->brgycert = $imgname;
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
					$person->brgycert = $imgname;
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
			$person->healthdeclaration = $imgname2;
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
					$person->healthdeclaration = $imgname2;
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
			$person->medcert = $imgname3;
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
					$person->medcert = $imgname3;
				}
			}
			else {
				$medfile = 1;
			}
		}

		if(!file_exists($_FILES['travelauth']['tmp_name']) || !is_uploaded_file($_FILES['travelauth']['tmp_name'])){
			$temp4 = explode(".", $_FILES["travelauth"]["name"]);
			$newfilename4 = substr(md5(microtime()),rand(0,26),26) . '.' . end($temp4);
			move_uploaded_file($_FILES['travelauth']['tmp_name'], "../../assets/img/".$newfilename4);
			$imgname4 = "../../assets/img/".$newfilename4;
			$person->travelauth = $imgname4;
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
					$person->travelauth = $imgname4;
				}
			}
			else {
				$travelfile = 1;
			}
		}
		
		$person->uid = $_SESSION['uid'];
		
		//check if file is valid
		if($brgycertfile == 1 || $healthfile == 1 || $medfile == 1 || $travelfile == 1){
			echo
			'
			<script type="text/javascript">
	        	swal({ 
	        		icon: "error",
	        		title: "INVALID FILE!",
	        		text: "Please check if your file is an image.",
	        	});
		    </script>
			';
		}
		else {
			//check if file exceeds size
			if($brgycertsize == 1 || $healthsize == 1 || $medsize == 1 || $travelsize == 1){
				echo
				'
				<script type="text/javascript">
		        	swal({ 
		        		icon: "error",
		        		title: "FILE TOO BIG!",
		        		text: "Please check if your file exceeds 1MB.",
		        	});
			    </script>
				';
			}
			else {
				if($person->createperson()){		
					$history->daterecorded = date("Y-m-d h:i:s");
					$avar = "Added";
					$into = "into listed people.";
					$history->action = $avar.' '.$_POST['firstname'].' '.$_POST['lastname'].' '.$into;
					$history->createPersonHis();
					echo '
					<script>
						alert("Person Added!");
						window.location.replace("viewpeoplelist");
					</script>
					';
				}
				else {
					echo "Something's Wrong";
				}
			}
		}
	}
?>
<br>
<div class="container">
	<div class="container">
	<center><a href="viewpeoplelist" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a></center><br>
	<form method="POST" action="personAdd.php" enctype="multipart/form-data">
      <div class="jumbotron bg-secondary">
      	<h1 class="display-4">Add Person</h1>
      	<p><small>* are shown as required.</small></p>
		<div class="row">
			<div class="col-md-4">
				<label>First Name*</label>
				<input type="text" class="form-control" name="firstname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
			</div>
			<div class="col-md-4">
				<label>Middle Name</label>
				<input type="text" class="form-control" name="middlename" pattern="[A-Za-z\s]{3,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
			</div>
			<div class="col-md-4">
				<label>Last Name*</label>
				<input type="text" class="form-control" name="lastname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>'required>
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

		<center><h3><u>Important Documents</u></h3>&nbsp
		<p><small>Files should be an image(JPEG/PNG) and should be under 1MB</small></p></center>
		<div class="row">
			<div class="col-md-6">
				<label>Picture of Barangay Certificate</label>
				<div class="form-group">
				    <input type="file" class="form-control-file" accept='image/*' name="brgycert">
				</div>
			</div>
			<div class="col-md-6">
				<label>Picture of Health Declaration form</label>
				<div class="form-group">
				    <input type="file" class="form-control-file" accept='image/*' name="healthdeclaration">
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<label>Picture of Medical Certificate</label>
				<div class="form-group">
				    <input type="file" class="form-control-file" accept='image/*' name="medcert">
				</div>
			</div>
			<div class="col-md-6">
				<label>Picture of Travel Authority</label>
				<div class="form-group">
				    <input type="file" class="form-control-file" accept='image/*' name="travelauth">
				</div>
			</div>			
		</div>
		<hr>
		<br>

		<input type="submit" name="submit" class="btn btn-primary" value="Create">
        <a href="viewpeoplelist.php" class="btn btn-danger" data-dismiss="modal">Back</a>
      </div>	      	
    </form>
	</div>
</div>
<?php
	include_once '../include/footer.php';
?>