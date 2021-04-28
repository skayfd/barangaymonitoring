<?php
	session_start();
	$title = "Head Home";
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

	$database = new Database();
	$db = $database->getConnection();

	$barangay = new Barangay($db);

	if($barangay->existingbar()){
		if($stmt = $barangay->readrelatedGroup()){

		echo '
		<br><br>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
					<center>
						<h1>Your Group</h1>';
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						echo '
						<div class="card" style="width: 18rem;">
						  <!--<img src="..." class="card-img-top" alt="...">-->
						  <div class="card-body">
						    <h4 class="card-title" style="color:black">'.$row['brgyname'].'</h4>
						    <p class="card-text" style="color:black">'.$row['streetname'].'</p>';?>

						    <a href="viewgroup?id=<?php echo md5($row['referral']) ?>" class="btn btn-primary">Go to Group</a>

						<?php echo '
						  </div>
						</div>';
						}
					echo '
					</center>
				</div>
				<div class="col-md-4">
				</div>
			</div>
		</div>
		';
		}
		else {
			echo "it doesnt work";
		}
	}
	else{
		echo '
		<br><br>
		<div class="container">
			<div class="row">
				<div class="col-md-2">
				</div>
					<div class="col-md-8">
						<div class="jumbotron bg-secondary" style="background:transparent !important">
							<center>
							<h1 class="display-4"><p class="fas fa-question" style="font-size:150px;"></p></h1>
							
							<h2>It seems you dont have a group yet...</h2>
							</center>
						</div>
					</div>
				<div class="col-md-2">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<center>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd">
					  <i class="far fa-plus-square"></i> Add a Barangay
					</button>
					</center>
				</div>
				<div class="col-md-2">
				</div>
			</div>
		</div>
		';
	}
?>
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:black" id="exampleModalLabel">Barangay</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="POST" id="addGroupForm">
      <div class="modal-body">
  		<div class="container">
  			<div class="row">
  				<label style="color:black">Barangay Name</label>
				<input type="text" class="form-control" pattern="[A-Za-z0-9- ]{3,}" title="3 or more letters required" name="brgyname" required>
  			</div>
  			<div class="row">
  				<label style="color:black">Street</label>
				<textarea type="text" class="form-control" pattern="[A-Za-z0-9- ]{3,}" title="3 or more letters required" name="streetname" required></textarea>
  			</div>
  		</div>
      </div>
      <div class="modal-footer">
      	<input type="submit" class="btn btn-primary" value="Create">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script>
//add barangay
$('#addGroupForm').on('submit', function(event){
	event.preventDefault();
	var formdata = new FormData($('#addGroupForm')[0]);
	$.ajax({
	   url:"groupAdd.php",
	   method:"POST",
	   data:formdata,
	   contentType:false,
	   cache:false,
	   processData:false,
	   success:function(data){
	     $('#addGroupForm')[0].reset();
	     $('#modalAdd').modal('hide');
	     window.location.reload();
	     alert("Succesfully Added!");
	     //swal("Good job!", "You clicked the button!", "success");
	   }
	});
});
</script>
<?php
	include_once '../include/footer.php';
?>