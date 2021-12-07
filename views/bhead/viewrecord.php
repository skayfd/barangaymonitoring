<?php
	session_start();
	$title = "Records";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
	include_once '../../classes/record.php';
	include_once '../../classes/person.php';
	include_once "../../config/database.php";

	$database = new Database();
	$db = $database->getConnection();
	$record = new Record($db);
	$person = new Person($db);

	$person->pid = $_GET['pid'];
	$person->readspecPerson($person->pid);

?>

		<div class="row">
			<div class="col-sm-12">
			<h5 class="text-dark">&nbsp<?php echo "Person ID : ".$person->pid; ?></h4>
			<h5 class="text-dark">&nbsp<?php echo "Fullname : ".$person->fullname; ?></h4>
				<!-- Button trigger modal -->
			
			
			<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				List of Document
			</button>
			
				<?php
				$person->pid = $_GET['pid'];
				$stmt=$person->readspecPerson2();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
				if($row['personStatus'] == 'Deceased'){
					echo '
					<input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$person->pid.'" value="Mark as PUM" hidden/>
					<input type="button" class="btn btn-danger btn-sm edit5-object" edit5-id="'.$person->pid.'" value="Mark as PUI" hidden/>
					<input type="button" class="btn btn-success btn-sm edit4-object" edit4-id="'.$person->pid.'" value="Mark as Recovered" hidden/>
					<input type="button" class="btn btn-dark btn-sm edit6-object" edit6-id="'.$person->pid.'" value="Mark as Deceased" hidden/>';
				}
				else if($row['personStatus'] == 'PUI'){
					echo '
					<input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$person->pid.'" value="Mark as PUM" />
					<input type="button" class="btn btn-danger btn-sm edit5-object" edit5-id="'.$person->pid.'" value="Mark as PUI" />
					<input type="button" class="btn btn-success btn-sm edit4-object" edit4-id="'.$person->pid.'" value="Mark as Recovered" />
					<input type="button" class="btn btn-dark btn-sm edit6-object" edit6-id="'.$person->pid.'" value="Mark as Deceased"/>';
				}
				else {
					echo '
					<input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$person->pid.'" value="Mark as PUM" />
					<input type="button" class="btn btn-danger btn-sm edit5-object" edit5-id="'.$person->pid.'" value="Mark as PUI" />
					<input type="button" class="btn btn-success btn-sm edit4-object" edit4-id="'.$person->pid.'" value="Mark as Recovered" />';
				}
			}
				?>	
							
			</div>
		</div>

		<div class="collapse" id="collapseExample">
			<div class="card card-body">
				
			<table  class="table table-responsive table-light">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Date Recorded/Time In</th>
		      <th scope="col">Valid ID</th>
		      <th scope="col">Brgy Cert</th>
		      <th scope="col">Hlth Decl.</th>
		      <th scope="col">Med Certificate</th>
		      <th scope="col">Travel Auth</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php
		  	$record->pid = $_GET['pid'];
		  	$stmt = $record->readrelatedRecord();
		  	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		  	echo '
		    <tr>
		      <th scope="row">'.$row['date'].'</th>';

		     //important docus
		      if(empty($row['workingid'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else {
		      	echo '
		      	<td><img src="../../assets/img/'.$row['workingid'].'" width="120px" height="100px"></td>
		      	';
		      }

		      if(empty($row['brgycert'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else {
		      	echo '
		      	<td><img src="../../assets/img/'.$row['brgycert'].'" width="120px" height="100px"></td>
		      	';
		      }
		      if(empty($row['healthdecla'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else {
		      	echo '
		      	<td><img src="../../assets/img/'.$row['healthdecla'].'" width="120px" height="100px"></td>
		      	';
		      }
		      if(empty($row['medcert'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else {
		      	echo '
		      	<td><img src="../../assets/img/'.$row['medcert'].'" width="120px" height="100px"></td>
		      	';
		      }
		      if(empty($row['travelauth'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else {
		      	echo '
		      	<td><img src="../../assets/img/'.$row['travelauth'].'" width="120px" height="100px"></td>
		      	';
		      }		      			  			    

		      echo '
		      
		    </tr>';
			}
		    ?>
		  </tbody>
		</table>

			</div>
			</div>




		<br>
		<table id="tblRecord" class="table table-borderd table-responsive ">
		  <thead class="thead-light">
		    <tr>
		      <th scope="col">Date Recorded/Time In</th>
		      <th scope="col">Time Out</th>
		      <th scope="col">Reason</th>
		      <th scope="col">Temperature</th>
		      <th scope="col">Person Type</th>
		      <th scope="col">Point of Origin</th>
		      <th scope="col">Destination</th>
		      <th scope="col">Destination 2</th>
		      <th scope="col">Destination 3</th>
		      <th scope="col">Recorded By</th>
			  <th scope="col">Health Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php
		  	$record->pid = $_GET['pid'];
		  	$stmt = $record->readrelatedRecord();
		  	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		  	echo '
		    <tr>
		      <th scope="row">'.$row['date'].'</th>';

		      //check time out and time in<input type="button" class="btn btn-secondary btn-sm time2-object" time2-id="'.$row['rid'].'" value="Manual TO"/>
			  
		      if(empty($row['timeout'])){
		      	echo '
		      	<th scope="row">
		      		<a class="btn btn-primary btn-sm text-light time-object" time-id="'.$row['rid'].'">Timeout</a>
		      		
		      	</th>';
		      }
		      else{
		      	echo '<td><p class="text-success">'.$row['timeout'].'</p></td>';
		      }

		      echo '
		      <td>'.$row['reason'].'</td>
		      <td>'.$row['temp'].'</td>
		      <td><b>'.$row['status'].'</b></td>
		      <td>'.$row['point'].'</td>
		      <td>'.$row['addressto'].'</td>';

		      //addressto portion VVVVVVVVVVV
		      if(empty($row['addressto2'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else{
		      	echo '
		      	<td>'.$row['addressto2'].'</td>
		      	';
		      }
		      if(empty($row['addressto3'])){
		      	echo '
		      	<td><p class="text-danger"> <i class="fas fa-times"></i> Empty</p></td>
		      	';
		      }
		      else{
		      	echo '
		      	<td>'.$row['addressto3'].'</td>
		      	';
		      }
		      //addressto portion ^^^^^^^^^^^^
		      echo '

		      <td>'.$row['fullname'].'</td>
			  <td>'.$row['healthStatus'].'</td>';

		      //important docus
		          			  			    

		      echo '
		      
		    </tr>';
			}
		    ?>
		  </tbody>
		</table>

<!--MODAL for Timepickert-->
<div class="modal fade" id="addTime" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel"> Manual Time Out</h5>
        <button type="button" class="close" data-dismiss-modal="modal2" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body bg-secondary" id="timepicker">
      </div>
    </div>
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
.without_ampm::-webkit-datetime-edit-ampm-field {
   		display: none;
	}
	input[type=time]::-webkit-clear-button {
	   -webkit-appearance: none;
	   -moz-appearance: none;
	   -o-appearance: none;
	   -ms-appearance:none;
	   appearance: none;
	   margin: -10px; 
	}
.modal {
   top: 10px;
   right: 100px;
   bottom: 0;
   left: 0;
   z-index: 10040;
   overflow: auto;
   overflow-y: auto;
}
</style>
<script>
//datatables
$(document).ready(function() {
	 var table = $('#tblRecord').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[4, 8, 12, 24, 100, -1], [4, 8, 12, 24, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],

    });
});
//force close timeout modal
$("button[data-dismiss-modal=modal2]").click(function(){
    $('#addTime').modal('hide');
});
//archive record
$(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    var q = confirm("Are you sure?");
     
    if (q == true){
        $.post('recordDelete.php', {
            rid: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to delete.');
        });
    }
});
//time out script
$(document).on('click', '.time-object', function(){
    var id = $(this).attr('time-id');
    var q = confirm("Time Out Record?");
     
    if (q == true){
        $.post('recordTimeOut.php', {
            rid: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to Time Out.');
        });
    }
});
//script for manual timout
$(document).on('click', '.time2-object', function(){
    var rid = $(this).attr("time2-id");
  
    $.ajax({
		url:'timeout.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  $('#timepicker').html(data);
		  $('#addTime').modal('show');
		}
    });
});
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
//script for making person as Recovered
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
// //script for marking resident as a PUI
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

//script for making person as Deceased
$(document).on('click', '.edit6-object', function(){
    var pid = $(this).attr("edit6-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick4.php',
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

//dtTime
$(document).on('click','.smb1-object',function(){
    var dtTime = $(this).attr('sDate');
    $.ajax({
        url:'dateTimepass.php',
        method: 'POST',
        data:{sDate:dtTime},
            success:function(data){
              alert("successful");
        }
    });
});
//stTime
$(document).on('click','.smb1-object',function(){
    var stTime = $(this).attr('stTime');
    $.ajax({
        url:'dateTimepass.php',
        method: 'POST',
        data:{sTime:stTime},
            success:function(data){
              alert("successful2");
        }
    });
});
//edTime
$(document).on('click','.smb1-object',function(){
    var edTime = $(this).attr('edTime');
    $.ajax({
        url:'dateTimepass.php',
        method: 'POST',
        data:{edTime:edTime},
            success:function(data){
              alert("successful3");
        }
    });
});

</script>
