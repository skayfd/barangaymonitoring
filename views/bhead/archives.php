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
	include_once '../../classes/barangay.php';
	include_once '../../classes/record.php';
	include_once '../../classes/person.php';

	$barangay = new Barangay($db);
	$person = new Person($db);
	$record = new Record($db);
?>
<br>
<div class="container">
	<center>
	<h3>Archived Records</h3>
	</center>
	<div class="container bg-light">
		<br>
		<?php
		$stmt = $record->readarchiveRec();
		echo '
		<table id="tblArec" class="table bg-light table-hover table-bordered">
		  <thead class="thead-light">
		    <tr>
		      <th scope="col">Full Name</th>
		      <th scope="col">Date Added</th>
		      <th scope="col">Contact Number</th>
		      <th scope="col">Address</th>
		      <th scope="col">Temperature</th>
		      <th scope="col">Reason</th>
		      <th scope="col">Status</th>
		      <th scope="col">Came From</th>
		      <th scope="col">Address to</th>
		      <th scope="col">Listed By</th>
		    </tr>
		  </thead>
		  <tbody>';
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		    <tr>
		      <td>'.$row['fullname'].'</td>
		      <td>'.$row['date'].'</td>
		      <td>'.$row['contactnumber'].'</td>
		      <td>'.$row['address'].'</td>
		      <td>'.$row['temp'].'</td>
		      <td>'.$row['reason'].'</td>
		      <td>'.$row['status'].'</td>
		      <td>'.$row['point'].'</td>
		      <td>'.$row['addressto'].'</td>
		      <td>'.$row['addedby'].'</td>
		    </tr>';
		  }
		echo '
		  </tbody>
		</table>';
		?>
		<br>
	</div><br>
	<center>
	<h3>Archived Person</h3>
	</center>
	<div class="container bg-light">
		<br>
		<?php
		$stmt = $person->readarchivePer();
		echo '
		<table id="tblAper" class="table bg-light table-hover table-bordered">
		  <thead class="thead-light">
		    <tr>
		      <th scope="col">Full Name</th>
		      <th scope="col">Date Added</th>
		      <th scope="col">Gender</th>
		      <th scope="col">Contact Number</th>
		      <th scope="col">Address</th>
		      <th scope="col">Barangay Certificate</th>
		      <th scope="col">Health Declaration Form</th>
		      <th scope="col">Medical Certificate</th>
		      <th scope="col">Travel Authority</th>
		      <th scope="col">Listed Down By</th>
		    </tr>
		  </thead>
		  <tbody>';
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		    <tr>
		      <td>'.$row['fullname'].'</td>
		      <td>'.$row['date'].'</td>
		      <td>'.$row['gender'].'</td>
		      <td>'.$row['contactno'].'</td>
		      <td>'.$row['address'].'</td>
		      <td>'.$row['brgycert'].'</td>
		      <td>'.$row['hdecla'].'</td>
		      <td>'.$row['medcert'].'</td>
		      <td>'.$row['travelauth'].'</td>
		      <td>'.$row['addedby'].'</td>
		    </tr>';
		  }
		echo '
		  </tbody>
		</table>';
		?>
		<br>
	</div>
</div>

<script>
$(document).ready(function() {
    $('#tblArec').dataTable( {
    "aLengthMenu": [[8, -1], [8, "All"]],
    "pageLength": 8,
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 1, "desc" ]]
    } );

} );
$(document).ready(function() {
    $('#tblAper').dataTable( {
    "aLengthMenu": [[8, -1], [8, "All"]],
    "pageLength": 8,
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 1, "desc" ]]
    } );

} );
</script>
<?php
	include_once '../include/footer.php';
?>