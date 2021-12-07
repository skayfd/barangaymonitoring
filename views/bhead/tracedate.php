<?php
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";
	include_once "../../classes/history.php";

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

	#echo $_GET['pid'];
?>

<form target="_blank" action="tracing?id=<?php echo $_GET['pid']; ?>" method="GET">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="">From Date</label>
				<input type="date" class="form-control" value="<?php if(isset($_GET['from_date'])){echo $_GET['from_date'];}else{}?>" name="from_date"  placeholder="From Date">
				<input type="text" class="form-control" value="<?php echo $_GET['pid'];?>" name="id" hidden>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="">To Date</label>
				<input type="date" class="form-control" value="<?php if(isset($_GET['to_date'])){echo $_GET['to_date'];}else{}?>" name="to_date" placeholder="To Date">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-2">
			<div class="form-group">
			<input type="submit" class="btn btn-success" name="save" value="Trace"/>
			</div>
		</div>
	</div>
</form>




<style>
.ui-datepicker {
   background: #333;
   border: 1px solid #555;
   color: #EEE;
}
</style>
<script>
//datepicer script
$(document).ready(function() {
	$('.date').datepicker();
});
</script>