<?php
	session_start();
	ini_set('display_errors', 1);
	include_once '../../../config/database.php';
	include_once '../../../classes/record.php';
	include_once '../../../classes/barangay.php';

	require '../../../fpdf/fpdf.php';
	include 'pdf_mc_table.php';


	$database = new Database();
	$db = $database->getConnection();

	$record = new Record($db);
	$barangay = new Barangay($db);
    $barangay->readoneGroup();
	$currentdate = date("F d, Y");

	$pdf = new PDF_MC_TABLE();
	$pdf->AddPage();
	$pdf->Image('../../../assets/img/logo.png',85,1,40);
	$pdf->SetFont('Arial','',13);
	$pdf->Ln(10);
    $pdf->Cell(85);
	$pdf->Cell(20,50,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(10);
    $pdf->Cell(80);
    $pdf->SetFont('Arial','B',19);
    $pdf->Cell(30,50,$barangay->brgyname,0,0,'C');
    $pdf->Ln(10);
    $pdf->Cell(80);
    $pdf->SetFont('Arial','',20);
    $pdf->Cell(30,50,'OFFICE OF THE PUNONG BARANGAY',0,0,'C');
	
    // Arial bold 15
    $pdf->SetFont('Arial','B',20);
    // Move to the right
    $pdf->Ln(10);
    $pdf->Cell(80);

	$pdf->Cell(30,50,"Individual Record",0,0,'C');
    // Title
    /*$record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecordPerson();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Cell(30,50,"Fullname: ".$row['fullname2']."",0,0,'C');
		$pdf->Cell(189	,10,'',0,1);//Vertical Spacer
		$pdf->Cell(190,50,"Contact No: ".$row['contactno2'],0,0,'C');
		$pdf->Cell(189	,10,'',0,1);//Vertical Spacer
		$pdf->Cell(190,50,"Address: ".$row['address2'],0,0,'C');
	}*/
    // Line break
    $pdf->Ln(10);
    $pdf->Cell(50);
    $pdf->Ln(1);

	$pdf->SetFont('Arial','B',12);		
	$pdf->AliasNbPages();
	$pdf->Ln(8);
	$pdf->SetFillColor(255,255,0);
	$pdf->SetTextColor(0,0,0);
	//$pdf->SetDrawColor(128,0,0);


	
	$pdf->SetWidths(Array(12,35,23,45,70,20,40,30));//set width for each column

	$pdf->SetLineHeight(5);//height of text lines

	$pdf->SetFont('Arial','',12);

	//make a dummy empty cell as a vertical spacer
	$pdf->Cell(189	,20,'',0,1);//end of line

	$pdf->SetFont('Arial','B',14);
	$record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecordPerson();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Cell(30,10,$row['fullname2'],0,0,);
		$pdf->Cell(30,10,"",0,0);
		$pdf->Cell(20,10,"#:".$row['contactno2'],0,0,);
		$pdf->Cell(45,10,"",0,0);
		$pdf->Cell(30,10,$row['address2'],0,0,);
	}


	$pdf->SetFont('Arial','',12);
	$pdf->Cell(189	,10,'',0,1);//end of line
	$pdf->Cell(12,10,"No.",1,0);
	$pdf->Cell(35,10," Date Recorded ",1,0);
	$pdf->Cell(23,10," Status ",1,0);
	$pdf->Cell(45,10," Reason ",1,0);
	$pdf->Cell(70,10," Recorded By ",1,0);
	
	//$pdf->Cell(15,15," Temp ",1,0);
	
	//$pdf->Cell(40,15," Point of Origin ",1,0);
	//$pdf->Cell(30,15," Destination ",1,0);
	$pdf->ln();
	//loop data
	$record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecord();
	$counter = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Row(Array(
			$counter,
			date("F d, Y",strtotime($row['date'])),
			$row['healthStatus'],
			$row['reason'],
			$row['fullname'],
			//$row['temp'],
			//$row['point'],
			//$row['addressto'],
		));
		$counter++;
	}
	
	//make a dummy empty cell as a vertical spacer
	$pdf->Cell(189	,10,'',0,1);//end of line
	$pdf->Cell(189	,10,'',0,1);//end of line
	$pdf->Cell(189	,10,'',0,1);//end of line
	

	$pdf->Cell(10,20,"Printed By: ".$_SESSION['firstname']." ".$_SESSION['lastname'],0,0);
	$pdf->Cell(22,15,"  ",0,0);
	$pdf->Cell(50,15,"  ",0,0);
	$pdf->Cell(20,15,"",0,0);
	$pdf->Cell(10,20,"Noted by: __________________________",0,0);

	$pdf->Cell(189	,10,'',0,1);//end of line

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,5,"                         ________________________",0,0);
	$pdf->Cell(22,15,"  ",0,0);
	$pdf->Cell(50,15,"  ",0,0);
	$pdf->Cell(20,15,"",0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,15," Signature over Printed Name",0,0);

	$pdf->Cell(189	,10,'',0,1);//end of line

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,-1,"                             Signature over Printed Name",0,0);
	$pdf->Cell(22,15,"  ",0,0);
	$pdf->Cell(52,15,"  ",0,0);
	$pdf->Cell(20,15,"  ",0,0);
	$pdf->SetFont('Arial','',15);
	$pdf->Cell(10,15," ",0,0);

	$pdf->Cell(189	,5,'',0,1);//end of line

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(30,5,"             Date:   $currentdate",0,0);
	$pdf->Cell(22,15,"  ",0,0);
	$pdf->Cell(52,15,"  ",0,0);
	$pdf->Cell(20,15,"  ",0,0);
	$pdf->SetFont('Arial','',15);
	$pdf->Cell(10,15," ",0,0);
	$pdf->ln();
	
	//output pdf
	$pdf->Output();
	$pdf->Footer();//call footer
?>