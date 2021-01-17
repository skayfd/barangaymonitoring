<?php
	session_start();
	$title = "Records";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
	include_once '../include/header.php';
	include_once '../../classes/record.php';

	$record = new Record($db);
	//$pid = $_GET['id'];
?>
<div class="container">&nbsp
	<center>
	<a href="viewpeoplelist" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a>
	<br>
		<h1 class="display-4">Records</h1>
	</center>

	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
		<div class="jumbotron">
		<?php
		echo '
		<table id="tblRecord" class="table table-hover table-bordered table-light">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Date Recorded</th>
		      <th scope="col">Reason</th>
		      <th scope="col">Temperature</th>
		      <th scope="col">Person Type</th>
		      <th scope="col">Recorded By</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  	 <tbody>';
		  $record->pid = $_GET['id'];
		  $stmt = $record->readrelatedRecord();
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		    <tr>
		      <th scope="row">'.$row['date'].'</th>
		      <td>'.$row['reason'].'</td>
		      <td>'.$row['temp'].'</td>
		      <td>'.$row['status'].'</td>
		      <td>'.$row['fullname'].'</td>
		      <td>
		      	<a class="btn btn-danger text-white delete-object" delete-id="'.$row['rid'].'">Delete</a>
		      </td>
		    </tr>';
		  }
		echo '
			</tbody>
		</table>';
		?>
		</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#tblRecord').dataTable( {
    "aLengthMenu": [[3, 8, -1], [3, 8, "All"]],
    "pageLength": 3,
	"bLengthChange": true,
	"bInfo" : true,	
    } );

});
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

</script>
<?php
	include_once '../include/footer.php';
?>