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
    include_once "../../classes/user.php";
    include_once "../../classes/history.php";


    $database = new Database();
    $db = $database->getConnection();
 
    $user = new User($db);
    $history = new History($db);

    $user->uid = $_POST['uid'];
    $history->uid = $_POST['uid'];

    $password = 'pass123';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user->password = $hashed_password;

    $history->readUserResetPW();

    //history
    date_default_timezone_set("Asia/Manila");
	$history->daterecorded = date("Y-m-d h:i:s");
	$avar = "Reset Password for";
	$into = "in the system.";
	$history->action = $avar.' '.$history->firstname.' '.$history->lastname.' '.$into;	
	// $history->pid = $pid;
	$history->createPersonHis();

    $user->resetPW();
}
?>