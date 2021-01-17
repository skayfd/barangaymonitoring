<?php
	class pwd_reset{
		public $email;
		public $token;

		public $conn;
		private $tableName = 'pwd_reset';

		function __construct($db){
			$this->conn=$db;
		}

		function createResetPW(){
			$query = "INSERT INTO pwd_reset SET email=?, token=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->email);
			$stmt->bindparam(2, $this->token);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		function checkEmailValid($token){
			$query = "SELECT * FROM pwd_reset
			INNER JOIN user ON pwd_reset.email = user.email
			WHERE pwd_reset.token = '$token'";

			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $this->token);

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
		function removeResetToken($token){
			$query = "DELETE pwd_reset FROM pwd_reset
			INNER JOIN user ON pwd_reset.email = user.email
			WHERE pwd_reset.token = '$token'";

			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $this->token);

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
	}
?>