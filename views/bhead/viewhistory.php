<?php
	session_start();
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
	include_once '../../classes/history.php';

	$history = new History($db);
?>
<br>
<div class="container">
	<center>
	<h3>Group History/Activity</h3>
	</center>
	<div class="container bg-light">
		<br>
		<?php
		$stmt = $history->readrelatedHistory();
		echo '
		<table id="tblArec" class="table bg-light table-hover table-bordered">
		  <thead class="thead-light">
		    <tr>
		      <th scope="col">Date</th>
		      <th scope="col">Action/Activity Done by</th>
		      <th scope="col">Action/Activity</th>
		    </tr>
		  </thead>
		  <tbody>';
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		    <tr>
		      <td>'.$row['date'].'</td>
		      <td>'.$row['addedby'].'</td>
		      <td>'.$row['action'].'</td>
		    </tr>';
		  }
		echo '
		  </tbody>
		</table>';
		?>
		<br>
	</div><br>
</div>

<script>
$(document).ready(function() {
    $('#tblArec').dataTable( {
    "aLengthMenu": [[8, -1], [8, "All"]],
    "pageLength": 8,
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 0, "desc" ]]
    } );

} );
</script>
<?php
	include_once '../include/footer.php';
?>