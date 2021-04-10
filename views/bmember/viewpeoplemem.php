<?php
	session_start();
	$title = "Barangay Staff";
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
	include_once '../../classes/barangay.php';

	$barangay = new Barangay($db);
?>
<br>
<div class="container">
	<center>
	<a href="memhome" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Group Panel</a>
	<br>
	<h1 class="display-4">Barangay Staff</h1><br>
	</center>

	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
		<div class="jumbotron">
		<?php		
		echo '
		<table id="peopleIn" class="table table-light"">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Picture</th>
		      <th scope="col">Name</th>
		      <th scope="col">Email Address</th>
		    </tr>
		  </thead>
		  ';
		  $stmt = $barangay->readPeopleInside();
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		  <tbody>
		    <tr>
		      <td>';
		      if($row['profilepic'] == ''){
		      	echo '
		      	<i class="fas fa-user text-dark" style="font-size:150px;"></i>
		      	';
		      }
		      else {
		      	echo '
		      	<img src="../../assets/img/'.$row['profilepic'].'" width="150px" height="150px">
		      	';
		      }
		      echo '
		      </td>
		      <th scope="row">'.$row['fullname'].'</th>
		      <td>'.$row['email'].'</td>
		    </tr>
		  </tbody>';
		}
		echo '
		</table>';
		?>
		</div>
		</div>
		<div class="col-md-3">
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#peopleIn').dataTable( {
    "aLengthMenu": [[3, 8, -1], [3, 8, "All"]],
    "pageLength": 3,
	"bLengthChange": true,
	"bInfo" : true,	
    } );
} );
</script>
<?php
	include_once '../include/footer.php';
?>