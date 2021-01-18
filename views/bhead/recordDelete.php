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
    include_once "../../classes/history.php";
    include_once "../../classes/person.php";

    $database = new Database();
    $db = $database->getConnection();
 
	$record = new Record($db);
	$history = new History($db);
	$person = new Person($db);

	$record->rid = $_POST['rid'];

	//history
	$person->rid = $_POST['rid'];
	$person->readspecPersonRecord($person->rid);

	date_default_timezone_set("Asia/Manila");
	$history->daterecorded = date("Y-m-d h:i:s");
	$avar = "Archived record of";
	$into = "from records.";
	$history->action = $avar.' '.$person->firstname.' '.$person->lastname.' '.$into;
	$history->createPersonHis();


	$record->archiveRecord();
}
?>