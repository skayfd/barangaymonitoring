<?php
	class Database{
	//LOCAL Connection
	// private	$host = "localhost";
	// private $dbName = "monitoring";
	// private	$userName = "root";
	// private $password = "";

	//Deployment Connection for www.freemysqlhosting.net
	// private	$host = "sql12.freemysqlhosting.net";
	// private $dbName = "sql12388241";
	// private	$userName = "sql12388241";
	// private $password = "JG9MhGKg29";

	//Deployment Connection for 000webhosting
	private	$host = "https://databases-auth.000webhost.com/";
	private $dbName = "id15884170_monitoring";
	private	$userName = "id15884170_barangaymonitoring";
	private $password = "7&D%^xCx_*=pv(xh";

	public $conn;

	public function getConnection(){
		$this->conn = null;
		
		try{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->password);
			// echo "Database Connected";
		}
		catch(PDOException $exception){
			echo "Connection Error:" . $exception->getMessage();
			
		}
		return $this->conn;
	}
}
?>