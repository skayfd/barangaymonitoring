<?php
	class Person{
		public $daterecorded;
		public $firstname;
		public $middlename;
		public $lastname;
		public $gender;
		public $contactno;
		public $address;
		public $archive;
		public $referral;

		public $brgycert;
		public $healthdeclaration;
		public $medcert;
		public $travelauth;

		public $pid;
		public $uid;
		public $rid;

		public $conn;
		private $tableName = 'person';

		function __construct($db){
			$this->conn=$db;
		}

		function createperson(){
			$query = "INSERT INTO person SET daterecorded=?, firstname=?, middlename=?, lastname=?, gender=?, contactno=?, address=?, referral=?, archive=0, uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->daterecorded);
			$stmt->bindparam(2, $this->firstname);
			$stmt->bindparam(3, $this->middlename);
			$stmt->bindparam(4, $this->lastname);
			$stmt->bindparam(5, $this->gender);
			$stmt->bindparam(6, $this->contactno);
			$stmt->bindparam(7, $this->address);
			$stmt->bindparam(8, $_SESSION['referral']);
			// $stmt->bindparam(9, $this->brgycert);
			// $stmt->bindparam(10, $this->healthdeclaration);
			// $stmt->bindparam(11, $this->medcert);
			// $stmt->bindparam(12, $this->travelauth);
			$stmt->bindparam(9, $_SESSION['uid']);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}

		function readallpeople(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readspecPerson($pid){
			$query = "SELECT * FROM person WHERE pid='$pid'";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $this->pid);

			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstname = $row['firstname'];
			$this->middlename = $row['middlename'];
			$this->lastname = $row['lastname'];
			$this->gender = $row['gender'];
			$this->contactno = $row['contactno'];
			$this->daterecorded = $row['daterecorded'];
			$this->address = $row['address'];
			$this->pid = $row['pid'];

			return true;
		}
		function readPerBarangay(){
			$query = "SELECT barangay.brgyname AS 'barname' FROM person
			INNER JOIN user ON user.uid = person.uid
		    INNER JOIN barangay ON barangay.referral = user.referral
			WHERE pid=?
			";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_GET['id']);
			$stmt->execute();
			return $stmt;
		}
		function readspecPersonRecord($rid){
			$query = "SELECT * FROM person
			INNER JOIN record ON person.pid = record.pid
		    WHERE record.rid = '$rid'";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $this->rid);
			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstname = $row['firstname'];
			$this->middlename = $row['middlename'];
			$this->lastname = $row['lastname'];
			$this->gender = $row['gender'];
			$this->contactno = $row['contactno'];
			$this->daterecorded = $row['daterecorded'];
			$this->referral = $row['referral'];
			$this->pid = $row['pid'];

			return true;
		}
		function readarchivePer(){
			$query = "SELECT CONCAT(person.firstname,' ', person.middlename,' ',person.lastname) AS 'fullname', person.daterecorded AS 'date', person.gender AS 'gender', person.contactno AS 'contactno', person.address As 'address', person.brgycert AS 'brgycert', person.healthdeclaration AS 'hdecla', person.medcert AS 'medcert', person.travelauth AS 'travelauth',
				CONCAT(user.firstname,' ', user.middlename,' ',user.lastname) AS 'addedby'
				FROM person
			    INNER JOIN user ON person.uid = user.uid
			    WHERE person.referral = ?
			    AND person.archive = '1'";
		    $stmt = $this->conn->prepare($query);
		    $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function numberofPeopleList(){
			$query = "SELECT COUNT(*) AS 'total'
				FROM person
    			INNER JOIN barangay ON barangay.referral = person.referral
    			WHERE barangay.referral = ? AND archive=0";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}

		function archivePerson(){
			$query = "UPDATE person SET archive=1 WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
		}
		function documentPic(){
			$query = "SELECT pid, brgycert, healthdeclaration, medcert, travelauth
				FROM person
    			WHERE pid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
			return $stmt;
		}
	}
?>