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

	$person = new Person($db);

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
				<h1 class="display-4 text-dark">Listed People</h1>
				<a  type="button" href="personadd" class="btn btn-success"><i class="far fa-plus-square"></i> Add Person</a>
			</div>
		</div>
	</div>
	<div class="row bg-light">
		<div class="container">
			<?php
			$stmt = $person->readallpeople();
			echo '
			<table id="tblpeople" class="table table-hover table-bordered">
			  <thead class="thead-light">
			    <tr>
			      <th scope="col">Full Name</th>
			      <th scope="col">Gender</th>
			      <th scope="col">Contact Number</th>
			      <th scope="col">Address</th>
			      <th scope="col">Listed By</th>
			      <th scope="col">Date Added</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>';
			  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo '
			    <tr>
			      <td>'.$row['fullname'].'</td>
			      <td>'.$row['gender'].'</td>
			      <td>'.$row['contactno'].'</td>
			      <td>'.$row['address'].'</td>
			      <td>'.$row['addedby'].'</td>
			      <td>'.$row['daterecorded'].'</td>
			      <td>
			      	<input type="button" class="btn btn-success edit-object" edit-id="'.$row['pid'].'" value="Add Record"/>
			      	<a href="viewrecordlist?id='.$row['pid'].'" class="btn btn-info">View Records</a>
					<a class="btn btn-warning text-dark delete-object" delete-id="'.$row['pid'].'">Archive</a>
	      		  </td>
			    </tr>';
			  }
			echo '
			  </tbody>
			</table>';
			?><br>
		</div>
	</div><br>
</div>
<!--ADD RECORD MODAL-->
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

<script>
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

//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
    $('#tblpeople').dataTable( {
    "aLengthMenu": [[3, 8, -1], [3, 8, "All"]],
    "pageLength": 3,
	"bLengthChange": true,
	"bInfo" : true,	
    } );

} );
//delete person
$(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    var q = confirm("Are you sure?");
     
    if (q == true){
        $.post('personDelete.php', {
            pid: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to delete.');
        });
    }
});
</script>
<?php
	include_once '../include/footer.php';
?>