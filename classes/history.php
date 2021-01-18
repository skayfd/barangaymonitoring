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

		function createPersonHis(){
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