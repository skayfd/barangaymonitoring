<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		header("Location: ../bhead/headhome.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}
if($_POST){
    include_once "../../config/database.php";
    include_once "../../classes/person.php";
    include_once "../../classes/record.php";

    $database = new Database();
    $db = $database->getConnection();
 
	$person = new Person($db);
	$record = new Record($db);

	$person->pid = $_POST['pid'];
 	$record->pid = $_POST['pid'];

	$person->archivePerson();
	$record->archiveRelatedRecord();
}
?>