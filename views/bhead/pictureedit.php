<?php
	session_start();
	$title = "Profile Picture";
	include_once "../../config/database.php";
	include_once "../../classes/user.php";
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

	$user = new User($db);
	$user->readoneuser();

	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);


	if(isset($_POST['submit'])){

		$profile = 0;
		$profsize = 0;

		if(!file_exists($_FILES['profpic']['tmp_name']) || !is_uploaded_file($_FILES['profpic']['tmp_name'])){
			$temp = explode(".", $_FILES["profpic"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			move_uploaded_file($_FILES['profpic']['tmp_name'], "../../assets/img/".$newfilename);
			$imgname = "../../assets/img/".$newfilename;
			$user->profilepic = $imgname;
		}
		else{
			if($_FILES['profpic']['type'] == 'image/jpeg' || $_FILES['profpic']['type'] == 'image/jpg' || $_FILES['profpic']['type'] == 'image/png'){
				//checksize
				if($_FILES['profpic']['size'] > 1*MB){
					$profsize = 1;
				}
				else{
					$temp = explode(".", $_FILES["profpic"]["name"]);
					$newfilename = round(microtime(true)) . '.' . end($temp);
					move_uploaded_file($_FILES['profpic']['tmp_name'], "../../assets/img/".$newfilename);
					$imgname = "../../assets/img/".$newfilename;
					$user->profilepic = $imgname;
				}
			}
			else{
				$profile = 1;
			}
		}
		//check if file is valid
		if($profile == 1){
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
			//check file is exceeds limit
			if($profsize == 1){
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
				if($user->editPicture()){
					echo '
					<script>
						alert("Profile Picture Changed!");
						window.location.replace("headprofile");
					</script>
					';
				}
				else {
					echo "Error";
				}
			}
		}
	}
?>
<div class="modal-dialog" role="document">
<div class="modal-content bg-secondary">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
    </div>

    <form method='POST' action="pictureedit" enctype="multipart/form-data">
    <div class="modal-body" id='editProfileContent'>
    	<div class='container'>
    		<br>
    		<div class='row'>
    			<div class='col-sm-12'>
    			<center>
    			<p class="h2">Current Profile Picture:</p>
				<?php
  					if($user->readProfilePic() == 1){		  						
  						echo '
  						<i class="fas fa-user text-light" style="font-size:150px;"></i>
  						';
  					}
  					else {
  						echo '
  						<img src="../../assets/img/'.$user->profilepic.'" width="150px" height="150px">
  						';
  					}
  				?>
				</center><br>
    			</div>
    		</div>
    		<div class='row'>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text">Upload</span>
				  </div>
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" accept='image/*' name="profpic" required>
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
    		</div>
    		<br>
    	</div>
    </div>
  	<div class="modal-footer">
		<input type='submit' name="submit" class="btn btn-primary" value='Edit'>
		<a href="headprofile" class="btn btn-danger">Back</a>
  	</div>
  	</form>
</div>
</div>
<?php
	include_once '../include/footer.php';
?>