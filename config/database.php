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

	//Deployment Connection for Clever Hosting can't insert from web???
	private	$host = "banlme04fckdejwxz19n-mysql.services.clever-cloud.com";
	private $dbName = "banlme04fckdejwxz19n";
	private	$userName = "uck1nwdvyoojqcjj";
	private $password = "KA67DHheQk0mGbCMPGOy";

	//Deployment Connection for FREEDB mysql not updated
	// private	$host = "freedb.tech";
	// private $dbName = "freedbtech_barangaymonitoring";
	// private	$userName = "freedbtech_bmonitoring";
	// private $password = "RwdymIgxJ16AtAPmGlO4";

	//Deployment Connection for db4free
	// private	$host = "db4free.net";
	// private $dbName = "bmonitoring";
	// private	$userName = "barmonitoring";
	// private $password = "RwdymIgxJ16AtAPmGlO4";


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