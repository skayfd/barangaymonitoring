<?php
	session_start();
	$title = "Promotion List";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){
			if($_SESSION['authorize'] == 0){
				header("Location: views/bmember/memhome");
			} 
		}
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){
			if($_SESSION['authorize'] == 0){
				header("Location: views/bmember/memhome");
			} 
		}
	}
	elseif($_SESSION['authorize'] == 0){
		header("Location: viewgroup");
	}

	include_once '../../classes/user.php';
	include_once '../../classes/history.php';
	include_once '../../config/database.php';

	$database = new Database();
	$db = $database->getConnection();
	$user = new User($db);

	$history = new History($db);
?>
<!--Necessary assets-->
<head>
<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">
<!--Datatables-->
<link rel="stylesheet" type="text/css" href="../../assets/dataTables/datatables/css/jquery.dataTables.css">
<script type="text/javascript" src="../../assets/dataTables/datatables.min.js"></script>
<!--FAVICON-->
<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">
<title><?php echo $title; ?></title>
</head>
<!--TO HERE ANG AFFECTED AREAS(as for now)-->
<body style="background-color:#121212; color:#FFFFFF">


<div class="container">
	<br>
	<?php
	echo '
		<a class="btn btn-danger text-white edit-object" data-toggle="tooltip" data-placement="right" title="This will log you out for security reasons" edit-id="'.$_SESSION['uid'].'"><i class="fas fa-long-arrow-alt-left"></i> Deauthorize and Logout</a>
	';
	?>
	<br>
	
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
		<?php
	if($user->existingProm() == TRUE){
		$user->readWaitingProm();
		$stmt = $user->readWaitingProm();

		echo '
		<center>
		<h1>Promotion List</h1><br>
		<form method="POST" action="promoteuser.php">
			<button name="promote" type="submit" class="btn btn-success"/>Promote Queued Members</button>
		</form>
		</center>
			<table class="table table-borderless text-light">
			  <thead>
			    <tr>
			      <th scope="col">Profile Picture</th>
			      <th scope="col">Full Name</th>
			      <th scope="col">Email</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			  	if(isset($_POST['promote'])){
					$user->uid = $row['uid'];

					$history->uid = $row['uid'];
					$history->readUserPro();

					date_default_timezone_set("Asia/Manila");
					$history->daterecorded = date("Y-m-d h:i:s");
					$avar = "User";
					$into = "has been PROMOTED.";
					$history->action = $avar.' '.$history->firstname.' '.$history->lastname.' '.$into;

					if($user->promoteuser()){
						$history->createPersonHis();
						$user->deauthorizeu();
						echo "
						<script>
							window.location.href='viewpeoplein';
							alert('User Promoted!');
						</script>
						";
					}
					else{
						$user->deauthorizeu();
						echo "
						<script>
							window.location.href='viewpeoplein';
							alert('ERROR: Something happened');
						</script>
						";
					}
				}
			  echo '
			  <tbody>
			    <tr>
			      <th scope="row">';
			      if($row['profilepic'] == ''){
			      	echo '
			      	<i class="fas fa-user text-light" style="font-size:150px;"></i>
			      	';
			      }
			      else {
			      	echo '
			      	<img src="../../assets/img/'.$row['profilepic'].'" width="150px" height="150px">
			      	';
			      }
			      echo'
			      </th>
			      <td>'.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].'</td>
			      <td>'.$row['email'].'</td>
			      <td>
			      	<a class="btn btn-danger text-white delete-object" delete-id="'.$row['uid'].'"><i class="fas fa-times text-light"></i></a>
			      </td>
			    </tr>
			  </tbody>';
			}
			echo '
			</table>';
	}
	else {
		echo "
		<br><br>
		<center><h1 class='display-1'>Empty</h1></center>
		";
	}
		
		?>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
<script type="text/javascript">
$(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    var q = confirm("Cancel Promotion?");
     
    if (q == true){
        $.post('demoteque.php', {
            uid: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to delete.');
        });
    }
});

$(document).on('click', '.edit-object', function(){
    var id = $(this).attr('edit-id');
    var q = confirm("Logout?");
     
    if (q == true){
        $.post('deauthuser.php', {
            uid: id
        }, function(data){
            window.location.href='viewpeoplein';
        }).fail(function() {
            alert('Unable to delete.');
        });
    }
});
</script>
<?php
	include_once '../include/footer.php';
?>