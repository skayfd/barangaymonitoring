<?php
	session_start();
	$title = "Records";
	$id = $_GET['id'];
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
	include_once '../../classes/record.php';
	include_once '../../classes/person.php';


	$record = new Record($db);
	$person = new Person($db);



?>
&nbsp
	<center>
	<a href="viewlist" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a>
	<br>
		<h1 class="display-4">Records of Person</h1>

	</center>
	<div class="card"><br>
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
		  	$record->pid = $_GET['id'];
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
		</table>&nbsp
	</div>
<!--MODAL for Timepickert-->
<div class="modal fade" id="addTime" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel"> Manual Time Out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
</script>
<?php
	include_once '../include/footer.php';
?>