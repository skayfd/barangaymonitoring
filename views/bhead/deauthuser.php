<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		header("Location: ../bmember/bmember.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}
if($_POST){
    include_once "../../config/database.php";
    include_once "../../classes/user.php";

    $database = new Database();
    $db = $database->getConnection();
 
	$user = new User($db);

	$user->uid = $_POST['uid'];
 
	$user->deauthorizeu();
	session_destroy();
}
?>