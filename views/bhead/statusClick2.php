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
	$record = new Record($db);
if($_POST){

	$person->pid = $_POST['pid'];
<<<<<<< HEAD
	$person->datequar = date("Y-m-d h:i:s");
	$person->datequar = date("Y-m-d");

	$record->reason = 'Changed Status to Recovered';
	$record->healthStatus = 'Recovered';
	$record->addressto2 = ' ';
	$record->status = ' ';
	$record->temp = '  ';
	$record->pointoforigin = ' ';
	$record->addressto = ' ';
	$record->addressto3 = ' ';
	$record->daterecorded = date("Y-m-d h:i:s");
	$record->timeout1 = date("Y-m-d h:i:s ");
	$record->pid = $_POST['pid'];

=======
 
>>>>>>> parent of 3ffc982 (new ui)
	$person->personStatus2();
	$record->createRecord();
}
?>