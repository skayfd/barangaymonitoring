<?php
	class Record{
		public $daterecorded;
		public $reason;
		public $status;
		public $pointoforigin;
		public $addressto;
		public $archive;
		public $temp;
		public $rid;
		public $pid;
		public $uid;

		public $sDate;
		public $eDate;
		public $referral;

		public $conn;
		private $tableName = 'person';

		function __construct($db){
			$this->conn=$db;
		}
		function createRecord(){
			$query = "INSERT INTO record SET reason=?, status=?, archive=0, pointoforigin=?, addressto=?,daterecorded=?, temp=?, uid=?, pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->reason);
			$stmt->bindparam(2, $this->status);
			$stmt->bindparam(3, $this->pointoforigin);
			$stmt->bindparam(4, $this->addressto);
			$stmt->bindparam(5, $this->daterecorded);
			$stmt->bindparam(6, $this->temp);
			$stmt->bindparam(7, $_SESSION['uid']);
			$stmt->bindparam(8, $this->pid);

			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		function readrelatedRecord(){
			$query = "SELECT record.daterecorded AS 'date', record.reason AS 'reason', record.temp AS 'temp', record.status AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'fullname', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', record.rid
			FROM record
			INNER JOIN user ON record.uid = user.uid
			INNER JOIN person ON record.pid = person.pid
			WHERE record.archive = 0 AND record.pid=?
			ORDER BY record.daterecorded DESC";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
			return $stmt;
		}
		function readrelatedRecordPerson(){//used for specified report title e.g Juan's Records
			$query = "SELECT DISTINCT CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', person.address AS 'address2', person.contactno AS 'contactno2'
			FROM record
		    INNER JOIN person ON record.pid = person.pid
		    WHERE record.archive = 0 AND record.pid = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
			return $stmt;
		}
		function readAllRecord(){
			$query = "SELECT CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'daterecorded', record.reason AS 'reason', record.status AS 'status', person.contactno AS 'contactno', person.address AS 'address', person.gender AS 'gender'
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE record.archive = 0
			AND person.referral = ?
			ORDER BY fullname ASC";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countAPOR(){//FOR DONUT CHART APOR
			$query = "SELECT COUNT(DISTINCT record.pid) as 'number' 
                    FROM record
                    INNER JOIN person ON record.pid = person.pid
                    WHERE record.archive = 0
                    AND person.referral = ?
                    And record.status = 'APOR'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countPUI(){//FOR DONUT CHART PUI
			$query = "SELECT COUNT(DISTINCT record.pid) as 'number' 
                    FROM record
                    INNER JOIN person ON record.pid = person.pid
                    WHERE record.archive = 0
                    AND person.referral = ?
                    And record.status = 'PUI'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countPUM(){//FOR DONUT CHART PUM
			$query = "SELECT COUNT(DISTINCT record.pid) as 'number' 
                    FROM record
                    INNER JOIN person ON record.pid = person.pid
                    WHERE record.archive = 0
                    AND person.referral = ?
                    And record.status = 'PUM'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countLSI(){//FOR DONUT CHART LSI
			$query = "SELECT COUNT(DISTINCT record.pid) as 'number' 
                    FROM record
                    INNER JOIN person ON record.pid = person.pid
                    WHERE record.archive = 0
                    AND person.referral = ?
                    And record.status = 'LSI'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readAllAPOR(){//FOR BAR CHART
			$query = "SELECT COUNT(*) as 'number' 
				FROM record
			    INNER JOIN person ON record.pid = person.pid
				WHERE record.archive = 0
			    AND person.referral = ?
                AND record.status = 'APOR'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readAllLSI(){//FOR BAR CHART
			$query = "SELECT COUNT(*) as 'number' 
				FROM record
			    INNER JOIN person ON record.pid = person.pid
				WHERE record.archive = 0
			    AND person.referral = ?
                AND record.status = 'LSI'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readAllPUI(){//FOR BAR CHART
			$query = "SELECT COUNT(*) as 'number' 
				FROM record
			    INNER JOIN person ON record.pid = person.pid
				WHERE record.archive = 0
			    AND person.referral = ?
                AND record.status = 'PUI'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readAllPUM(){//FOR BAR CHART
			$query = "SELECT COUNT(*) as 'number' 
				FROM record
			    INNER JOIN person ON record.pid = person.pid
				WHERE record.archive = 0
			    AND person.referral = ?
                AND record.status = 'PUM'";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function countStatus(){
			$query = "SELECT COUNT(DISTINCT record.pid) as 'number' FROM record
				INNER JOIN person ON record.pid = person.pid
				WHERE record.archive = 0
			    AND referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readDates(){
			$query = "SELECT daterecorded FROM record";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		function countRecords(){
			$query = "SELECT COUNT(*) AS 'total' FROM record 
				INNER JOIN user ON record.uid = user.uid
				WHERE archive=0
				AND user.referral = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readDateEntries(){
			$query = "SELECT CONCAT(MONTHNAME(record.daterecorded),'-',DAY(record.daterecorded),'-',YEAR(record.daterecorded)) AS 'date', TIME_FORMAT(record.daterecorded, '%h:%i') AS 'time', COUNT(*) AS entrycount FROM record
					INNER JOIN user ON record.uid = user.uid
				    WHERE user.referral = ?
					GROUP BY date";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function archiveRecord(){
			$query = "UPDATE record SET archive=1 WHERE rid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->rid);

			$stmt->execute();
		}
		function archiveRelatedRecord(){
			$query = "UPDATE record
			INNER JOIN person on record.pid = person.pid
            SET record.archive = 1
		    WHERE person.pid = ?";
		    $stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

			$stmt->execute();
		}
		function fromToDate($sDate, $eDate){
			$query = "SELECT CONCAT(person.firstname,' ', person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'datetimerecorded', record.reason AS 'reason', record.status AS 'status'
			FROM record
			INNER JOIN person ON record.pid = person.pid
    		WHERE record.daterecorded BETWEEN '$sDate' AND '$eDate'
    		AND record.archive = 0 
    		AND person.archive = 0
    		ORDER by record.daterecorded
    		";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numAPOR($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.pid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate'
			AND record.archive = 0 
			AND record.status='APOR'
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numPUI($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.pid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate'
			AND record.archive = 0 
			AND record.status='PUI'
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numPUM($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.pid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate'
			AND record.archive = 0 
			AND record.status='PUM'
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numLSI($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.pid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate'
			AND record.archive = 0 
			AND record.status='LSI'
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function peopleStatus($sDate, $eDate, $referral){
			$query = "SELECT DISTINCT(person.pid) AS 'id', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'datetimerecorded', record.reason AS 'reason',record.status AS 'status', person.address AS 'address'
			FROM record
			INNER JOIN person ON record.pid = person.pid
		    WHERE
		    record.daterecorded BETWEEN '$sDate' AND '$eDate'
		    AND person.referral = '$referral'
		    AND person.archive = 0
		    ORDER BY record.daterecorded DESC
		    ";
		    $stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function readarchiveRec(){
			$query = "SELECT CONCAT(person.firstname,' ', person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'date', person.contactno AS 'contactnumber', person.address AS 'address', record.temp AS 'temp', record.reason AS 'reason', record.status AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', CONCAT(user.firstname,' ', user.middlename,' ',user.lastname) AS 'addedby'
				FROM record
			    INNER JOIN person ON record.pid = person.pid
			    INNER JOIN user ON record.uid = user.uid
			    WHERE person.referral = ?
			    AND record.archive = '1'";
		    $stmt = $this->conn->prepare($query);
		    $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
	}
?>