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

	//Deployment Connection for Clever Hosting
	// private	$host = "b9e3ien3vvgnjmkehxue-mysql.services.clever-cloud.com";
	// private $dbName = "b9e3ien3vvgnjmkehxue";
	// private	$userName = "ui9tovzvkpiohz8l";
	// private $password = "RwdymIgxJ16AtAPmGlO4";

	//Deployment Connection for FREEDB
	private	$host = "freedb.tech";
	private $dbName = "freedbtech_barangaymonitoring";
	private	$userName = "freedbtech_bmonitoring";
	private $password = "RwdymIgxJ16AtAPmGlO4";



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