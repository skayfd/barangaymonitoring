<?php
	class User{
		public $firstname;
		public $middlename;
		public $lastname;
		public $email;
		public $password;
		public $currpass;
		public $token;
		public $status;
		public $profilepic;
		public $type;
		public $refferal;
		public $promote;
		public $authorize;
		public $uid;

		public $conn;
		private $tableName = 'user';

		function __construct($db){
			$this->conn=$db;
		}

		function createuser(){
			$query = "INSERT INTO user SET firstname=?, middlename=?, lastname=?, email=?, password=?, type=1, referral=?, token=?, status=0, authorize=0, promote = 1";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->firstname);
			$stmt->bindparam(2, $this->middlename);
			$stmt->bindparam(3, $this->lastname);
			$stmt->bindparam(4, $this->email);
			$stmt->bindparam(5, $this->password);
			$stmt->bindparam(6, $this->referral);
			$stmt->bindparam(7, $this->token);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		function createuser2(){
			$query = "INSERT INTO user SET firstname=?, middlename=?, lastname=?, email=?, password=?, type=3, referral=?, token=?, status=0, authorize=0, promote = 0";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->firstname);
			$stmt->bindparam(2, $this->middlename);
			$stmt->bindparam(3, $this->lastname);
			$stmt->bindparam(4, $this->email);
			$stmt->bindparam(5, $this->password);
			$stmt->bindparam(6, $this->referral);
			$stmt->bindparam(7, $this->token);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		function checkEmailValid($token){
			$query = "SELECT token, status FROM user WHERE status=0 AND token='$token'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->token);

			$stmt->execute();

			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}
			else {
				return false;
			}
		}
		function verifyEmail($token){
			$query = "UPDATE user SET status=1 WHERE token='$token'";
			$stmt = $this->conn->prepare($query);
			
			$stmt->bindparam(1, $this->token);

			if($stmt->execute())
				return true;
			else{
				return false; 
			}
		}
		function acceptuser(){
			$query = "UPDATE user SET type=2 WHERE uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);

			$stmt->execute();
		}
		function confirmuser($password){//confirm password to login to list of employees for promotion
			$query = "SELECT * FROM user WHERE uid = ?";
			$stmt = $this->conn->prepare($query);

			$stmt->bindparam(1, $this->uid);

			$stmt->execute();
			
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				$hash = $row['password'];
				if(password_verify($password, $hash)){
					
					session_start();
					//data from DB to display on user page from login function
					//addtnl reference:https://www.youtube.com/watch?v=Q-fBhFTe2H8
					$_SESSION['uid'] = $row['uid'];
					$_SESSION['firstname'] = $row['firstname'];
					$_SESSION['middlename'] = $row['middlename'];
					$_SESSION['lastname'] = $row['lastname'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['type'] = $row['type'];
					$_SESSION['referral'] = $row['referral'];
					$_SESSION['password'] = $row['password'];
					$_SESSION['profilepic'] = $row['profilepic'];
					$_SESSION['status'] = $row['status'];
					$_SESSION['authorize'] = $row['authorize'];
					return true;
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}
		function authorizeu(){
			$query = "UPDATE user SET authorize = 1 WHERE uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);

			if($stmt->execute()){
				session_destroy();
				return true;
			}
			else{
				return false;
			}
		}
		function deauthorizeu(){
			$query = "UPDATE user SET authorize = 0 WHERE uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);

			if($stmt->execute())
				return true;
			else{
				return false;
			}
		}
		function promoteque(){
			$query = "UPDATE user SET promote = 2 WHERE uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);

			if($stmt->execute())
				return true;
			else{
				return false;
			}
		}
		function demoteque(){
			$query = "UPDATE user SET promote = 0 WHERE uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);

			if($stmt->execute())
				return true;
			else{
				return false;
			}
		}
		function reAuth(){
			$query = "SELECT * FROM user WHERE uid = ?";
			$stmt = $this->conn->prepare($query);

			$stmt->bindparam(1, $_SESSION['uid']);

			$stmt->execute();
			
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				session_start();
				$_SESSION['uid'] = $row['uid'];
				$_SESSION['firstname'] = $row['firstname'];
				$_SESSION['middlename'] = $row['middlename'];
				$_SESSION['lastname'] = $row['lastname'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['type'] = $row['type'];
				$_SESSION['referral'] = $row['referral'];
				$_SESSION['password'] = $row['password'];
				$_SESSION['profilepic'] = $row['profilepic'];
				$_SESSION['status'] = $row['status'];
				$_SESSION['authorize'] = $row['authorize'];
				return true;
			}
			else{
				return false;
			}
		}
		function existingProm(){
			$query = "SELECT * FROM user WHERE promote = 2";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();

			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}
			else {
				return false;
			}
		}
		function readWaitingProm(){
			$query = "SELECT * FROM user 
				WHERE promote = 2
				AND referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			
			return $stmt;
		}
		function promoteuser(){
			$query = "UPDATE user SET promote = 1, type = 1 WHERE uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);

			if($stmt->execute())
				return true;
			else{
				return false;
			}
		}
		function existingref(){
			//checks if referral code is existing
			$query = "SELECT * FROM user WHERE referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->referral);

			$stmt->execute();

			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}
			else {
				return false;
			}
		}

		function existingmail(){
			//checks email if it's used
			$query = "SELECT * FROM user WHERE email = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->email);

			$stmt->execute();

			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}
			else {
				return false;
			}
		}

		function readProfile(){
			$query = "SELECT * FROM user WHERE uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->execute();
			return $stmt;
		}

		function readProfilePic(){
			$query = "SELECT profilepic FROM user WHERE uid = ? AND profilepic IS NULL";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->execute();

			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}
			else {
				return false;
			}
		}

		function readoneuser(){//similar with readprofile?? note to self: change this
			$query = "SELECT * FROM user WHERE uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);

			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstname = $row['firstname'];
			$this->middlename = $row['middlename'];
			$this->lastname = $row['lastname'];
			$this->email = $row['email'];
			$this->referral = $row['referral'];
			$this->type = $row['type'];
			$this->profilepic = $row['profilepic'];

			return true;
		}
		function editProfile(){
			$query = "UPDATE user SET firstname=?, middlename=?, lastname=? WHERE uid=?"; 
			$stmt = $this->conn->prepare($query);
			
			$stmt->bindparam(1,$this->firstname);
			$stmt->bindparam(2,$this->middlename);
			$stmt->bindparam(3,$this->lastname);
			$stmt->bindparam(4,$_SESSION['uid']);

			if($stmt->execute())
				return true;
			else{
				return false; 
			}
		}
		function editPicture(){
			$query = "UPDATE user SET profilepic=? WHERE uid=?"; 
			$stmt = $this->conn->prepare($query);
			
			$stmt->bindparam(1,$this->profilepic);
			$stmt->bindparam(2,$_SESSION['uid']);

			if($stmt->execute())
				return true;
			else{
				return false; 
			}
		}
		function archiveUser(){
			$query = "UPDATE user SET type=4 WHERE uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);

			$stmt->execute();
		}

		function verifyPass($currpass){
			$query = "SELECT * FROM user WHERE email=? ";
			$stmt = $this->conn->prepare($query);
			
			$stmt->bindParam(1, $_SESSION['email']);

			$stmt->execute();

			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				$hash = $_SESSION['password'];
				if(password_verify($currpass, $hash)){				 
					return true;
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}
		function chPass(){
			$query = "UPDATE user SET password=? WHERE uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->password);
			$stmt->bindparam(2, $_SESSION['uid']);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		function chPassFromEmail($token){
			$query = "UPDATE user
			INNER JOIN pwd_reset ON user.email = pwd_reset.email
    		SET user.password = ?
			WHERE pwd_reset.token = '$token'
			";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->password);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}

		function login($password){//compares pw with hashedpw, if it's true login siya -kend
			$query = "SELECT * FROM " .$this->tableName. " WHERE email = ?";
			$stmt = $this->conn->prepare($query);
			
			$stmt->bindParam(1, $this->email);
			
			$stmt->execute();
			
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			$num = $stmt->rowCount();
			if($num > 0){
				$hash = $row['password'];
				if(password_verify($password, $hash)){
					session_start();
					//data from DB to display on user page from login function
					//addtnl reference:https://www.youtube.com/watch?v=Q-fBhFTe2H8
					$_SESSION['uid'] = $row['uid'];
					$_SESSION['firstname'] = $row['firstname'];
					$_SESSION['middlename'] = $row['middlename'];
					$_SESSION['lastname'] = $row['lastname'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['type'] = $row['type'];
					$_SESSION['referral'] = $row['referral'];
					$_SESSION['password'] = $row['password'];
					$_SESSION['profilepic'] = $row['profilepic'];
					$_SESSION['status'] = $row['status'];
					$_SESSION['authorize'] = $row['authorize'];
					return true;
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}		
	}
?>