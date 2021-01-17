<?php
	class Database{
	//LOCAL Connection
	private	$host = "localhost";
	private $dbName = "monitoring";
	private	$userName = "root";
	private $password = "";

	//Deployment Connection
	// private	$host = "remotemysql.com";//from remotemysql.com
	// private $dbName = "iluUDmXZz2";
	// private	$userName = "iluUDmXZz2";
	// private $password = "sd1Flri7PH";

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