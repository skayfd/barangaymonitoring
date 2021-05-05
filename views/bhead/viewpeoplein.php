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
	$user = new User($db);

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
	<br>
	<h1 class="display-4">Barangay Staff</h1>
	</center>
	<div class="row">	
		<div class="col-md-1">
		</div>
		<div class="col-md-10 bg-light"><br>
		<?php		
		echo '
		<table id="peopleIn" class="table table-light">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Profile Picture</th>
		      <th scope="col">ID</th>
		      <th scope="col">Name</th>
		      <th scope="col">Email Address</th>
		      <th scope="col">Actions</th>
		    </tr>
		  </thead>
		  ';
		  $stmt = $barangay->readPeopleInside();
		  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo '
		  <tbody>
		    <tr>
		      <td>';
		      if($row['profilepic'] == ''){
		      	echo '
		      	<i class="fas fa-user text-dark" style="font-size:150px;"></i>
		      	';
		      }
		      else {
		      	echo '
		      	<img src="../../assets/img/'.$row['profilepic'].'" width="150px" height="150px">
		      	';
		      }
		      echo '
		      </td>
		      <th scope="row"><img class="img-fluid" src="../../assets/img/'.$row['barid'].'" width="150px" height="150px"></th>
		      <th scope="row">'.$row['fullname'].'</th>
		      <td>'.$row['email'].'</td>
		      <td>';
		      if($row['promote'] == 1){
		      	echo '<p style="color: #0c911d">Promoted/Head</p>';
		      }
			  echo '			  
		      </td>
		    </tr>
		  </tbody>';
		}
		echo '
		</table>';
		?><br>
		</div>
		<div class="col-md-1">
		</div>
	</div><br>
</div>
<!-- MODAL -->
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="addRecordLabel">Confirm Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-secondary" id="confirmPass">
		
      </div>


    </div>
  </div>
</div>

<script>
$(document).on('click', '.edit-object', function(){
    var uid = $(this).attr("edit-id");

    $.ajax({
		url:'confirmpwque.php',
		method: "POST",
		data:{uid:uid},
		success:function(data){
		  $('#confirmPass').html(data);
		  $('#addRecord').modal('show');
		}
    });
});

$(document).on('click', '.check-object', function(){
    var uid = $(this).attr("check-id");
    var q = confirm("Confirm?");
      if(q == true){
        $.post('promoteque.php', {
          uid: uid
        }, function(data){
          location.reload();
        }).fail(function() {
          alert("Something Went Wrong, Unable to Confirm");
        });
      }
      return false;
});
//reset password
$(document).on('click', '.reset-object', function(){
    var uid = $(this).attr("reset-id");
    var q = confirm("Reset User's Password?");
      if(q == true){
        $.post('resetPW.php', {
          uid: uid
        }, function(data){
          alert("User's Password Changed! Password is: pass123");
          location.reload();
        }).fail(function() {
          alert("Something Went Wrong, Unable to Change.");
        });
      }
      return false;
});

$(document).ready(function() {
    $('#peopleIn').dataTable( {
    "aLengthMenu": [[8, -1], [8, "All"]],
    "pageLength": 8,
	"bLengthChange": true,
	"bInfo" : true,	
	"order": [[ 1, "asc" ]]
    } );

} );
</script>
<?php
	include_once '../include/footer.php';
?>