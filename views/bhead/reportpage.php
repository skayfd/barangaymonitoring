<?php
	session_start();
	$title = "Reports Page";
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
	include_once '../../classes/person.php';

	$person = new Person($db);
?>
<form target="_blank" name="formReport" action="report/numpercateg" method="POST">
<div class='container'><br>
	<center><a href="viewgroup?id=
	<?php $stmt = $barangay->readrelatedGroup(); 
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row); 
		echo md5($row['referral']);
	} 
	?>" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Group Panel</a>
	</center><br>
	<center><h3>Number of Records</h3></center>
	<div class='row'>
		<div class='col-sm-3'>
		</div>
		<div class='col-sm-6'><br>
			<div class="card text-dark"><br>
				<div class="container">			
				<div class='row'>
					<div class='col-sm-6'>
						<label for="email">Date From:</label>
					    <input type="text" class="form-control date" name="sDate" required>
					</div>
					<div class='col-sm-6'>
						<label for="pwd">Date To:</label>
					    <input type="text" class="form-control date" name="eDate" required>
					    <input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
					</div>
				</div>
				<br>
				<!-- <label for="select">Report Options</label>
				<select class='form-control' id='report' name='report' required>
					<option></option>
					<option value='1'>Number of People</option>
				</select>
				<br> -->

				<center>
					<button type='submit' class='btn btn-success'><i class="fas fa-print"></i> Create Report</button>
				</center><br>
				</div>
			</div>
		</div>
		<div class='col-sm-3'>
		</div>
	</div>
</div>
</form>

<br>

<center><h3>People Registered in this Barangay</h3></center>
<div class="container">
	<div class="jumbotron">
		<?php
		$stmt = $person->readallpeople();
		echo '
		<table id="tblpeople" class="table bg-light table-hover table-bordered">
		  <thead>
		    <tr>
		      <th scope="col">Full Name</th>
		      <th scope="col">Contact Number</th>
		      <th scope="col">Address</th>
		      <th scope="col">Listed By</th>
		      <th scope="col">Date Added</th>
		      <th scope="col">Print Record</th>
		    </tr>
		  </thead>
		  <tbody>';
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		  	extract($row);
		  	echo '
		    <tr>
		      <td>'.$row['fullname'].'</td>
		      <td>'.$row['contactno'].'</td>
		      <td>'.$row['address'].'</td>
		      <td>'.$row['addedby'].'</td>
		      <td>'.$row['daterecorded'].'</td>
		      <td><a href="report/specperson?id='.$row['pid'].'" target="_blank" class="btn btn-success"><i class="fas fa-print"></i></a></td>
		    </tr>';
		  }
		  echo '
		  </tbody>
		</table>
		';
		?>
	</div>
</div>


<style type="text/css">
.datepicker {
    background: #333;
    border: 1px solid #555;
    color: #EEE;  
}
.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
  background: #474747;
  cursor: pointer;
}
</style>
<script>
	$(document).ready(function() {
    	$('.date').datepicker();
  	});

	// $(document).on('change','#report',function(){
	//     if($(this).val() == 1){
	//         formReport.action = "report/numpercateg";
	//     }else if($(this).val() == 2){
	//         formReport.action = "";
	//     }else if($(this).val() == 3){
	//         formReport.action = "#report/.php"; 
	//     }else{
	//         report_form.action = "#";
	//     }
 //  	});

$(document).ready(function() {
    $('#tblpeople').dataTable( {
    "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 4, "desc" ]]
    } );

});
</script>
<?php
	include_once '../include/footer.php';
?>