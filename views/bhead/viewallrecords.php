<?php
	session_start();
	$title = "People Recorded";
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

	$record = new record($db);
	
	$record->search = isset($_GET['search']) ? $_GET['search']:"";

	$page = isset($_GET['page']) ? $_GET['page']:"1";
	if($page == "" || $page == "1"){
		$page1 = 0;
	}else{
		$page1 = ($page*5)-5;
	}

	$record->page1 = $page1;
	$stmt2 = $record->searchrec2(); //CHANGE
	$count = $stmt2->rowCount();
	$num = ceil($count/5);

?>
<br>
	<center><a href="viewgroup" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Group Panel</a>
	<h1 class="display-4 text-light">All Records</h1></center>

	<div class="position-static">
	<form class="form-inline">
	<input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search" required>
	<input class="form-control mr-sm-2" type="time" name="search" placeholder="Search" aria-label="Search" required>
      <input class="form-control mr-sm-2" type="date" name="search" placeholder="Search" aria-label="Search" required>
      <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search &#128269;</button>
    </form>
</div>
<?php
$stmt = $record->searchrec();
?>
	<div class="card">
		<br>
		<table id="datarecord" class="table table-responsive table-light">
		  <thead>
		    <tr>
		      <th scope="col">Person ID Number</th>
		      <th scope="col">Full Name</th>
		      <th scope="col">Date Recorded/Time In</th>
		      <th scope="col">Time Out</th>
		      <th scope="col">Barangay Recorded In</th>
		      <th scope="col">Address</th>
		      <th scope="col">Point of Origin</th>
		      <th scope="col">Destination</th>
		      <th scope="col">Contact Number</th>
		      <th scope="col">Reason</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php
		  	$stmt = $record->searchrec2();
		  	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		  	echo '
		    <tr>
		      <th scope="row">'.$row['personid'].'</th>
		      <td>'.$row['fullname'].'</td>
		      <td><p style="color:blue">'.$row['daterecorded'].'</p></td>';

		      //check timeout
		      if(empty($row['tout'])){
		      	echo '<td><p style="color:red"><i class="fas fa-times"></i> Time not set</p></td>';
		      }
		      else {
		      	echo '<td><p style="color:green">'.$row['tout'].'</p></td>';
		      }

		      echo '
		      <th scope="col">'.$row['barname'].'</th>
		      <td>'.$row['address'].'</td>
		      <td>'.$row['porigin'].'</td>
		      <td>'.$row['destination'].'</td>
		      <td>'.$row['contactno'].'</td>
		      <td>'.$row['reason'].'</td>
		      <td>'.$row['status'].'</td>
		    </tr>';
			}
		    ?>
		  </tbody>
		</table>&nbsp

	</div>

<button><a href='viewallrecords.php'><div class='img-slider'>$x</div></a></button>

<script>
$(document).ready(function() {
    $('#datarecord').dataTable( {
    "aLengthMenu": [[5, 10, 20, 40,-1], [5, 10, 20, 40,"All"]],
    "pageLength": 5,
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 5, "desc" ]]
    } );

} );
</script>

<?php
	include_once '../include/footer.php';
?>