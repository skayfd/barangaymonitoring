<?php
session_start();
$title = "Home";
include_once '../include/header.php';
if(isset($_SESSION['uid'])){
	if($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
		else { header("Location: views/verification/accountonhold"); }
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
		else { header("Location: views/verification/accountonhold"); }
	}
}
else {
	header("Location: ../views/login");
}
?>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
			<center>
				<p class="far fa-user-circle" style="font-size:150px;"></p>
				<h1 class="display-4">Account Pending</h1>
				<p>Your account is created, but it will need to be <font class="text-success"><u>verified</u></font> by the group head. This process will ensure that authorized people can come inside the group.</p>
			</center>
		</div>
		<div class="col-md-3">
		</div>
	</div>
</div>
<?php
	include_once '../include/footer.php';
?>