<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$title = "Barangay Staff";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	include_once '../include/header.php';
	include_once '../include/sidebar/profile.php';
	include_once '../../classes/user.php';
	include_once '../../classes/barangay.php';

	require_once '../../vendor/autoload.php';


	$user = new User($db);
	$barangay = new Barangay($db);

	

	if(isset($_POST['submit'])){
		$result = $_POST['referral'];
		$result_explode = explode('|', $result);	

		$user->referral = $result_explode[0];
		$user->bid = $result_explode[1];

		$user->uid = $_SESSION['uid'];//store uid on variable to user again on reauth

		if($user->changeBarangay()){
			session_destroy();
			$user->reAuth($user->uid);
			// echo 
			// '<script type="text/javascript">
	  //       	swal({ 
	  //       		icon: "success",
	  //       		title: "Barangay Changed!",
	  //       		text: "You now have now joined the chosen barangay! Please log-out to take effect.",
	  //       	});
		 //    </script>';
			echo "
				<script>
					alert('Barangay Changed!!!');
					window.location.replace('viewgroup');
				</script>
			";
		}
		else{
			echo 
			'<script type="text/javascript">
	        	swal({ 
	        		icon: "error",
	        		title: "Error",
	        		text: "Something Went Wrong.",
	        	});
		    </script>';
		}
	}
?>
&nbsp
<div class="container">
	<center><h1 class="display-5"><i class="fas fa-exchange-alt"></i> Change Barangay</h1></center>
	<form method="POST" action="changegroup">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		  <?php 
    		$stmt = $barangay->readrelatedGroup();
    		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo "<b>Current Barangay: <h4 class='text-warning'>&nbsp".$row['brgyname']."</b></h4>";
			}
		  ?>
		</div>
		<div class="col-md-3"></div>
	</div>
	&nbsp &nbsp
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		  <label class="control-label" for="NewPass">Choose Barangay</label>
		  <select class="form-control" name="referral" required>
			<option selected></option>
			<?php
				$stmt = $barangay->readbarEX();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					echo "<option value='".$row['referral']."|".$row['bid']."'>".$row['brgyname']."</option>";
				}
			?>
		  </select>
		</div>
		<div class="col-md-3"></div>	
	</div>&nbsp&nbsp
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		  <center>
		  <!-- Button (Double) -->
		  <button type="submit" name="submit" class="btn btn-success">Submit</button>
		  <a href="headprofile" class="btn btn-danger">Cancel</a>
		  </center>
		</div>
		<div class="col-md-3"></div>
	</div>
	</form>
</div>


<?php
	include_once '../include/footer.php';
?>