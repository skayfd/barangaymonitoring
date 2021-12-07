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
	include_once '../include/sidebar/report.php';
	include_once '../../classes/person.php';

	$person = new Person($db);
?>

<br>

<div class="card text-dark"><br>
<div class="container">
<center><h3>Generate report for PUI, PUM, Recovered, and Deceased </h3></center><br>	
	<div class="row">
		<div class="col-sm-3">
			<p>
			<button class="btn btn-sm btn-danger" type="button" data-toggle="collapse" data-target="#pui" aria-expanded="false" aria-controls="pui">
				People Under Investagation (PUI)
			</button>
			</p>
		</div>
		<div class="col-sm-3">
			<p>
			<button class="btn btn-sm btn-warning" type="button" data-toggle="collapse" data-target="#pum" aria-expanded="false" aria-controls="pum">
				People Under Monitoring (PUM)
			</button>
			</p>
		</div>
		<div class="col-sm-2">
			<p>
			<button class="btn btn-sm btn-success" type="button" data-toggle="collapse" data-target="#rec" aria-expanded="false" aria-controls="rec">
				Recovered   
			</button>
			</p>
		</div>
		<div class="col-sm-2">
			<p>
			<button class="btn btn-sm btn-dark" type="button" data-toggle="collapse" data-target="#dec" aria-expanded="false" aria-controls="dec">
				Deceased
			</button>
			</p>
		</div>
		<div class="col-sm-2">
			<p>
			<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#all" aria-expanded="false" aria-controls="all">
				All Report
			</button>
			</p>
		</div>
		</div>

		<div class="collapse" id="pui">
				<div class="card card-body">
				<center>
				<form target="_blank" name="formReport" action="report/pui_report" method="POST">
						<div class='row'>
							<div class='col-sm-4'>
								<label >Date From:</label>
								<input type="date" class="form-control" name="sDate" required>
							</div>
							<div class='col-sm-4'>
								<label >Date To:</label>
								<input type="date" class="form-control" name="eDate" required>
								<input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
							</div>
							<div class='col-sm-2'>
								<label >Print Peport for PUI:</label>
								<button type='submit' class='form-control btn btn-primary'><i class="fas fa-print"></i></button>
							</div>
						</div>

				</form>
				</center>
			</div>
			</div>

			<div class="collapse" id="pum">
				<div class="card card-body">
				<center>
				<form target="_blank" name="formReport" action="report/pum_report" method="POST">
						<div class='row'>
							<div class='col-sm-4'>
								<label >Date From:</label>
								<input type="date" class="form-control" name="sDate" required>
							</div>
							<div class='col-sm-4'>
								<label >Date To:</label>
								<input type="date" class="form-control" name="eDate" required>
								<input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
							</div>
							<div class='col-sm-2'>
								<label >Print Peport for PUM:</label>
								<button type='submit' class='form-control btn btn-primary'><i class="fas fa-print"></i></button>
							</div>
						</div>
				</form>
				</center>
			</div>
			</div>

			<div class="collapse" id="rec">
				<div class="card card-body">
				<center>
				<form target="_blank" name="formReport" action="report/rec_report" method="POST">
						<div class='row'>
							<div class='col-sm-4'>
								<label >Date From:</label>
								<input type="date" class="form-control" name="sDate" required>
							</div>
							<div class='col-sm-4'>
								<label >Date To:</label>
								<input type="date" class="form-control" name="eDate" required>
								<input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
							</div>
							<div class='col-sm-4'>
								<label >Print Peport for Recovered:</label>
								<button type='submit' class='form-control btn btn-primary'><i class="fas fa-print"></i></button>
							</div>
						</div>
				</form>
				</center>
			</div>
			</div>

			<div class="collapse" id="dec">
				<div class="card card-body">
				<center>
				<form target="_blank" name="formReport" action="report/dec_report" method="POST">
						<div class='row'>
							<div class='col-sm-4'>
								<label >Date From:</label>
								<input type="date" class="form-control" name="sDate" required>
							</div>
							<div class='col-sm-4'>
								<label >Date To:</label>
								<input type="date" class="form-control" name="eDate" required>
								<input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
							</div>
							<div class='col-sm-4'>
								<label >Print Peport for Deceased:</label>
								<button type='submit' class='form-control btn btn-primary'><i class="fas fa-print"></i></button>
							</div>
						</div>
				</form>
				</center>
			</div>
			</div>

			<div class="collapse" id="all">
				<div class="card card-body">
				<center>
				<form target="_blank" name="formReport" action="report/numpercateg" method="POST">			
								<div class='row'>
									<div class='col-sm-4'>
										<label >Date From:</label>
										<input type="date" class="form-control" name="sDate" required>
									</div>
									<div class='col-sm-4'>
										<label >Date To:</label>
										<input type="date" class="form-control" name="eDate" required>
										<input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
									</div>
									<div class='col-sm-2'>
										<label >Print:</label>
										<button type='submit' class='form-control btn btn-primary'><i class="fas fa-print"></i></button>
									</div>
								</div>
				</form>
				</center>
			</div>
			</div>

		</div>
</div>

	<div class="jumbotron">
	<center><h3>People Registered in this Barangay</h3></center>
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



<style type="text/css">
.datepicker {
    background: #333;
    border: 1px solid #555;
    color: #EEE;  
}
.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
  background: #FAF4F4;
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