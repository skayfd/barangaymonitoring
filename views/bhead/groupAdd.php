<?php
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/barangay.php";

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
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