<?php
	session_start();
	$title = "Records";
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
	include_once '../../classes/record.php';
	include_once '../../classes/person.php';

	$record = new Record($db);
	$person = new Person($db);
?>
<div class="container">&nbsp
	<center>
	<a href="viewlist" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a>
	<br>
		<h1 class="display-4">Records</h1>
	</center>
	<div class="jumbotron">
	<?php
	echo '
	<table id="tblRecord" class="table table-hover table-bordered">
	  <thead class="thead-dark">
	    <tr>
	      <th scope="col">Date Recorded</th>
	      <th scope="col">Reason</th>
	      <th scope="col">Temperature</th>
	      <th scope="col">Person Type</th>
	      <th scope="col">Came from</th>
	      <th scope="col">Headed Location</th>
	      <th scope="col">Recorded By</th>
	      <th scope="col">Action</th>
	    </tr>
	  </thead>
	  	 <tbody>';
	  $record->pid = $_GET['id'];
	  $stmt = $record->readrelatedRecord();
	  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		echo '
	    <tr>
	      <th scope="row">'.$row['date'].'</th>
	      <td>'.$row['reason'].'</td>
	      <td>'.$row['temp'].'</td>
	      <td>'.$row['status'].'</td>
	      <td>'.$row['point'].'</td>
	      <td>'.$row['addressto'].'</td>
	      <td>'.$row['fullname'].'</td>
	      <td>
	      	<a class="btn btn-warning text-dark delete-object" delete-id="'.$row['rid'].'">Archive</a>
	      </td>
	    </tr>';
	  }
	echo '
		</tbody>
	</table>';
	?>
	</div>
</div>

<center><h1 class="display-4">Picture of Documents</h1></center>
<div class="container">
	<div class='row'>
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<?php
				$person->pid = $_GET['id'];
				$stmt = $person->documentPic();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					echo "
					<div class='row'>
						<div class='col-sm-6'>
							<h3>Barangay Certificate</h3>
							<img src='../../assets/img/".$row['brgycert']."' height='520px' width='100%'>
						</div>
						<div class='col-sm-6'>
							<h3>Health Declaration Form</h3>
							<img src='../../assets/img/".$row['healthdeclaration']."' height='520px' width='100%'>
						</div>
					</div>
					<br>
					<div class='row'>
						<div class='col-sm-6'>
							<h3>Medical Certificate</h3>
							<img src='../../assets/img/".$row['medcert']."' height='520px' width='100%'>
						</div>
						<div class='col-sm-6'>
							<h3>Travel Authority</h3>
							<img src='../../assets/img/".$row['travelauth']."' height='520px' width='100%'>
						</div>
					</div>
					<br>
					";
				}
			?>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>

<script>
$(document).ready(function() {
    $('#tblRecord').dataTable( {
    "aLengthMenu": [[3, 8, -1], [3, 8, "All"]],
    "pageLength": 3,
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 0, "desc" ]]
    } );

} );
$(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    var q = confirm("Are you sure?");
     
    if (q == true){
        $.post('recordDelete.php', {
            rid: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to delete.');
        });
    }
});
</script>
<?php
	include_once '../include/footer.php';
?>