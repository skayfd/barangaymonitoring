<?php
	class Record{
		public $daterecorded;
		public $timeout;
		public $reason;
		public $status;
		public $pointoforigin;
		public $addressto;
		public $addressto2;
		public $addressto3;
		public $brgycert;
		public $healthdeclaration;
		public $medcert;
		public $travelauth;
		public $workingid;
		public $archive;
		public $temp;
		public $rid;
		public $pid;
		public $uid;
		public $healthStatus;
		public $timeout1;

		public $sDate;
		public $eDate;
		public $referral;

		public $conn;
		private $tableName = 'record';

		function __construct($db){
			$this->conn=$db;
		}
		function createRecord(){
			$query = "INSERT INTO record SET reason=?, status=?, temp=?, pointoforigin=?, addressto=?, addressto2=?, addressto3=?, daterecorded=?, pid=?, brgycert=?, healthdeclaration=?, medcert=?, travelauth=?, workingid=?, uid=?, archive=0, healthStatus=?, timeout=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->reason);
			$stmt->bindparam(2, $this->status);
			$stmt->bindparam(3, $this->temp);
			$stmt->bindparam(4, $this->pointoforigin);
			$stmt->bindparam(5, $this->addressto);
			$stmt->bindparam(6, $this->addressto2);
			$stmt->bindparam(7, $this->addressto3);
			$stmt->bindparam(8, $this->daterecorded);
			$stmt->bindparam(9, $this->pid);
			$stmt->bindparam(10, $this->brgycert);
			$stmt->bindparam(11, $this->healthdeclaration);
			$stmt->bindparam(12, $this->medcert);
			$stmt->bindparam(13, $this->travelauth);
			$stmt->bindparam(14, $this->workingid);
			$stmt->bindparam(15, $_SESSION['uid']);
			$stmt->bindparam(16, $this->healthStatus);
			$stmt->bindparam(17, $this->timeout1);
			if($stmt->execute()){
				return true;
			}
			else {
				return false;
			}
		}
		function readrelatedRecord(){
			$query = "SELECT person.pid AS 'pid', record.daterecorded AS 'date', record.timeout AS 'timeout', record.reason AS 'reason', record.temp AS 'temp', record.healthStatus AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', record.addressto2 AS 'addressto2', record.addressto3 AS 'addressto3', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'fullname', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', record.rid, record.brgycert AS 'brgycert', record.healthdeclaration AS 'healthdecla', record.medcert AS 'medcert', record.travelauth AS 'travelauth', record.workingid AS 'workingid', record.healthStatus AS 'healthStatus'
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
			$query = "SELECT person.pid AS 'personid', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'daterecorded', record.timeout AS 'tout', record.reason AS 'reason', record.status AS 'status', person.contactno AS 'contactno', record.pointoforigin AS 'porigin', record.addressto AS 'destination', person.address AS 'address', person.gender AS 'gender', barangay.brgyname AS 'barname'
			FROM record
			INNER JOIN person ON record.pid = person.pid
            INNER JOIN user ON user.uid = record.uid
            INNER JOIN barangay ON barangay.referral = user.referral
			WHERE record.archive = 0
			ORDER BY fullname ASC";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		function searchrec(){
			$page = $this->page1;
			$query = "SELECT person.pid AS 'personid', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'daterecorded', record.timeout AS 'tout', record.reason AS 'reason', record.status AS 'status', person.contactno AS 'contactno', record.pointoforigin AS 'porigin', record.addressto AS 'destination', person.address AS 'address', person.gender AS 'gender', barangay.brgyname AS 'barname' 
			FROM record 
			INNER JOIN person ON record.pid = person.pid 
			INNER JOIN user ON user.uid = record.uid 
			INNER JOIN barangay ON barangay.referral = user.referral 
			WHERE record.addressto LIKE '%$this->search%' or record.daterecorded LIKE '%$this->search%' limit $page,5";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		function searchrec2(){
			$query = "SELECT person.pid AS 'personid', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname', record.daterecorded AS 'daterecorded', record.timeout AS 'tout', record.reason AS 'reason', record.status AS 'status', person.contactno AS 'contactno', record.pointoforigin AS 'porigin', record.addressto AS 'destination', person.address AS 'address', person.gender AS 'gender', barangay.brgyname AS 'barname' 
			FROM record 
			INNER JOIN person ON record.pid = person.pid 
			INNER JOIN user ON user.uid = record.uid 
			INNER JOIN barangay ON barangay.referral = user.referral 
			WHERE record.addressto LIKE '%$this->search%' or record.daterecorded LIKE '%$this->search%' ORDER BY record.daterecorded DESC ";
			$stmt = $this->conn->prepare($query);
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
		function countRes(){//FOR DONUT CHART LOCAL RESIDENT
			$query = "SELECT COUNT(DISTINCT record.pid) as 'number' 
                    FROM record
                    INNER JOIN person ON record.pid = person.pid
                    WHERE record.archive = 0
                    AND person.referral = ?
                    And record.status = 'RESIDENT'";
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
		function readAllRes(){//FOR BAR CHART
			$query = "SELECT COUNT(*) as 'number' 
				FROM record
			    INNER JOIN person ON record.pid = person.pid
				WHERE record.archive = 0
			    AND person.referral = ?
                AND record.status = 'RESIDENT'";
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
				WHERE archive=0";
			$stmt = $this->conn->prepare($query);
			// $stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function readDateEntries(){
			$query = "SELECT CONCAT(MONTHNAME(record.daterecorded),'-',DAY(record.daterecorded),'-',YEAR(record.daterecorded)) AS 'date', TIME_FORMAT(record.daterecorded, '%h:%i') AS 'time', COUNT(*) AS entrycount FROM record
					INNER JOIN user ON record.uid = user.uid
				    WHERE user.referral = ?
				    AND record.archive = 0
					GROUP BY date
					ORDER BY record.daterecorded";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $_SESSION['referral']);
			$stmt->execute();
			return $stmt;
		}
		function timeoutrecord(){
			$query = "UPDATE record SET timeout=? WHERE rid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->timeout);
			$stmt->bindparam(2, $this->rid);

			$stmt->execute();
		}
		function archiveRecord(){
			$query = "UPDATE record SET archive=1 WHERE rid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->rid);

			$stmt->execute();
		}
		function archivePersonRecords(){
			$query = "UPDATE record SET archive=1 WHERE pid=?";
			$stmt = $this->conn->prepare($query);
			$stmt->bindparam(1, $this->pid);

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
			$query = "SELECT COUNT(DISTINCT record.rid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate' 
			AND record.healthStatus='PUI'
			AND record.archive = 0 
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numPUM($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.rid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate' 
			AND record.healthStatus='PUM'
			AND record.archive = 0 
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numREC($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.rid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate' 
			AND record.healthStatus='Recovered'
			AND record.archive = 0 
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numDEC($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.rid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate' 
			AND record.healthStatus='Deceased'
			AND record.archive = 0 
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function numLSI($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.rid, 0) as 'number' 
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
		function numRES($sDate, $eDate, $referral){
			$query = "SELECT COUNT(DISTINCT record.rid, 0) as 'number' 
			FROM record
			INNER JOIN person ON record.pid = person.pid
			WHERE
			record.daterecorded BETWEEN '$sDate' AND '$eDate'
			AND record.archive = 0 
			AND record.status='RESIDENT'
			AND person.referral = '$referral'";
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function peopleStatusPUI($sDate, $eDate, $referral){
			$query = "SELECT DISTINCT(person.pid) AS 'pid', record.daterecorded AS 'date', record.timeout AS 'timeout', record.reason AS 'reason', record.temp AS 'temp', record.healthStatus AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', record.addressto2 AS 'addressto2', record.addressto3 AS 'addressto3', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'fullname1', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', record.rid, record.brgycert AS 'brgycert', record.healthdeclaration AS 'healthdecla', record.medcert AS 'medcert', record.travelauth AS 'travelauth', record.workingid AS 'workingid', record.healthStatus AS 'healthStatus'
			FROM person
			INNER JOIN record ON record.pid = person.pid
			INNER JOIN user ON record.uid = user.uid
			WHERE
            record.daterecorded BETWEEN '$sDate' AND '$eDate'
            AND record.pid
		    AND person.referral = '$referral'
		    AND person.archive = 0
			AND record.healthStatus = 'PUI'
			ORDER BY record.daterecorded DESC
		    ";
		    $stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		function peopleStatusPUM($sDate, $eDate, $referral){
			$query = "SELECT DISTINCT(person.pid) AS 'pid', record.daterecorded AS 'date', record.timeout AS 'timeout', record.reason AS 'reason', record.temp AS 'temp', record.healthStatus AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', record.addressto2 AS 'addressto2', record.addressto3 AS 'addressto3', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'fullname1', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', record.rid, record.brgycert AS 'brgycert', record.healthdeclaration AS 'healthdecla', record.medcert AS 'medcert', record.travelauth AS 'travelauth', record.workingid AS 'workingid', record.healthStatus AS 'healthStatus'
			FROM person
			INNER JOIN record ON record.pid = person.pid
			INNER JOIN user ON record.uid = user.uid
			WHERE
            record.daterecorded BETWEEN '$sDate' AND '$eDate'
            AND record.pid
		    AND person.referral = '$referral'
		    AND person.archive = 0
			AND record.healthStatus = 'PUM'
			ORDER BY record.daterecorded DESC
		    ";
		    $stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function peopleStatusREC($sDate, $eDate, $referral){
			$query = "SELECT DISTINCT(person.pid) AS 'pid', record.daterecorded AS 'date', record.timeout AS 'timeout', record.reason AS 'reason', record.temp AS 'temp', record.healthStatus AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', record.addressto2 AS 'addressto2', record.addressto3 AS 'addressto3', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'fullname1', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', record.rid, record.brgycert AS 'brgycert', record.healthdeclaration AS 'healthdecla', record.medcert AS 'medcert', record.travelauth AS 'travelauth', record.workingid AS 'workingid', record.healthStatus AS 'healthStatus'
			FROM person
			INNER JOIN record ON record.pid = person.pid
			INNER JOIN user ON record.uid = user.uid
			WHERE
            record.daterecorded BETWEEN '$sDate' AND '$eDate'
            AND record.pid
		    AND person.referral = '$referral'
		    AND person.archive = 0
			AND record.healthStatus = 'Recovered'
			ORDER BY record.daterecorded DESC
		    ";
		    $stmt = $this->conn->prepare($query);

			$stmt->execute();
			return $stmt;
		}
		function peopleStatusDEC($sDate, $eDate, $referral){
			$query = "SELECT DISTINCT(person.pid) AS 'pid', record.daterecorded AS 'date', record.timeout AS 'timeout', record.reason AS 'reason', record.temp AS 'temp', record.healthStatus AS 'status', record.pointoforigin AS 'point', record.addressto AS 'addressto', record.addressto2 AS 'addressto2', record.addressto3 AS 'addressto3', CONCAT(user.firstname,' ',user.middlename,' ',user.lastname) AS 'fullname1', CONCAT(person.firstname,' ',person.middlename,' ',person.lastname) AS 'fullname2', record.rid, record.brgycert AS 'brgycert', record.healthdeclaration AS 'healthdecla', record.medcert AS 'medcert', record.travelauth AS 'travelauth', record.workingid AS 'workingid', record.healthStatus AS 'healthStatus'
			FROM person
			INNER JOIN record ON record.pid = person.pid
			INNER JOIN user ON record.uid = user.uid
			WHERE
            record.daterecorded BETWEEN '$sDate' AND '$eDate'
            AND record.pid
		    AND person.referral = '$referral'
		    AND person.archive = 0
			AND record.healthStatus = 'Deceased'
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