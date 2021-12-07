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
	include_once '../include/sidebar/viewlist.php';
	include_once '../../classes/person.php';
	include_once '../../classes/barangay.php';

	$person = new Person($db);
	$barangay = new Barangay($db);
?>



	<!--<div class="row">
		<div class="card-header container-fluid bg-light">
			<div clas="col-md-6 float-left">
				<h1 class="text-dark"><i class="fas fa-list-ul"></i> Peolpe</h1>
				<a  type="button" href="personAdd" class="btn btn-success"><i class="far fa-plus-square"></i> Add Person</a>
			</div>
		</div>
	</div>
<<<<<<< HEAD
	<div class="row bg-light">-->


    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h1><b>People in All Barangay</b></h1></div>
                    <div class="col-sm-4">
					<a type="button" class="btn btn-info add-new" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
=======
	<div class="row bg-light">
		<div class="container">
			<!-- <td>
				<label class="control-label text-dark" for="NewPass">Specific Barangay: </label>
				<input type="text" id="search-barangay" placeholder="Search Barangay">
			</td> -->
>>>>>>> parent of 3ffc982 (new ui)

			<table id="tblpeople" class="table table-hover table-bordered" cellspacing="0">
			  <thead>
			    <tr>
			   	  <th style="width: 20px;">ID no.</th>
			      <th style="width: 100px;">Full Name</th>
			      <th style="width: 35px;">Gender</th>
			      <th>Contact #</th>
			      <th>Address</th>
			      <th>Listed By</th>
			      <th>Barangay from</th>
			      <th>Date Added</th>
			      <th>Current Status</th>
			      <th>Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			  $stmt = $person->readallpeople();
			  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo '
			    <tr>
				  <td>'.$row['pid'].'</td>
			      <td>'.$row['fullname'].'</td>
			      <td>'.$row['gender'].'</td>
			      <td>'.$row['contactno'].'</td>
			      <td>'.$row['address'].'</td>
			      <td>'.$row['addedby'].'</td>
			      <td><b>'.$row['barfrom'].'</b></td>
			      <td>'.$row['daterecorded'].'</td>
			      <td>';
			      if($row['personStatus'] == 'Cleared'){
			      	echo '<p class="text-success"><b>CLEARED</b></p>';
			      }
			      elseif($row['personStatus'] == 'PUM'){
			      	echo '<p class="text-warning"><b>PUM</b></p>';
			      }
			      elseif($row['personStatus'] == 'COVID Positive'){
			      	echo '<p class="text-danger"><b>POSITIVE</b></p>';
			      }
			      echo '</td>
			      <td>
<<<<<<< HEAD
			      	';
			      	if($row['personStatus'] == 'PUI'){
			      		echo '
			      			<div class="btn-group" role="group" aria-label="Basic example">
							  <button type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" ><span data-feather="user-plus"></span></button>
							  <button type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'"><span data-feather="eye"></span></button>	
							  <a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn-warning btn-sm"><span data-feather="printer"></span></a>
					  		</div>
					  	<center>
						  <button type="button" class="btn btn-warning btn-sm trace-object" trace-id="'.$row['pid'].'"><span data-feather="search"></span>Trace</button>
					  	
					  	</center>
			      		';
			      	}
			      	else if($row['personStatus'] == 'Deceased') {
			      		echo '
			      		<div class="btn-group" role="group" aria-label="Basic example">
						  <button type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'"><span data-feather="eye"></span></button>	
						  <button type="button" class="btn btn-dark btn-sm a-object" a-id="'.$row['pid'].'"><span data-feather="save"></span></button>	
						</div>
			      		';
			      	}
					  else {
						echo '
						<div class="btn-group" role="group" aria-label="Basic example">
						<button type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" ><span data-feather="user-plus"></span></button>
						<button type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'"><span data-feather="eye"></span></button>
						<a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn-warning btn-sm"><span data-feather="printer"></span></a>
						</div>
						';
					}					  
					echo '</td></tr>';
=======
			      	<div class="btn-group" role="group" aria-label="Basic example">
					  <input type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" value="Add Record"/>
					  <input type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'" value="View Records"/>
					</div>			      			      	
	      		  </td>	      		  
			    </tr>';
