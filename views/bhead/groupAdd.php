<?php
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/barangay.php";

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		header("Location: ../bmember/memhome.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}

	$database = new Database();
	$db = $database->getConnection();

	$barangay = new Barangay($db);

	if($_POST){
		$barangay->brgyname = $_POST['brgyname'];
		$barangay->streetname = $_POST['streetname'];
		
		$barangay->createGroup();
	}
	else {
		header("Location: headhome");
	}
?>