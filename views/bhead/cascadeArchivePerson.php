<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
if($_POST){
    include_once "../../config/database.php";
    include_once "../../classes/record.php";
    //include_once "../../classes/history.php";
    include_once "../../classes/person.php";
    $database = new Database();
    $db = $database->getConnection();
 
	$record = new Record($db);
	//$history = new History($db);
	$person = new Person($db);
    $person->pid = $_POST['pid'];
    $record->pid = $_POST['pid'];


    $record->archivePersonRecords();
    $person->archivePerson();

}
?>