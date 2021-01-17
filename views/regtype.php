<?php
	session_start();
	$title = "Registration Type";
	include_once "include/header.php";

	if(isset($_SESSION['uid'])){
		if($_SESSION['type'] == 1){
			header('Location: bhead/headhome.php');
		}
	}
?>
<div class="container">
	<div class="res">&nbsp
		<h1 class="display-4"><center>Registration Type</center></h1>
	</div>&nbsp
	<center>
	<div class="row">
		<div class="col-md-6">
			<div class="card" style="width: 22rem;">
	           <a href="regcapsec.php" class="btn btn-fix text-left"><br>
	              <center><p class="fas fa-user-shield" style="font-size:150px;"></p></center>
	                <div class="card-block ">
	                    <h4 class="card-title text-dark" style="text-align: center">Barangay Captain/Secretary</h4>
	                    <p class="card-text text-dark "><!--extra info--></p>
	                </div>
	            </a>
        	</div>
		</div>
		<div class="col-md-6">
			<div class="card" style="width: 22rem;">
	           <a href="regkag.php" class="btn btn-fix text-left"><br>
	              <center><p class="fas fa-user-plus" style="font-size:150px;"></p></center>
	                <div class="card-block ">
	                    <h4 class="card-title text-dark" style="text-align: center">Barangay Kagawad</h4>
	                    <p class="card-text text-dark "><!--extra info--></p>
	                </div>
	            </a>
        	</div>
		</div>
	</div>
	</center>
</div>
<?php
	include_once "include/footer.php";
?>