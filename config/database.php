<?php
	class Database{
	//LOCAL Connection
	// private	$host = "localhost";
	// private $dbName = "monitoring";
	// private	$userName = "root";
	// private $password = "";

	//Deployment Connection
	private	$host = "remotemysql.com";//from remotemysql.com
	private $dbName = "iluUDmXZz2";
	private	$userName = "iluUDmXZz2";
	private $password = "sd1Flri7PH";

	//Deployment Connection for 000webhosting
	private	$host = "localhost";//from remotemysql.com
	private $dbName = "id15884170_monitoring";
	private	$userName = "id15884170_barangaymonitoring";
	private $password = "O>wMO0=]@y4Xz6^>";

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