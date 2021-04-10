<?php
	session_start();
	$title = "People Recorded";
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
	include_once '../../classes/record.php';

	$record = new record($db);

?>
<div class="container">
	<center><br>
	<a href="memhome" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Group Panel</a>
	<h1 class="display-4 text-light">All Records</h1></center>
	<div class="card">
		<div class="container"><br>
		<table id="tblAllRec" class="table table-light">
		  <thead>
		    <tr>
		      <th scope="col">Full Name</th>
		      <th scope="col">Date Recorded</th>
		      <th scope="col">Address</th>
		      <th scope="col">Contact Number</th>
		      <th scope="col">Reason</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php
		  	$stmt = $record->readAllRecord();
		  	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		  	echo '
		    <tr>
		      <th scope="row">'.$row['fullname'].'</th>
		      <td>'.$row['daterecorded'].'</td>
		      <td>'.$row['address'].'</td>
		      <td>'.$row['contactno'].'</td>
		      <td>'.$row['reason'].'</td>
		      <td>'.$row['status'].'</td>
		    </tr>';
			}
		    ?>
		  </tbody>
		</table>&nbsp
		</div>
	</div>
</div><br>
<script>
$(document).ready(function() {
    $('#tblAllRec').dataTable( {
    "aLengthMenu": [[10, 20, 40,-1], [10, 20, 40,"All"]],
    "pageLength": 10,
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 1, "desc" ]]
    } );

} );
</script>
<?php
	include_once '../include/footer.php';
?>