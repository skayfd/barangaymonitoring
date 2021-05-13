<?php
	session_start();
	$title="Tracing";
	include_once '../include/header.php';
	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		header("Location: ../bmember/memhome.php");
	}
	elseif($_SESSION['type'] == 3){
		header("Location: ../request/reqhome.php");
	}

	$database = new Database();
	$db = $database->getConnection();

	$person = new Person($db);
	$record = new Record($db);

	$from = $_POST['date'];
	$date = DateTime::createFromFormat('m/d/Y',$from);
	$from_date = $date->format("Y-m-d");


	if($_POST){
		$person->date = $from_date;
		$person->pid = $_GET['id'];

		$stmt = $person->specPersonTrace($person->date, $person->pid);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			$rdate = $row['dates'];
			$rdest = $row['Destination'];
			$rowrayDate = explode(',',$rdate);
			$rowrayDest = explode(',',$rdest);
			// print_r($rowrayDate);
			echo "
			<br>
			<center><h3>Selected Date: <u class='text-warning'>".$from_date."</u></h3></center>
			<center>
			<div class='card' style='width: 16rem;'>
			  <div class='card-body'>
			    <h3 class='card-title text-dark'>".$row['Name']."</h3><hr>
			    <h5 class='text-dark'>Hours Recorded: </h5>
			    <p class='card-text text-dark'>"; 
			    foreach($rowrayDate AS $dateper){
			    	echo ">".$dateper."<br>";
			    }
			    echo "</p>
			    <hr>
			    <h5 class='text-dark'>Destinations: </h5>
			    <p class='card-text text-dark'>"; 
			    foreach($rowrayDest AS $datedest){
			    	echo ">".$datedest."<br>";
			    }
			    echo "</p>
			  </div>
			</div>
			</center><br>
			";
		}
		//place people on current date here, not automatic but sees date
		$stmt2 = $person->PersonTrace($person->date, $person->pid);
		while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			extract($row2);
			$rdate = $row2['dates'];
			$rdest = $row2['Destination'];
			$rnames = $row2['names'];

			$rowrayDate = explode(',',$rdate);
			$rowrayDest = explode(',',$rdest);
			$rowrayNames = explode(',',$rnames);

			$rowDateDest = array_combine($rowrayDate,$rowrayDest);
			
			print_r($rowDateDest);

			// foreach($rowrayNames AS $name){
			foreach(array_combine($rowrayNames, $rowDateDest) as $name => $datedest){
				
					echo "
					<div class='container'>
					<div class='row'>
						<div class='gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe'>
							<div class='card' style='width: 14rem;'>
							  <div class='card-body'>
							    <h5 class='card-title text-dark'>".$name."</h5>
							    <h5 class='card-title text-dark'>";
							    echo $datedest;//display date and time
							    echo "
							    </h5>
							  </div>
							</div><br>
						</div><br>
					</div>
					</div>
					";
				
			}
		}
	}
?>
<?php
	include_once '../include/footer.php';
?>