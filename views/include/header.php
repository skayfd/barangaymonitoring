<html>
	<!--FROM THIS START OF CODE-->
	<head>
		<link rel="icon" href="../assets/img/favicon.ico" type="image/ico">
	<?php
		if(isset($_SESSION['uid'])){
			if($_SESSION['type'] == 1){//admin/barangay head
				if($_SESSION['status'] == 1){
				include_once '../../classes/user.php';
				include_once '../../classes/barangay.php';
				include_once '../../config/database.php';

				$database = new Database();
				$db = $database->getConnection();
				$barangay = new Barangay($db);
				echo '
				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>
				<script src="../../assets/sweetalert/sweetalert.min.js"></script>

				<!--BootBox-->
				<script src="../../assets/bootbox/bootbox.min.js"></script>
				<script src="../../assets/bootbox/bootbox.locales.min.js"></script>

				

				<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">
				<link rel="stylesheet" href="../../assets/dashboard.css">
				<link rel="stylesheet" href="../../assets/tblstyle.css">
				<link rel="stylesheet" href="../assets/feather.min.js">

				<!--Datatables-->
				<link rel="stylesheet" type="text/css" href="../../assets/dataTables/datatables/css/jquery.dataTables.css">
  				<script type="text/javascript" src="../../assets/dataTables/datatables.min.js"></script>

  				<!--Datepicker-->
  				<script type="text/javascript" src="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
      			<link rel="stylesheet" href="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

      			<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

				 ';
        
				}
				else {
				echo '
				<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

      			<!-- BOOTSTRAP CSS -->
      			<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <!--EMPTY SPACE FOR UNVERIFIED EMAIL-->
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
			}
			elseif($_SESSION['type'] == 2){//normal member
				if($_SESSION['status'] == 1){
				include_once '../../classes/user.php';
				include_once '../../classes/barangay.php';
				include_once '../../config/database.php';

				$database = new Database();
				$db = $database->getConnection();
				echo '
				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>
				<script src="../../assets/sweetalert/sweetalert.min.js"></script>

				<!--BootBox-->
				<script src="../../assets/bootbox/bootbox.min.js"></script>
				<script src="../../assets/bootbox/bootbox.locales.min.js"></script>

				<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Datatables-->
				
				<link rel="stylesheet" type="text/css" href="../../assets/dataTables/datatables/css/jquery.dataTables.css">
  				<script type="text/javascript" src="../../assets/dataTables/datatables.min.js"></script>

  				<!--Datepicker-->
  				<script type="text/javascript" src="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
      			<link rel="stylesheet" href="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

      			<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <a href="memhome" class="nav-link"><i class="fas fa-columns"></i> Dashboard</a>
				      </li>
				      <li class="nav-item">
				        <a href="memprofile" class="nav-link"><i class="far fa-id-badge"></i> Profile</a>
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
				else {
				echo '
				<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

      			<!-- BOOTSTRAP CSS -->
      			<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <!--EMPTY SPACE FOR UNVERIFIED EMAIL-->
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
				
			}
			elseif($_SESSION['type'] == 3){//requesting member
				if($_SESSION['status'] == 1){
				include_once '../../classes/user.php';
				include_once '../../classes/barangay.php';
				include_once '../../config/database.php';

				$database = new Database();
				$db = $database->getConnection();
				echo '
				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>

				<!--BootBox-->
				<script src="../../assets/bootbox/bootbox.min.js"></script>
				<script src="../../assets/bootbox/bootbox.locales.min.js"></script>

				<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Datatables-->
				<link rel="stylesheet" type="text/css" href="../../assets/dataTables/datatables.min.css">
  				<script type="text/javascript" src="../../assets/dataTables/datatables.min.js"></script>

  				<!--Datepicker-->
  				<script type="text/javascript" src="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
      			<link rel="stylesheet" href="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

      			<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index.php">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <!--<a class="nav-link" href="#"><span class="sr-only">(current)</span></a>-->
				      </li>
				      <li class="nav-item">
				        <!--EMPTY SPACE, TBA-->
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout.php" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
				else{
				echo '
				<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

      			<!-- BOOTSTRAP CSS -->
      			<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <!--EMPTY SPACE FOR UNVERIFIED EMAIL-->
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
			}
			elseif($_SESSION['type'] == 4){//requesting(ignored)member
				if($_SESSION['status'] == 1){
				include_once '../../classes/user.php';
				include_once '../../classes/barangay.php';
				include_once '../../config/database.php';

				$database = new Database();
				$db = $database->getConnection();
				echo '
				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>

				<!--BootBox-->
				<script src="../../assets/bootbox/bootbox.min.js"></script>
				<script src="../../assets/bootbox/bootbox.locales.min.js"></script>

				<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Datatables-->
				<link rel="stylesheet" type="text/css" href="../../assets/dataTables/datatables.min.css">
  				<script type="text/javascript" src="../../assets/dataTables/datatables.min.js"></script>

  				<!--Datepicker-->
  				<script type="text/javascript" src="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
      			<link rel="stylesheet" href="../../assets/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

      			<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index.php">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <!--<a class="nav-link" href="#"><span class="sr-only">(current)</span></a>-->
				      </li>
				      <li class="nav-item">
				        <!--EMPTY SPACE, TBA-->
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout.php" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
				else{
				echo '
				<!--FAVICON-->
      			<link rel="icon" href="../../assets/img/favicon.ico" type="image/ico">

      			<!-- BOOTSTRAP CSS -->
      			<link rel="stylesheet" href="../../assets/bootstrap/4.3.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">

				<!--Necessary assets-->
				<script src="../../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
				<script src="../../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
				<script src="../../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>

				<nav class="navbar navbar-expand-lg navbar-dark">
				  <a class="navbar-brand" href="../../index">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <!--EMPTY SPACE FOR UNVERIFIED EMAIL-->
				      </li>
				    </ul>
				  </div>

				  <div class="navbar-nav">
				  </div>
				  </div>
				  <div>
					<a href="../util/logout" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i></a>

				</nav>
				';
				}
			}
		}
		else {
			include_once '../classes/user.php';
			include_once '../config/database.php';
			$database = new Database();
 			$db = $database->getConnection();
			echo '
			<script src="../assets/jquery/3.3.1/jquery-3.3.1.min.js"></script>
			<script src="../assets/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
			<script src="../assets/bootstrap/4.3.1/js/bootstrap.min.js"></script>
			<link rel="stylesheet" href="../assets/bootstrap/4.3.1/css/bootstrap.min.css">
			<link rel="stylesheet" href="../assets/font-awesome/css/all.min.css">
			
			<script src="../assets/sweetalert/sweetalert.min.js"></script>

			

			<!--<nav class="navbar navbar-expand-lg " style="background: #05246C;">
			  <a class="navbar-brand" href="../index.php">Barangay Monitoring <span class="badge badge-secondary">MSAPOR</span></a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse" id="navbarNav">
			    <ul class="navbar-nav">
			      <li class="nav-item">
			        <a class="nav-link" href="../index.php">HOME<span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item"> -->
			        <!-- EMPTY LINK SPACE
			      </li>
			    </ul>
			  </div>

				<div class="navbar-nav">
				</div>
				</div>
				<div>
					<a href="login" class="btn btn-outline-primary text-light"><i class="fas fa-sign-in-alt">&nbsp</i>Login</a>
					<a href="regcapsec" class="btn btn-outline-success text-light"><i class="fas fa-file-signature">&nbsp</i>Sign Up</a>
			</nav>-->
			';
		}
	?>

	<title><?php echo $title; ?></title>
<!--<script>
	$(document).ready(function(){
    $('#search_text').keyup(function(){
        var txt = $(this).val();
        if(txt != '')
        {
            $.ajax({
                url:"search2.php",
                method:"POST",
                data:{search:txt},
                datatype:"text",
                success:function(data)
                {
                    $('#result').html(data);
                }
            });
        }
        else
        {
            $('#result').html('');  
        }
    });
	});
</script>-->

	<style>
			.notification {
			  background-color: #ff5100;
			  color: white;
			  text-decoration: none;
			  padding: 15px 26px;
			  position: relative;
			  display: inline-block;
			  border-radius: 2px;
			}

			.notification:hover {
			  background: black;
			}

			.notification .badge {
			  position: absolute;
			  top: -10px;
			  right: -10px;
			  padding: 5px 10px;
			  border-radius: 50%;
			  background: white;
			  color: black;
			}

			.notification2 {
			  background-color: #b30c00;
			  color: white;
			  text-decoration: none;
			  padding: 15px 26px;
			  position: relative;
			  display: inline-block;
			  border-radius: 2px;
			}

			.notification2:hover {
			  background: black;
			}

			.notification2 .badge {
			  position: absolute;
			  top: -10px;
			  right: -10px;
			  padding: 5px 10px;
			  border-radius: 50%;
			  background: white;
			  color: black;
			}
            a:link, a:visited {
            color: white;
            text-align: center;
            text-decoration: none;
            }
            a:hover, a:active {
            background-color: none;
            }
</style>

	</head>
	<!--TO HERE ANG AFFECTED AREAS(as for now)-->
	<body style="background: #E5ECFD;">