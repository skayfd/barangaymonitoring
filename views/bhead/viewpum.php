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
	include_once '../include/sidebar/viewpum.php';
	include_once '../../classes/person.php';
	include_once '../../classes/barangay.php';
	include_once '../../classes/record.php';

	$person = new Person($db);
	$barangay = new Barangay($db);
	$record = new Record($db);

?>
<br>


<div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h1><b>PUM</b></h1></div>
                    <div class="col-sm-4">
                        
						</div>
                </div>
            </div>

			<table id="tblpeople" class="table table-bordered" >
			  <thead>
			    <tr>
			   	  <th style="width: 20px;">ID</th>
			      <th>Full Name</th>
			      <th>Gender</th>
			      <th>Contact Number</th>
			      <th>Address</th>
			      <th>Listed By</th>
			      <th>Point of<br>Origin</th>
			      <th>Date Quarantined</th>
			      <th style="max-width: 7rem;">Days of <br>Quarantine</th>

			      <th>Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			  $stmt = $person->readallPUM();
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
			      <td>'.$row['datequar'].'
				  <a class="btn btn-sm btn-dark" href="editdatequar.php?pid='. $row['pid'] .'" title="Update Record" data-toggle="tooltip"><span data-feather="edit"></span></a></td>
			      <td>';
			      //number of days quarantined
			      if($row['days'] >= 14){
					date_default_timezone_set("Asia/Manila");
					$person->pid = $row['pid'];
					$person->datequar = date("Y-m-d h:i:s");
					
					$record->reason = 'Changed Status to Recovered';
					$record->healthStatus = 'Recovered';
					$record->addressto2 = ' ';
					$record->status = ' ';
					$record->temp = '  ';
					$record->pointoforigin = ' ';
					$record->addressto = ' ';
					$record->addressto3 = ' ';
					$record->daterecorded = date("Y-m-d h:i:s");
					$record->timeout1 = date("Y-m-d h:i:s ");
					$record->pid = $row['pid'];

					$person->personStatus2();
					$record->createRecord();
			      	echo '<p class="text-success"><b>Finished Self Quarantine</b></p>';

			      }
			      else {
			      	echo "<center><b><p class='text-info'>".$row['days']."</p></b></center>";
			      }
			      //quarantined by
			      $person->pid = $row['pid'];
			      $stmt2 = $person->readQuarBy();
			      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			      	extract($row2);
			      	
			      }

	      		  echo '
	      		  <td>
					<input type="button" class="btn btn-danger btn-sm edit5-object" edit5-id="'.$row['pid'].'" value="Mark as Positive"/>
					</td>
			    </tr>';
			  }
			echo '
			  </tbody>
			</table>';
			?>

		</div>
	</div><br>
<!--<input type="button" class="btn btn-secondary btn-sm time2-object" time2-id="'.$row['pid'].'" value="Change Date"/>-->
<!--ADD RECORD for APOR/PUM/PUI/LSI MODAL-->
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRecordLabel">Add Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body" id="addRecordContent">
		
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
<!--datepicker for change date-
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel"> Change Date</h5>
      </div>
      <div class="modal-body bg-white" id="addRecordContent3">
		
      </div>
    </div>
  </div>
</div>-->
<!--MODAL for Timepickert-->
<div class="modal fade" id="addTime" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel">Change Date</h5>
      </div>
      <div class="modal-body bg-white" id="timepicker">

      </div>


    </div>
  </div>
</div>


<script>
//script for APOR/PUM/PUI/LSI
$(document).on('click', '.edit-object', function(){
    var pid = $(this).attr("edit-id");
  
    $.ajax({
		url:'viewpppum.php',
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

//script for time change
$(document).on('click', '.time2-object', function(){
    var pid = $(this).attr("time2-id");
  
    $.ajax({
		url:'changeDatequar.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  $('#addTime').modal('show');
		  $('#timepicker').html(data);
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
		"order": [[ 7, "desc" ]],

    } );

/** 
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
	
	//change Date1
$(document).on('click', '.edit8-object', function(){
    var pid = $(this).attr("edit8-id");
	var dateChange = $(this).attr("edit9-object");
	var r = confirm("Are you sure you want to update the date?");
	if (r == true) {
    $.ajax({
		url:'changeDatequar.php',
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
});*/ 
} );
</script>
<?php
	include_once '../include/footer.php';
?>