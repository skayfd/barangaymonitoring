<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		header("Location: ../bmember/memhome.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}
if($_POST){
    include_once "../../config/database.php";
    include_once "../../classes/record.php";

    $database = new Database();
    $db = $database->getConnection();
 
	$record = new Record($db);

	$record->rid = $_POST['rid'];
 
	$record->archiveRecord();
}
?>