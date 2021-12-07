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
	<div class="card"><br>
		<div class="row">
			<div class="col-sm-4">
				<h4 class="text-success"><?php echo $person->firstname."'s Records"; ?></h4>
			</div>
			<div class="col-sm-4">
				<h4 class="text-warning"><?php echo "Person ID: ".$person->pid; ?></h4>
			</div>
			<div class="col-sm-4">
				<?php
					echo '
					<input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$person->pid.'" value="Mark as PUM"/>
					<input type="button" class="btn btn-danger btn-sm edit5-object" edit5-id="'.$person->pid.'" value="Mark as PUI"/>';
				?>			
			</div>
		</div><br>
		<table id="tblRecord" class="table table-responsive table-light">
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
		      <th scope="col">Valid ID</th>
		      <th scope="col">Brgy Cert</th>
		      <th scope="col">Hlth Decl.</th>
		      <th scope="col">Med Certificate</th>
		      <th scope="col">Travel Auth</th>
		      <th scope="col">Action</th>
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

		      //check time out and time in
		      if(empty($row['timeout'])){
		      	echo '
		      	<th scope="row">
		      		<a class="btn btn-success text-light time-object" time-id="'.$row['rid'].'">Time Out</a><hr>
		      		<input type="button" class="btn btn-secondary btn-sm time2-object" time2-id="'.$row['rid'].'" value="Manual TO"/>
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

		      <td>'.$row['fullname'].'</td>';

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
		      <td>
		      	<a class="btn btn-warning text-dark delete-object" delete-id="'.$row['rid'].'">Archive</a>
		      </td>
		    </tr>';
			}
		    ?>
		  </tbody>
		</table>
	</div>
<!--MODAL for Timepickert-->
<div class="modal fade" id="addTime" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
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
   position: absolute;
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
    $('#tblRecord').dataTable( {
    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	"bLengthChange": true,
	"bInfo" : true,
	"order": [[ 0, "desc" ]],
    } );
} );

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
		data:{rid:rid},
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
// //script for marking resident as a COVID positive patient
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
</script>
<?php
	include_once '../include/footer.php';
?>