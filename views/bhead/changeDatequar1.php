<?php
	session_start();
	$title="Change Date";
	include_once '../include/header.php';
    include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";
	include_once "../../classes/history.php";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
    $database = new Database();
    $db = $database->getConnection();
 
	$person = new Person($db);
	$record = new Record($db);
	$history = new History($db);
	
?>
<div class="row">
  <div class="col-3">
	<div class="card border-dark mb-3" style="max-width: 18rem;">
		<div class="card-header">Name</div>
			<div class="card-body text-dark">
				<?php 
				$person->pid = $_GET['id'];
				$stmt=$person->readspecPerson2();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					echo '<h5 class="card-title">'.$row['fullname'].'</h5>';
					echo '<h5 class="card-title">Address: '.$row['address'].'</h5>';
				}		
				?>
				<p class="card-text"></p>
				</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	 var table = $('#tpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],
		
    } );
} );
</script>
<?php
	include_once '../include/footer.php';
?>