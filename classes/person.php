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
		public $datequar;
		public $quarantinedby;
		public $personStatus;

		public $brgycert;
		public $healthdeclaration;
		public $medcert;
		public $travelauth;

		public $pid;
		public $uid;
		public $rid;

		public $date;

		public $conn;
		private $tableName = 'person';

		function __construct($db){
			$this->conn=$db;
		}

		function createperson(){
			$query = "INSERT INTO person SET daterecorded=?, firstname=?, middlename=?, lastname=?, gender=?, contactno=?, address=?, referral=?, archive=0, personstatus=0, uid=?";
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
		function createPUM(){
			$query = "INSERT INTO person SET daterecorded=?, firstname=?, middlename=?, lastname=?, gender=?, contactno=?, address=?, referral=?, archive=0, personstatus=?, datequar=?,quarantinedby=?, uid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->daterecorded);
			$stmt->bindparam(2, $this->firstname);
			$stmt->bindparam(3, $this->middlename);
			$stmt->bindparam(4, $this->lastname);
			$stmt->bindparam(5, $this->gender);
			$stmt->bindparam(6, $this->contactno);
			$stmt->bindparam(7, $this->address);
			$stmt->bindparam(8, $_SESSION['referral']);
			$stmt->bindparam(9, $this->personStatus);
			$stmt->bindparam(10, $this->datequar);
			// $stmt->bindparam(9, $this->brgycert);
			// $stmt->bindparam(10, $this->healthdeclaration);
			// $stmt->bindparam(11, $this->medcert);
			// $stmt->bindparam(12, $this->travelauth);
			$stmt->bindparam(11, $_SESSION['uid']);
			$stmt->bindparam(12, $_SESSION['uid']);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}

		function readallpeople(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readallpeople2(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
			WHERE person.referral = ? AND person.archive != 1";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readallPUM(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus', DATEDIFF(CURRENT_DATE(), person.datequar) AS 'days', person.datequar AS 'datequar'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUM'";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readallPUI(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus', DATEDIFF(CURRENT_DATE(), person.datequar) AS 'days', person.datequar AS 'datequar'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUI'";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readallPUMbrgy(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus', DATEDIFF(CURRENT_DATE(), person.datequar) AS 'days', person.datequar AS 'datequar'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUM' AND person.referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readallPUIbrgy(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus', DATEDIFF(CURRENT_DATE(), person.datequar) AS 'days', person.datequar AS 'datequar'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUI'  AND person.referral = ?";
			
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			//$stmt->bindparam(2, date("Y-m-d"));
			$stmt->execute();
			return $stmt;
		}
		function readallDeceasedbrgy(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus', DATEDIFF(CURRENT_DATE(), person.datequar) AS 'days', person.datequar AS 'datequar'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'Deceased' AND person.referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readallRecoveredbrgy(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.gender AS 'gender', person.contactno AS 'contactno', person.address AS 'address', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'addedby', person.pid AS 'pid', barangay.brgyname AS 'barfrom', person.personStatus AS 'personStatus', DATEDIFF(CURRENT_DATE(), person.datequar) AS 'days', person.datequar AS 'datequar'
			FROM person 
			INNER JOIN user ON user.uid = person.uid
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'Recovered' AND person.referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countPUM(){
			$query = "SELECT count(person.pid) AS 'count'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUM'
			";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countRecoveredbrgy(){
			$query = "SELECT count(person.pid) AS 'count'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'Recovered' AND person.referral = ?
			";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countPUIbrgy(){
			$query = "SELECT count(person.pid) AS 'count'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUI' AND person.referral = ?
			";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countPUMbrgy(){
			$query = "SELECT count(person.pid) AS 'count'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUM' AND person.referral = ?
			";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countDeceasedbrgy(){
			$query = "SELECT count(person.pid) AS 'count'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'Deceased' AND person.referral = ?
			";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countPUI(){
			$query = "SELECT count(person.pid) AS 'count'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUI'
			";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readQuarBy(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'quarby'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUM'
            AND person.pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);
			$stmt->execute();
			return $stmt;
		}
		function positiveBy(){
			$query = "SELECT person.daterecorded AS 'daterecorded', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'markedby'
			FROM person 
			INNER JOIN user ON user.uid = person.quarantinedby
            INNER JOIN barangay ON barangay.referral = person.referral
            WHERE person.personStatus = 'PUI'
            AND person.pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);
			$stmt->execute();
			return $stmt;
		}
		function readspecPerson($pid){
			$query = "SELECT *, CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname' FROM person WHERE pid='$pid'";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $this->pid);

			$stmt->execute();
		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);


			$this->fullname = $row['fullname'];
			$this->firstname = $row['firstname'];
			$this->middlename = $row['middlename'];
			$this->lastname = $row['lastname'];
			$this->gender = $row['gender'];
			$this->contactno = $row['contactno'];
			$this->daterecorded = $row['daterecorded'];
			$this->address = $row['address'];
			$this->personStatus = $row['personStatus'];
			$this->pid = $row['pid'];

			return true;
		}
		function readspecPerson2(){
			$query = "SELECT *, CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', person.address FROM person WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);
			$stmt->execute();
			return $stmt;
		}
		function info(){
			$query = "SELECT * from person where pid =?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1,$this->pid);
			$stmt->execute();
			return $stmt;
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
    			WHERE archive=0";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}

		function archivePerson(){
			$query = "UPDATE person SET archive=1 WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
		}

		function personStatus(){
			$query = " UPDATE person SET personStatus='PUM', quarantinedby=?, datequar=?  WHERE pid=?";
			
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->bindparam(2, $this->datequar);
			$stmt->bindparam(3, $this->pid);

			$stmt->execute();
		}

		function personStatus2(){
			$query = "UPDATE person SET personStatus='Recovered', quarantinedby=?, datequar=? WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->bindparam(2, $this->datequar);
			$stmt->bindparam(3, $this->pid);

			$stmt->execute();
		}

		function personStatus3(){
			$query = "UPDATE person SET personStatus='PUI', quarantinedby=?, datequar=? WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->bindparam(2, $this->datequar);
			$stmt->bindparam(3, $this->pid);

			$stmt->execute();
		}
		function personStatus4(){
			$query = "UPDATE person SET personStatus='Deceased', quarantinedby=?, datequar=? WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['uid']);
			$stmt->bindparam(2, $this->datequar);
			$stmt->bindparam(3, $this->pid);

			$stmt->execute();
		}
		function changeDatequar(){
			$query = "UPDATE person SET datequar=? WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->datequar);
			$stmt->bindparam(2, $this->pid);

			$stmt->execute();
			return true;
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
		function selectHS(){
			$query = "SELECT personStatus
				FROM person
    			WHERE pid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
			return $stmt;
		}

		function specPersonTrace($date, $pid){
			$query = "SELECT GROUP_CONCAT(TIME(record.daterecorded)) AS 'dates', CONCAT(person.firstname,' ',person.lastname) AS 'Name', GROUP_CONCAT(record.pointoforigin) AS 'Origin', GROUP_CONCAT(record.addressto, record.addressto2, record.addressto3) AS 'Destination'
				FROM person
			    LEFT JOIN record ON record.pid = person.pid
			    WHERE DATE(record.daterecorded) = '$date'
				AND person.pid = '$pid' 
			    GROUP BY DATE(record.daterecorded)";
			$stmt = $this->conn->prepare($query);
			//$stmt->bindparam(1, $this->date);
			//$stmt->bindparam(2, $this->pid);

			$stmt->execute();
			return $stmt;
		}
		function PersonTrace($date, $pid){//traces person ---> Needs to 
			$query = "SELECT GROUP_CONCAT(person.pid)AS 'ids', GROUP_CONCAT(TIME(record.daterecorded)) AS 'dates', GROUP_CONCAT(CONCAT(person.firstname,' ',person.lastname)) AS 'names', GROUP_CONCAT(record.pointoforigin) AS 'origin', GROUP_CONCAT(record.addressto, record.addressto2, record.addressto3) AS 'Destination'
				FROM person
			    LEFT JOIN record ON record.pid = person.pid
			    WHERE DATE(record.daterecorded) = '$date'
			    
			    AND person.pid NOT IN (SELECT person.pid FROM person WHERE person.pid = '$pid')
			    GROUP BY DATE(record.daterecorded)
			    ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		function updatequar(){
 
			$query = "UPDATE person SET datequar = ? WHERE pid=?"; 
			 $stmt = $this->conn->prepare($query); 
			 // posted values 
			 $this->datequar=htmlspecialchars(strip_tags($this->datequar));
			 $this->pid=htmlspecialchars(strip_tags($this->pid));
			 // bind parameters
			 $stmt->bindParam(1, $this->datequar);
			 $stmt->bindParam(3, $this->pid);
			 // execute the query
			 if($stmt->execute())
				 
				 return true;
			 else
				 return false;
			 
		 }
	}
?>