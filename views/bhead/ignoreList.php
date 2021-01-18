<?php
	session_start();
	$title = "View Group";
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
	include_once '../../classes/user.php';

	$barangay = new Barangay($db);
?>
<br>
<div class="container">
	<center>
	<a href="viewgroup?id=
	<?php $stmt = $barangay->readrelatedGroup(); 
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row); 
		echo md5($row['referral']);
	} 
	?>" class="btn btn-danger btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Group Panel</a>
	<br><br>
	<h1 class="display-4">Ignored Accounts</h1><br>
	</center>

	<div class="row">		
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
		<div class="jumbotron">
		<?php
		echo '
		<table id="tblRequest" class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Name</th>
		      <th scope="col">Email Address</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>';
		  $stmt = $barangay->readIgnoredRequests();
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		    <tr>
		      <th scope="row">'.$row['fullname'].'</th>
		      <td>'.$row['email'].'</td>
		      <td>
		      	<button class="btn btn-success check-object" check-id="'.$row['uid'].'" name="check">
					Accept to Group
				</button>
		      </td>
		    </tr>'; 
		}
		echo '
			</tbody>
		</table>';
		?>
		</div>
		</div>
		<div class="col-md-2">
		</div>
	</div>
</div>
<script>
$(document).on('click', '.check-object', function(){
    var uid = $(this).attr("check-id");
    var q = confirm("Confirm User to group?");
      if(q == true){
        $.post('confirmuser.php', {
          uid: uid
        }, function(data){
          location.reload();
        }).fail(function() {
          alert("Something Went Wrong, Unable to Confirm");
        });
      }
      return false;
});
$(document).ready(function() {
    $('#tblRequest').dataTable( {
    "aLengthMenu": [[3, 8, -1], [3, 8, "All"]],
    "pageLength": 3,
	"bLengthChange": true,
	"bInfo" : true,
    } );

} );
</script>
<?php
	include_once '../include/footer.php';
?>