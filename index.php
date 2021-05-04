<?php
session_start();
$title = 'Home Page';

if(isset($_SESSION['uid'])){
	if($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/viewgroup"); }
		else { header("Location: views/verification/accountonhold"); }
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
		else { header("Location: views/verification/accountonhold"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
		else { header("Location: views/verification/accountonhold"); }
	}
	elseif($_SESSION['type'] == 4){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
		else { header("Location: views/verification/accountonhold"); }
	}
}
else {
	header("Location: views/login");
}
?>