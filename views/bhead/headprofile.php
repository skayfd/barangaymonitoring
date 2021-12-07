<?php
	session_start();
	$title = "Head Profile";
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

	$user = new User($db);
	$user->readoneuser();
?>
<br>
<div class="container">
	<center>
	<div class="card border-dark mb-3" style="max-width: 50rem;">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6 float-left">
					<h4 style="color:black"><i class="far fa-address-card"></i> Personal Info</h4>
				</div>
				<div class="col-md-6 float-right">
					<button type="button" style="margin-left: 2em" class="btn btn-secondary btn-sm edit-object" data-toggle="modal" data-target="#editProfile" edit-id="<?php echo $_SESSION['uid']; ?>"><i class="fas fa-file-signature" style="font-size:18px;"></i> Edit</button>
				</div>
			</div>
		</div>
		<div class="card-body text-dark">
			<h5 class="card-title"></h5>
				<div class="row">
					<div class="col-md-7">
							<center>
							<div><h3 class="card-title">
							<?php 
							echo $user->firstname."&nbsp";
							echo $user->middlename."&nbsp";
							echo $user->lastname; 
							?>
							</h3></div>
							<div>
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
							</div>
							 <br>
							<div>
							<a href="pictureedit" class="btn btn-info btn-sm edit-object"></i> Add Profile Picture</a>
							<div>
							<br>
							<label><h5>Email :</h5></label>
								<?php echo $user->email; ?>
								</div>
							</div>
							</center>

					</div>
					<div class="col-md-5 float-left">
						<table class=" table-sm">
							<thead>
								
							</thead>
							<tbody>
								<tr>
								<th scope="row"></th>
								<td colspan="2"><a href="changepass" class="btn btn-primary btn-sm">Change Password</a>	</td>
								</tr>
								<tr>
								<th scope="row"></th>
								<td colspan="2"><a href="changegroup" class="btn btn-warning btn-sm"><i class="fas fa-user-cog"></i> Change Barangay</a></td>
								</tr>
								<tr>
								<th scope="row"></th>
								<td colspan="2">
									<p>
										<button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
											Show ID
										</button>
									</p>
									
								</td>
								</tr>
							</tbody>
						</table>
						<div class="collapse" id="collapseExample">
										<div class="card card-body">
										<?php		
										echo '<img class="img-fluid" src="../../assets/img/'.$user->barid.'" width="350px" height="250px">';	
										?>
										</div>
									</div>
				</div>
			</div>
		</div>
	</div>
	</center>
</div>


<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content bg-white">
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
		    		
			    	<div class='row'>
		    			<div class='col-sm-4'>
		    				<label>Middle Name: </label>
		    			</div>
		    			<div class='col-sm-8'>
		    				<input type='text' class='form-control' name='middlename' value='<?php echo $user->middlename; ?>'>
		    			</div>
		    		</div>
		    		
		    		<div class='row'>
		    			<div class='col-sm-4'>
		    				<label>Last Name: </label>
		    			</div>
		    			<div class='col-sm-8'>
		    				<input type='text' class='form-control' name='lastname' value='<?php echo $user->lastname; ?>' required>
		    			</div>
		    		</div>
		    		
		    	</div>
		    </div>
	      	<div class="modal-footer">
				<input type='submit' class="btn btn-primary btn-sm" value='Edit'>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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