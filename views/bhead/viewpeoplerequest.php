<?php
	session_start();
	$title = "Barangay Staff";
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
	include_once '../../classes/barangay.php';

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
	<h1 class="display-4">Barangay Account Requests</h1><br>
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
		  ';
		  $stmt = $barangay->readPeopleRequests();
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		  <tbody>
		    <tr>
		      <th scope="row">'.$row['fullname'].'</th>
		      <td>'.$row['email'].'</td>
		      <td>
		      	<button class="btn btn-success check-object" check-id="'.$row['uid'].'" name="check">
					Accept to Group
				</button>
				<a class="btn btn-danger text-white delete-object" delete-id="'.$row['uid'].'">Ignore</a>
		      </td>
		    </tr>
		  </tbody>';
		}
		echo '
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
    var q = confirm("Confirm?");
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
$(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    var q = confirm("Are you sure?");
     
    if (q == true){
        $.post('userIgnore.php', {
            uid: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to delete.');
        });
    }
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