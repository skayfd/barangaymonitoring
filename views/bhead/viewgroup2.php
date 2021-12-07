<?php
	ini_set('display_errors', 1);
	session_start();
	$title = "View Group";
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
	include_once '../../classes/user.php';
	include_once '../../classes/barangay.php';
	include_once '../../classes/person.php';
	include_once '../../classes/record.php';

	$barangay = new Barangay($db);
	$person = new Person($db);
	$record = new Record($db);


?>
<div class="container"> 
	<div class="row">
		<div class="col-sm-4">
		<?php 
				$stmt = $barangay->readrelatedGroup();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo "<h3><i><b>".$row['brgyname']."</b></i></h3>";
				}
			?>
		</div>
		<div class="col-sm-4">
		
		</div>
		<div class="col-sm-4">
			<h3><p><?php echo date('F d, Y');?> <span id="clock"></span></p></h3>
		</div>
	</div>

		<script>
			function showTime() {
				var d = new Date();
				document.getElementById("clock").innerHTML = d.toLocaleTimeString();
			}
			setInterval(showTime, 1000);
		</script>


	<div class="row">
		<div class="col">
			<div class="card border-success mb-3">
				<div class="card-header bg-success">
				<center><h5><b class="font font-text-dark border-white">Recovered:</b>
					<?php
						$stmt = $person->countRecoveredbrgy(); 
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
							echo '<b>'.$row['count'].'</b>';
						}
					?></h5>
				</div>
				<div>
					<center><h5><a href="viewBrgyRecovered" class="text-success btn-link"><i>view</i></a></h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card border-danger mb-3">
				<div class="card-header bg-danger">
				<center><h5><b class="font font-text-dark border-white">PUI:</b>
				<?php
					$stmt = $person->countPUIbrgy(); 
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
						echo '<b>'.$row['count'].'</b>';
					}
				?></h5>
				</div>
				<div>
					<center><h5><a href="viewBrgyPUI" class="text-danger btn-link"><i>view</i></a></h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card border-warning mb-3">
				<div class="card-header bg-warning">
				<center><h5><b class="font font-text-dark border-white">PUM:</b>
				<?php
					$stmt = $person->countPUMbrgy(); 
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
						echo '<b>'.$row['count'].'</b>';
					}
				?></h5>
				</div>
				<div>
					<center><h5><a href="viewBrgyPUM" class="text-warning btn-link"><i>view</i></a></h5>
				</div>
			</div>
		</div>
		<div class="col">
		<div class="card border-dark mb-3 text-white">
				<div class="card-header bg-dark">
				<center><h5><b class="font font-text-white">Deceased:</b>
				<?php
					$stmt = $person->countDeceasedbrgy(); 
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
						echo '<b>'.$row['count'].'</b>';
					}
				?></h5>
				</div>
				<div>
					<center><h5><a href="viewBrgyDeceased" class="text-dark btn-link"><i>view</i></a></h5>
				</div>
			</div>
		</div>
	</div>

    
	<div class="row">			
		<div class="col-sm-6">    
			<div class="card border-primary mb-5" style="border-radius:20px;">
				<div class="card-header">Search ID</div>
					<div class="card-body text-primary">
					<h5 class="card-title">ID no.</h5>
					<input type="text" name="search_text" id="search_text" placeholder="Search ID....." class="form-control" />				
				</div>
			</div>
		</div>
		<div class="col-sm-5">    
			<p>
			<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				Add Person
			</button>
			</p>
			<div class="card">
			<div class="card-header" id="headingOne">
			<h5 class="mb-0">
				<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				List of person
				</button>
			</h5>
			</div>
		</div>
	</div>

	<script>
	$(document).ready(function(){
		$('#search_text').keyup(function(){
			var txt = $(this).val();
			if(txt != '')
			{
				$.ajax({
					url:"peoplelistajax.php",
					method:"POST",
					data:{search:txt},
					datatype:"text",
					success:function(data)
					{
						$('#result').html(data);
					}
				});
			}
			else
			{
				$('#result').html('');  
			}
		});
	});
	</script>

	<!--Jumbotron Collapes Search person-->
	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<div id="result"></div>
					

			<div class="collapse" id="collapseExample">
				<div class="card card-body" style="border-radius:20px;">
					<form method="POST" action="personAdd" enctype="multipart/form-data">
						<div class="jumbotron bg-secondary" style="border-radius:20px;">
								<h2>Add Person</h2>
								<p class="text-danger"><small>* are shown as required.</small></p>
								<hr>
							<div class="row">
								<div class="col-md-4">
									<label>First Name*</label>
									<input type="text" class="form-control" name="firstname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
								</div>
								<div class="col-md-4">
									<label>Middle Name</label>
									<input type="text" class="form-control" name="middlename" pattern="[A-Za-z\s]{3,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
								</div>
								<div class="col-md-4">
									<label>Last Name*</label>
									<input type="text" class="form-control" name="lastname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>'required>
								</div>			
							</div><br>
							<div class="row">
								<div class="col-md-6">
									<label>Contact Number*</label>
									<input type="text" class="form-control" pattern=".{11,}" title="Please enter a valid contact number which contains 11 numbers." name="contactno" value='<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : '' ?>' required>
								</div>
								<div class="col-md-6">
									<label>Gender*</label>
									<select class="custom-select" name = "gender" required>
									<option selected></option>
									<option value="Female">Female</option>
									<option value="Male">Male</option>
									</select>
								</div>
							</div><br>
							<div class="row">
								<div class="col-sm-12">
									<label>Address*</label>
									<textarea class="form-control" name="address" pattern="[A-Za-z]{3,}" title="3 or more letters required" required><?php echo isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>
								</div>
							</div><br>
							<hr>
							<input type="submit" name="submit" class="btn btn-primary" value="Create">
							<a href="viewlist" class="btn btn-danger" data-dismiss="modal">Back</a>
						</div>	      	
					</form>
				</div>
			</div>

			<div id="accordion">
				<div class="card">
					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							<table id="tblpeople" class="table table-bordered" cellspacing="0">
								<thead class="thead-light">
									<tr>
									<th>Person ID</th>
									<th scope="col">Full Name</th>
									<th scope="col">Gender</th>
									<!--<th scope="col">Contact Number</th>-->
									<th scope="col">Address</th>
									<th scope="col">Listed By</th>
									<th scope="col">Barangay from</th>
									<th scope="col">Date Added</th>
									<th scope="col">Current Status</th>
									<th scope="col">Action</th>
									</tr>
								</thead>
							<tbody>
							<?php
								$stmt = $person->readallpeople();
								while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									extract($row);
									echo '
									<tr>
									<th scope="row"><center>'.$row['pid'].'<br><a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn-link text-dark"><i class="far fa-id-badge">Print ID</i></a></center></th>
									<td>'.$row['fullname'].'</td>
									<td>'.$row['gender'].'</td>
									
									<td>'.$row['address'].'</td>
									<td>'.$row['addedby'].'</td>
									<td><b>'.$row['barfrom'].'</b></td>
									<td>'.$row['daterecorded'].'</td>
									<td>';
									if($row['personStatus'] == 'Recovered'){
										echo '<p class="text-success"><b>Recovered</b></p>';
									}
									elseif($row['personStatus'] == 'PUM'){
										echo '<p class="text-warning"><b>PUM</b></p>';
									}
									elseif($row['personStatus'] == 'PUI'){
										echo '<p class="text-danger"><b>POSITIVE</b></p>';
									}
									elseif($row['personStatus'] == 'Deceased'){
										echo '<p class="text-dark"><b>DECEASED</b></p>';
									}
									echo '</td>
									<td>
										';
										if($row['personStatus'] == 'PUI'){
											echo '
												<input type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" value="&#10133"/>
												<input type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'" value="✍View"/>
												<input type="button" class="btn btn-warning btn-sm trace-object" trace-id="'.$row['pid'].'" value="Trace"/>

											';
										}
										else if($row['personStatus'] == 'Deceased'){
											echo '
											<input type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'" value="✍View"/>
										';
										}

										else {
											echo '
											<div class="btn-group" role="group" aria-label="Basic example">
												<input type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" value="&#10133"/>
												<input type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'" value="✍View"/>
											</div>
											';
										}					  
										echo '
																		
									</td>	      		  
										}
									</tr>';
								}
								echo '
								</tbody>
								</table>';
							?>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</div>


