<?php
	class Barangay{
		public $brgyname;
		public $streetname;
		public $referral;
		public $bid;
		public $uid;


		public $conn;
		private $tableName = 'barangay';

		function __construct($db){
			$this->conn=$db;
		}

		function existingbar(){
			//checks barangayhead if he/she has a group
			$query = "SELECT * FROM barangay WHERE referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);

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
		function createGroup(){
			$query = "INSERT INTO barangay SET brgyname=?, streetname=?, referral=?, uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->brgyname);
			$stmt->bindparam(2, $this->streetname);
			$stmt->bindparam(3, $_SESSION['referral']);
			$stmt->bindparam(4, $_SESSION['uid']);

			$stmt->execute();
		}
		function readrelatedGroup(){
			$query = "SELECT * FROM barangay WHERE referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readoneGroup(){
			$query = "SELECT * FROM barangay WHERE referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->brgyname = $row['brgyname'];
			$this->streetname = $row['streetname'];
			$this->streetname = $row['referral'];
		}
		function readGroupsByUser(){//for header, pang lagyan ng group homes
			$query = "SELECT barangay.brgyname AS 'barname', barangay.referral AS 'code'
				FROM barangay
			    INNER JOIN user ON barangay.referral = user.referral
			    WHERE user.referral = ?
			    AND user.uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->bindparam(2, $_SESSION['uid']);
			$stmt->execute();
			return $stmt;
		}
		function existingGroupOfUser(){//read if user belongs to a group on header
			$query = "SELECT * 
				FROM barangay
			    INNER JOIN user ON barangay.referral = user.referral
			    WHERE user.referral = ?
			    AND user.uid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->bindparam(2, $_SESSION['uid']);

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
		function numberofPeople(){
			$query = "SELECT COUNT(*) AS 'total'
				FROM barangay
    			INNER JOIN user ON barangay.referral = user.referral
    			WHERE barangay.referral = ?
    			AND type BETWEEN '1' AND '2'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function numberofRequest(){
			$query = "SELECT COUNT(*) AS 'total'
				FROM barangay
    			INNER JOIN user ON barangay.referral = user.referral
    			WHERE barangay.referral = ?
    			AND user.type = 3";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readPeopleInside(){
			$query = "SELECT CONCAT(user.firstname, ' ',user.middlename, ' ',user.lastname) AS 'fullname', user.email AS 'email', user.profilepic AS 'profilepic', user.uid AS 'uid', user.promote AS 'promote', barangay.referral AS 'referral'
				FROM user
    			INNER JOIN barangay ON user.referral = barangay.referral
    			WHERE NOT user.uid = ?
    			AND barangay.referral = ?
                AND user.type BETWEEN 1 AND 2";
    		$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->bindparam(2, $_SESSION['referral']);
			$stmt->execute();

			return $stmt;
		}
		function readPeopleRequests(){
			$query = "SELECT CONCAT(user.firstname, ' ',user.middlename, ' ',user.lastname) AS 'fullname', user.email AS 'email', user.uid AS 'uid'
				FROM user
    			INNER JOIN barangay ON user.referral = barangay.referral
    			WHERE barangay.referral = ?
    			AND user.type = 3";
    		$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();

			return $stmt;
		}
		function readIgnoredRequests(){
			$query = "SELECT CONCAT(user.firstname, ' ',user.middlename, ' ',user.lastname) AS 'fullname', user.email AS 'email', user.uid AS 'uid'
				FROM user
    			INNER JOIN barangay ON user.referral = barangay.referral
    			WHERE barangay.referral = ?
    			AND user.type = 4";
    		$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();

			return $stmt;
		}
	}
?>