>>>>>>> parent of 3ffc982 (new ui)
			  }
			echo '
			  </tbody>
			</table>';
			?>
    </div>
</div> 

<!--Add Person Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="personAdd" enctype="multipart/form-data">
						<div style="border-radius:20px;">
								<h4>Add Person</h4>
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
						</div>	      	
					


      </div>
      <div class="modal-footer">
          <input type="submit" name="submit" class="btn btn-primary" value="Create">
		<a href="viewlist" class="btn btn-danger" data-dismiss="modal">Back</a>
      </div>
      </form>
    </div>
  </div>
</div>
<!--ADD RECORD for APOR/PUM/PUI/LSI MODAL
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel">Add Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-white" id="addRecordContent">
		
      </div>


    </div>
  </div>
</div>-->

<div class="modal fade" id="recordPerson" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel">View Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-body bg-white" id="addRecordContent2">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel">Add Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="modal-body bg-white" id="addRecordContent">
			
			</div>
      </div>
    </div>
  </div>
</div>
<!--View RECORD of Person-->
<div class="modal fade" id="recordPerson" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      	<div class="modal-header bg-primary">
			<h5 class="modal-title" id="addRecordLabel"> Records of Person</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="modal-body bg-white" id="addRecordContent2">
			</div>
		</div>
    </div>
  </div>
</div>
<<<<<<< HEAD
<!--Datepicker for Trace-->
<div class="modal fade" id="tracemodal" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel"> Trace Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-white" id="addRecordContent3">
		
      </div>


    </div>
  </div>
</div>
=======
>>>>>>> parent of 3ffc982 (new ui)

<!-- Change Modal Width -->
<style>
.modal-lg {
<<<<<<< HEAD
    max-width: 80%;
}
.modal {
    overflow: hidden;
}
.modal .modal-body {
    height: auto;
    overflow: auto;
}
.modal .modal-fixed {
    position: fixed;
    background-color:white;
=======
    max-width: 130%;
>>>>>>> parent of 3ffc982 (new ui)
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
//script for Resident
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


// //script for marking PUI
// $(document).on('click', '.edit3-object', function(){
//     var pid = $(this).attr("edit3-id");
// 	var r = confirm("Are you sure you want to update the status?");
// 	if (r == true) {
//     $.ajax({
// 		url:'statusClick.php',
// 		method: "POST",
// 		data:{pid:pid},
// 		success:function(data){
// 		  window.location.reload();
// 		  alert("Status Updated");
// 		}
//     });}
// 	else{
// 		window.alert("Status update cancelled");
// 	}
// });
// //script for marking changing to resident
// $(document).on('click', '.edit4-object', function(){
//     var pid = $(this).attr("edit4-id");
// 	var r = confirm("Are you sure you want to update the status?");
// 	if (r == true) {
//     $.ajax({
// 		url:'statusClick2.php',
// 		method: "POST",
// 		data:{pid:pid},
// 		success:function(data){
// 		  window.location.reload();
// 		  alert("Status Updated");
// 		}
//     });}
// 	else{
// 		window.alert("Status update cancelled");
// 	}
// });
// //script for marking resident as a COVID positive patient
// $(document).on('click', '.edit5-object', function(){
//     var pid = $(this).attr("edit5-id");
// 	var r = confirm("Are you sure you want to update the status?");
// 	if (r == true) {
//     $.ajax({
// 		url:'statusClick3.php',
// 		method: "POST",
// 		data:{pid:pid},
// 		success:function(data){
// 		  window.location.reload();
// 		  alert("Status Updated");
// 		}
//     });}
// 	else{
// 		window.alert("Status update cancelled");
// 	}
// });




//script for archiving person
$(document).on('click', '.a-object', function(){
    var pid = $(this).attr("a-id");
	var r = confirm("Are you sure you want to archive this person?");
	if (r == true) {
    $.ajax({
		url:'cascadeArchivePerson.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  window.location.reload();
		  alert("Archiving success");
		}
    });}
	else{
		window.alert("Archiving cancelled");
	}
});

//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
	 var table = $('#tblpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
<<<<<<< HEAD
        "aLengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
=======
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
>>>>>>> parent of 3ffc982 (new ui)
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],
		
    } );
} );
</script>
<?php
	include_once '../include/footer.php';
?>