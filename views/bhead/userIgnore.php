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
    include_once "../../classes/user.php";

    $database = new Database();
    $db = $database->getConnection();
 
	$user = new User($db);

	$user->uid = $_POST['uid'];
 
	$user->archiveUser();
}
?>