<?php
	session_start();
	if($_POST){
	    include_once "../../config/database.php";
	    include_once "../../classes/user.php";
	    include_once "../../classes/history.php";

	    $database = new Database();
	    $db = $database->getConnection();
	 
	    $user = new User($db);
	    $history = new History($db);

	    $user->uid = $_POST['uid'];
	    
	    $history->uid = $_POST['uid'];
	    $history->readUserReq();

	    date_default_timezone_set("Asia/Manila");

	    $history->daterecorded = date("Y-m-d h:i:s");
		$avar = "Accepted";
		$into = "to group.";
		$history->action = $avar.' '.$history->firstname.' '.$history->lastname.' '.$into;	
		// $history->pid = $_POST['pid'];
		$history->createPersonHis();



	    $user->acceptuser();
	}
	else {
		header("Location: headhome");
	}
?>