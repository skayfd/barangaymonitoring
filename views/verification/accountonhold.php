<?php
session_start();
$title = "Verify Your Email";

if(isset($_SESSION['uid'])){
	if($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
}
else {
	header("Location: views/login");
}

include_once '../include/header.php';
?>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="card">
			  <div class="card-header text-dark">
			    Email Verification
			  </div>
			  <div class="card-body text-dark">
			  	<center><i class="fas fa-envelope-open-text" style="font-size:120px;"></i></center><br>
			    <h5 class="card-title">Please Verify Your Email</h5>
			    <p class="card-text">We have sent a link to your email. By verifying, you may now fully use your account.</p>
			  </div>
			</div>
			</div>
		<div class="col-md-3"></div>		
	</div>
</div>
<?php
include_once '../include/footer.php';
?>