<script src="../../assets/chartjs/chart.js"></script>
<script src="../../assets/chartjs/chartjs-plugin-colorschemes.js"></script>


<!--ADD RECORD for APOR/PUM/PUI/LSI MODAL-->
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel">Add Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-secondary" id="addRecordContent">
		
      </div>


    </div>
  </div>
</div>
<!--View RECORD of Person-->
<div class="modal fade" id="recordPerson" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel"> Records of Person</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-secondary" id="addRecordContent2">
		
      </div>


    </div>
  </div>
</div>
<!--Datepicker for Trace-->
<div class="modal fade" id="tracemodal" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel"> Trace Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-secondary" id="addRecordContent3">
		
      </div>


    </div>
  </div>
</div>




<!-- Change Modal Width of view record -->
<style>
	.modal-lg {
		max-width: 90%;
	}
</style>

<script>
//script for APOR/PUM/PUI/LSI
$(document).on('click', '.edit-object', function(){
    var pid = $(this).attr("edit-id");
  
    $.ajax({
		url:'addRecord.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent').html(data);
		  $('#addRecord').modal('show');
		}
    });
});
//script for View Records
$(document).on('click', '.record-object', function(){
    var pid = $(this).attr("record-id");
  
    $.ajax({
		url:'viewrecord.php',
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent2').html(data);
		  $('#recordPerson').modal('show');
		}
    });
});

//script for tracing date
$(document).on('click', '.trace-object', function(){
    var pid = $(this).attr("trace-id");
  
    $.ajax({
		url:'tracedate.php',
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent3').html(data);
		  $('#tracemodal').modal('show');
		}
    });
});

//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
	 var table = $('#tblpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "asc" ]],
    } );
} );
</script>
<div class="container">
<?php
	include_once 'graph.php';
?>
</div>
<?php
	include_once '../include/footer.php';
?>