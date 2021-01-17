<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
if($_POST){
    include_once "../../config/database.php";
    include_once "../../classes/person.php";

    $database = new Database();
    $db = $database->getConnection();
 
	$person = new Person($db);

	$person->pid = $_POST['pid'];
 
	$person->archivePerson();
}
?>