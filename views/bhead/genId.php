<?php
	session_start();
	require '../../fpdf/fpdf.php';

	include_once "../../config/database.php";
	include_once "../../classes/person.php";
	include_once "../../classes/record.php";
	include_once "../../classes/history.php";

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

	//id of person
	$id = $_GET['id'];
	$person->pid = $id;

	$passidimage = "../../assets/img/passid.png";

	$pdf = new FPDF('P', 'mm', 'A4' );
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(128,0,0);

	//rectangle Startx, starty, width, height
	$pdf->Rect(40, 20, 129, 80, 'DF');

	//margin
	$pdf->SetLeftMargin(45);

	//info
	$pdf->Ln(15);
	// $pdf->Cell(30,5,"PASS ID",0,1);
	$pdf->Cell(28,5,"",0,0);//space before pass id
	$pdf->Cell(40,18, $pdf->Image($passidimage, $pdf->GetX(), $pdf->GetY(), 70.78), 0, 1, 'L', false );


	$pdf->Cell(30,10,"Identification No: ".$id."",0,1);

	$person->readspecPerson($person->pid);
	$pdf->Cell(30,9,"Name: ".$person->firstname." ".$person->lastname."",0,1);
    $pdf->Cell(21,9,"Address: ",0,0);
    $pdf->Cell(30,9,"_____________________________________",0,1);

    $stmt = $person->readPerBarangay();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    	extract($row);
    	$pdf->Cell(71,8,"Barangay: ".$row['barname']."",0,1);
    }
    $pdf->Cell(64,8,"",0,0);
    $pdf->Cell(30,8,"____________________",0,1);
    $pdf->Cell(59,8,"",0,0);
    $pdf->Cell(30,8,"Signature over Printed Name",0,0);
	$pdf->ln();

	//output pdf
	$pdf->Output();
?>