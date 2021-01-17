<?php
	session_start();
	$title = "Profile";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	include_once '../include/header.php';
	include_once '../../classes/user.php';

	$user = new User($db);
	$user->readoneuser();
?>
<br>
<div class="container">
	<center>
	<h1 class="display-4">Account</h1><br>
	</center>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="card">
			<div class="card-header container-fluid">
			  <div class="row">
			    <div class="col-md-9 float-left">
			      <h4 style="color:black"><i class="far fa-address-card"></i> Personal Info</h4>
			    </div>
			    <div class="col-md-3 float-right">
				    <button type="button" style="margin-left: 2em" class="btn btn-secondary btn-sm edit-object" data-toggle="modal" data-target="#editProfile" edit-id="<?php echo $_SESSION['uid']; ?>"><i class="fas fa-file-signature" style="font-size:18px;"></i> Edit</button>
			    </div>
			  </div>
			</div>
			  <div class="card-body">
			  	<div class="container">
			  		<div class="row">
			  			<div class="col-sm-4"></div>
			  			<div class="col-sm-4">
			  				<center>
			  				<?php
			  					if($user->readProfilePic() == 1){		  						
			  						echo '
			  						<i class="fas fa-user text-dark" style="font-size:150px;"></i>
			  						';
			  					}
			  					else {
			  						echo '
			  						<img src="../../assets/img/'.$user->profilepic.'" width="150px" height="150px">
			  						';
			  					}
			  				?>
			  				</center>	  				
			  			</div>
			  			<div class="col-sm-4"></div>				
			  		</div><br>
			  		<center>
			  			<a href="pictureedit.php" class="btn btn-info edit-object"></i> Change Profile Picture</a>
			  		</center><br>
			  		<div class="row">
			  			<div class="col-sm-1"><i class="fas fa-signature" style="color:black; font-size:26px;"></i></div>
			  			<div class="col-sm-11">			  				
			  				<h5 class="card-title text-dark">
			  				Name: <u><?php 
			  					echo $user->firstname."&nbsp";
			  					echo $user->middlename."&nbsp";
			  					echo $user->lastname;
			  				?></u>		  					
			  				</h5>
			  			</div>
			  		</div><br/>
			  		<div class="row">
			  			<div class="col-sm-1"><i class="fas fa-envelope" style="color:black; font-size:26px;"></i></div>
			  			<div class="col-sm-11">
			  				<h5 class="card-text text-dark">Email: <u><?php
			  					echo $user->email; 
			  				?></u>	
			  				</h5>
			  			</div>
			  		</div>&nbsp
			  		<center>
			  			<a href="changepass.php" class="btn btn-primary btn-lg">Change Password</a>
			  		</center>
			  	</div>
			  </div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
&nbsp &nbsp
<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content bg-secondary">
		    <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>

		    <form method='POST' id='editProfileForm'>
		    <div class="modal-body" id='editProfileContent'>
		    	<div class='container'>
		    		<div class='row'>
		    			<div class='col-sm-4'>
		    				<label>First Name: </label>
		    			</div>
		    			<div class='col-sm-8'>
		    				<input type='text' class='form-control' name='firstname' value='<?php echo $user->firstname; ?>' required>
		    			</div>
		    		</div>
		    		<br>
			    	<div class='row'>
		    			<div class='col-sm-4'>
		    				<label>Middle Name: </label>
		    			</div>
		    			<div class='col-sm-8'>
		    				<input type='text' class='form-control' name='middlename' value='<?php echo $user->middlename; ?>'>
		    			</div>
		    		</div>
		    		<br>
		    		<div class='row'>
		    			<div class='col-sm-4'>
		    				<label>Last Name: </label>
		    			</div>
		    			<div class='col-sm-8'>
		    				<input type='text' class='form-control' name='lastname' value='<?php echo $user->lastname; ?>' required>
		    			</div>
		    		</div>
		    		<br>
		    		<!-- <div class='row'>
		    			<div class='col-sm-4'>
		    				<label>Profile Picture: </label>
		    			</div>
		    			<div class='col-sm-8'>
		    				<input type="file" accept='image/*' name="file">
		    			</div>
		    		</div> -->
		    		<br>
		    	</div>
		    </div>
	      	<div class="modal-footer">
				<input type='submit' class="btn btn-primary" value='Edit'>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      	</div>
	      	</form>
    	</div>
  	</div>
</div>
<?php
	include_once '../include/footer.php';
?>
<script>
$('#editProfileForm').on('submit', function(event){
	event.preventDefault();
	var formdata = new FormData($('#editProfileForm')[0]);
	$.ajax({
	   url:"profileedit.php",
	   method:"POST",
	   data:formdata,
	   contentType:false,
	   cache:false,
	   processData:false,
	   success:function(data){
	     $('#editProfileForm')[0].reset();
	     $('#editProfile').modal('hide');
	     window.location.reload();
	     alert("Succesfully Edited!");
	   }
	});
});
</script>