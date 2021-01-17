<?php
	session_start();
	include_once "../../config/database.php";
	include_once "../../classes/user.php";

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);

	if($_POST){
		$user->firstname = $_POST['firstname'];
		$user->middlename = $_POST['middlename'];
		$user->lastname = $_POST['lastname'];
		$user->editProfile();
	}
	else {
		header("Location: memhome.php");
	}
?>