<?php
	session_start();
    include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";
	include_once "../../classes/history.php";
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
 
	$person = new Person($db);
if($_POST){

	$person->pid = $_POST['pid'];
 
	$person->personStatus3();
}
?>