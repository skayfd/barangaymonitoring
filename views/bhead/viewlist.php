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
	include_once '../../classes/person.php';
	include_once '../../classes/barangay.php';

	$person = new Person($db);
	$barangay = new Barangay($db);
?>
<br>
<div class="container">
	<center>
	<a href="viewgroup" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Dashboard</a>
	<br><br>
	</center>
	<div class="row">
		<div class="card-header container-fluid bg-light">
			<div clas="col-md-6 float-left">
				<h1 class="display-4 text-dark"><i class="fas fa-list-ul"></i> Listed People</h1>
				<a  type="button" href="personAdd" class="btn btn-success"><i class="far fa-plus-square"></i> Add Person</a>
			</div>
		</div>
	</div>
	<div class="row bg-light">
		<div class="container">
			<!-- <td>
				<label class="control-label text-dark" for="NewPass">Specific Barangay: </label>
				<input type="text" id="search-barangay" placeholder="Search Barangay">
			</td> -->

			<table id="tblpeople" class="table table-hover table-bordered" cellspacing="0">
			  <thead class="thead-light">
			    <tr>
			   	  <th scope="col">Person ID</th>
			      <th scope="col">Full Name</th>
			      <th scope="col">Gender</th>
			      <th scope="col">Contact Number</th>
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
			      <th scope="row"><center>'.$row['pid'].'<br><a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn btn-warning btn-sm"><i class="far fa-id-badge"></i> Create ID</a></center></th>
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
			      	<div class="btn-group" role="group" aria-label="Basic example">
					  <input type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" value="Add Record"/>
					  <input type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'" value="View Records"/>
					</div>			      			      	
	      		  </td>	      		  
			    </tr>';
			  }
			echo '
			  </tbody>
			</table>';
			?>
			
			<br>
		</div>
	</div><br>
</div>
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

<!-- Change Modal Width -->
<style>
.modal-lg {
    max-width: 130%;
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




//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
	 var table = $('#tblpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],
    } );

} );
</script>
<?php
	include_once '../include/footer.php';
?>