<?php
	class History{
		public $daterecorded;
		public $action;

		public $hid;
		public $uid;

		public $conn;
		private $tableName = 'history';

		function __construct($db){
			$this->conn=$db;
		}

		function createPersonHis(){//creates History/activity log for the system
			$query = "INSERT INTO history SET daterecorded=?, action=?, uid=?, pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->daterecorded);
			$stmt->bindparam(2, $this->action);
			$stmt->bindparam(3, $_SESSION['uid']);
			$stmt->bindparam(4, $this->pid);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		
		function readUserReq(){
			$query = "SELECT * FROM user
				WHERE type = 3 OR type = 4
				AND uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);
			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstname = $row['firstname'];
			$this->middlename = $row['middlename'];
			$this->lastname = $row['lastname'];

			return true;
		}
		function readUserPro(){
			$query = "SELECT * FROM user
				WHERE type = 2
				AND uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);
			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstname = $row['firstname'];
			$this->middlename = $row['middlename'];
			$this->lastname = $row['lastname'];

			return true;
		}
		function readUserResetPW(){
			$query = "SELECT * FROM user
				WHERE uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->uid);
			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstname = $row['firstname'];
			$this->lastname = $row['lastname'];

			return true;
		}
		function readrelatedHistory(){
			$query = "SELECT history.daterecorded AS 'date', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', history.action as 'action'
			FROM history
		    INNER JOIN user ON history.uid = user.uid
		    WHERE user.referral = ?";
		    $stmt = $this->conn->prepare($query);
		    $stmt->bindparam(1, $_SESSION['referral']);
		    $stmt->execute();
			return $stmt;
		}
	}
?>