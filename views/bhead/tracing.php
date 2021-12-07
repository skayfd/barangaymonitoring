<?php
	session_start();
	$title="Tracing";
	include_once '../include/header.php';
	include_once '../include/sidebar.php';
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		header("Location: ../bmember/memhome.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}

	$database = new Database();
	$db = $database->getConnection();

	$person = new Person($db);
	$record = new Record($db);

?>
<br>
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
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				Add other contact
			</button>
			</div>
		</div>
  </div>
  <div class="col-9">
  <table id="tpeople" class="table table-bordered table-sm">
  <thead>
          <tr>
		  <th scope="col">ID</th>
					<th scope="col">Full Name</th>
					<th scope="col">Date Recorded/Time In</th>
					<th scope="col">Barangay Recorded In</th>
					<th scope="col">Address</th>
					<th scope="col">Point of Origin</th>
					<th scope="col">Destination</th>
					<th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
			<?php
				if(isset($_GET['from_date']) && isset($_GET['to_date']))
				{
					if(strtotime($_GET['from_date']) < strtotime($_GET['to_date']))
					{
					$from_date = $_GET['from_date'];
					$date = new DateTime($_GET['to_date']);
					$date->modify('+1 day');
	    			$to_date   = $date->format('Y-m-d');;
					$pid = $_GET['id'];
					// Create database connection 
					$con = mysqli_connect("localhost","root", "","monitoring"); 
					
					$query = "SELECT person.pid AS 'personid', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'daterecorded', record.timeout AS 'tout', record.reason AS 'reason', record.status AS 'status', person.contactno AS 'contactno', record.pointoforigin AS 'porigin', record.addressto AS 'destination', person.address AS 'address', person.gender AS 'gender', barangay.brgyname AS 'barname' FROM record INNER JOIN person ON record.pid = person.pid INNER JOIN user ON user.uid = record.uid INNER JOIN barangay ON barangay.referral = user.referral WHERE person.pid != '$pid' AND person.personStatus != 'PUM' AND person.personStatus!= 'PUI' AND person.personStatus !='Deceased' AND record.daterecorded BETWEEN '$from_date' AND '$to_date'";
					$query_run = mysqli_query($con, $query);
					if(mysqli_num_rows($query_run) > 0)
					{
						foreach($query_run as $row)
						{
							?>
								<?php
									
									echo '
									<tr>
									<th>'.$row['personid'].'</th>
									<td>'.$row['fullname'].'</td>
									<td>'.$row['daterecorded'].'</td>
									<td>'.$row['barname'].'</td>
									<td>'.$row['address'].'</td>
									<td>'.$row['porigin'].'</td>
									<td>'.$row['destination'].'</td>
									<td>
										<input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$row['personid'].'" value="Mark as PUM"/>
									</td>
									</tr>';
									
									?>
									
							<?php
						}
					}
					else
					{
						echo "<div class='alert alert-danger' role='alert'>
								No Record Found!
							</div>";
					}
					}
					else
					{
						echo "<div class='alert alert-danger' role='alert'>
								Please Correct your date!
							</div>";
					}
				}	
			?>
        </tbody>
      </table>
  </div>
</div>

			</p>
			<div class="row">
			<div class="col-md-5">
        <div class="collapse" id="collapseExample">
				<div class="card card-body" style="border-radius:20px;">
					<form method="POST" action="addPUMResident" enctype="multipart/form-data">
						<div style="border-radius:20px;">
								<h4>Add PUM</h4>
								<p class="text-danger"><small>* are shown as required.</small></p>
								<hr>
							
								<div>
									<label>First Name*</label>
									<input type="text" class="form-control" name="firstname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
								</div>
								<div>
									<label>Middle Name</label>
									<input type="text" class="form-control" name="middlename" pattern="[A-Za-z\s]{3,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
								</div>
								<div>
									<label>Last Name*</label>
									<input type="text" class="form-control" name="lastname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>'required>
								</div>			
							
								<div>
									<label>Contact Number*</label>
									<input type="text" class="form-control" pattern=".{11,}" title="Please enter a valid contact number which contains 11 numbers." name="contactno" value='<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : '' ?>' required>
								</div>
								<div>
									<label>Gender*</label>
									<select class="custom-select" name = "gender" required>
									<option selected></option>
									<option value="Female">Female</option>
									<option value="Male">Male</option>
									</select>
								</div>
							
								<div>
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
//script for making person PUM
$(document).on('click', '.edit3-object', function(){
    var pid = $(this).attr("edit3-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  window.location.reload();
		  alert("Status Updated");
		}
    });}
	else{
		window.alert("Status update cancelled");
	}
});
/*
	if($_POST){
		$person->date = $from_date;
		$person->pid = $_GET['id'];
		$stmt = $person->specPersonTrace($person->date, $person->pid);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			$rdate = $row['dates'];
			$rdest = $row['Destination'];
			$rowrayDate = explode(',',$rdate);
			$rowrayDest = explode(',',$rdest);
			// print_r($rowrayDate);
			echo "
			<br>
			<center><h3>Selected Date: <u class='text-warning'>".$from_date."</u></h3></center>
			<center>
			<div class='card float-left mx-auto' style='width: 16rem;'>
			  <div class='card-body'>
			    <h3 class='card-title text-dark'>".$row['Name']."</h3><hr>
			    <h5 class='text-dark'>Hours Recorded: </h5>
			    <p class='card-text text-dark'>"; 
			    foreach($rowrayDate AS $dateper){
			    	echo ">".$dateper."<br>";
			    }
			    echo "</p>
			    <hr>
			    <h5 class='text-dark'>Destinations: </h5>
			    <p class='card-text text-dark'>"; 
			    foreach($rowrayDest AS $datedest){
			    	echo ">".$datedest."<br>";
			    }
			    echo "</p>
			  </div>
			</div>
			</center><br>
			";
		}
		//place people on current date here, not automatic but sees date
		$stmt2 = $person->PersonTrace($person->date, $person->pid);
		while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			extract($row2);
			$rdate = $row2['dates'];
			$rdest = $row2['Destination'];
			$rnames = $row2['names'];

			$rowrayDate = explode(',',$rdate);
			$rowrayDest = explode(',',$rdest);
			$rowrayNames = explode(',',$rnames);

			$rowDateDest = array_combine($rowrayDate,$rowrayDest);
			
			//print_r($rowDateDest);

			// foreach($rowrayNames AS $name){
			foreach(array_combine($rowrayNames, $rowDateDest) as $name => $datedest){
				
					echo "
					<div class='container'>
					<div class='row'>
						<div class='gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe'>
							<div class='card' style='width: 14rem;'>
							  <div class='card-body'>
							    <h5 class='card-title text-dark'>".$name."</h5>
							    <h5 class='card-title text-dark'>";
							    echo $datedest;//display date and time
							    echo "
							    </h5>
							  </div>
							</div><br>
						</div><br>
					</div>
					</div>
					";
				
			}
		}
	}*/
</script>
<?php
	include_once '../include/footer.php';
?>


