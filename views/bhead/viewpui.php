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
	<a href="viewgroup" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Group Panel</a>
	<br><br>
	</center>
	<div class="row">
		<div class="card-header container-fluid bg-light">
			<div clas="col-md-6 float-left">
				<h1 class="display-4 text-dark"><i class="fas fa-procedures text-danger"></i> Listed PUIs</h1>
				<a  type="button" href="personAdd" class="btn btn-success"><i class="far fa-plus-square"></i> Add Person</a>
			</div>
		</div>
	</div>
	<div class="row bg-light">
		<div class="container table-responsive overflow-auto">
			<!-- <td>
				<label class="control-label text-dark" for="NewPass">Specific Barangay: </label>
				<input type="text" id="search-barangay" placeholder="Search Barangay">
			</td> -->

			<table id="tblpeople" class="table table-hover compact nowrap table-bordered" cellspacing="0">
			  <thead class="thead-light">
			    <tr>
			   	  <th scope="col">Person ID</th>
			      <th scope="col">Full Name</th>
			      <th scope="col">Gender</th>
			      <th scope="col">Contact Number</th>
			      <th scope="col">Address</th>
			      <th scope="col">Listed By</th>
			      <th scope="col">Barangay from</th>
			      <th scope="col">Date Quarantined</th>
			      <th scope="col">Marked Positive by</th>
			      <th scope="col">Change Status</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			  $stmt = $person->readallPUI();
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
			      <td>'.$row['datequar'].'</td>';
			      //quaratined by
			      $person->pid = $row['pid'];
			      $stmt2 = $person->positiveBy();
			      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			      	extract($row2);
			      	echo '
			      	<td>'
				    	.$row2['markedby']. 	
		      		'</td>';
			      }
	      		  echo '
	      		  <td>
					<input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$row['pid'].'" value="Mark as PUM"/><hr>
					<input type="button" class="btn btn-success btn-sm edit4-object" edit4-id="'.$row['pid'].'" value="Change status to Cleared"/>
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
<!--ADD RECORD for Local Resident-->
<div class="modal fade" id="addRecord2" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel"> Add Record for Resident</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-secondary" id="addRecordContent2">
		
      </div>


    </div>
  </div>
</div>



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
$(document).on('click', '.edit2-object', function(){
    var pid = $(this).attr("edit2-id");
  
    $.ajax({
		url:'addRecord2.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent2').html(data);
		  $('#addRecord2').modal('show');
		}
    });
});
//script for marking PUI
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
//script for marking changing to resident
$(document).on('click', '.edit4-object', function(){
    var pid = $(this).attr("edit4-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick2.php',
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
//script for marking resident as a COVID positive patient
$(document).on('click', '.edit5-object', function(){
    var pid = $(this).attr("edit5-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick3.php',
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




//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
	 var table = $('#tblpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],
		"sDom":"ltipr"
    } );


    // Setup - add a text input to each footer cell
    $('#tblpeople thead tr').clone(true).appendTo( '#tblpeople thead' );
    $('#tblpeople thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();

        $(this).html( '<input type="text" class="form-control input-sm" placeholder="Search '+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );


    } );
} );
</script>
<?php
	include_once '../include/footer.php';
?>