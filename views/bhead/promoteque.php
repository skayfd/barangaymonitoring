<?php
	if($_POST){
	    include_once "../../config/database.php";
	    include_once "../../classes/user.php";

	    $database = new Database();
	    $db = $database->getConnection();
	 
	    $user = new User($db);
	    $user->uid = $_POST['uid'];
	    
	    $user->promoteque();
	}
	else {
		header("Location: headhome");
	}
?>