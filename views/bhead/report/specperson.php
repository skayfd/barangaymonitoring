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


	$pdf = new PDF_MC_TABLE();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',13);
	$pdf->Ln(10);
    $pdf->Cell(85);
	$pdf->Cell(20,10,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(10);
    $pdf->Cell(80);
    $pdf->SetFont('Arial','B',19);
    $pdf->Cell(30,10,$barangay->brgyname,0,0,'C');
    $pdf->Ln(10);
    $pdf->Cell(80);
    $pdf->SetFont('Arial','',20);
    $pdf->Cell(30,10,'OFFICE OF THE PUNONG BARANGAY',0,0,'C');
    // Arial bold 15
    $pdf->SetFont('Arial','B',14);
    // Move to the right
    $pdf->Ln(10);
    $pdf->Cell(80);
    // Title
    $record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecordPerson();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Cell(30,30,"Person's Name: ".$row['fullname2']."",0,0,'C');
		$pdf->Cell(189	,10,'',0,1);//Vertical Spacer
		$pdf->Cell(190,30,"Contact No: ".$row['contactno2'],0,0,'C');
		$pdf->Cell(189	,10,'',0,1);//Vertical Spacer
		$pdf->Cell(190,30,"Address: ".$row['address2'],0,0,'C');
	}
    // Line break
    $pdf->Ln(10);
    $pdf->Cell(50);
    $pdf->Ln(1);

	$pdf->SetFont('Arial','B',12);		
	$pdf->AliasNbPages();
	$pdf->Ln(8);
	$pdf->SetFillColor(255,255,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(128,0,0);

	$pdf->SetWidths(Array(32,32,13,30,15,40,30));//set width for each column

	$pdf->SetLineHeight(5);//height of text lines

	$pdf->SetFont('Arial','',12);

	//make a dummy empty cell as a vertical spacer
	$pdf->Cell(189	,10,'',0,1);//end of line

	$pdf->Cell(32,15," Added By ",1,0);
	$pdf->Cell(32,15," Date and Time ",1,0);
	$pdf->Cell(13,15," Temp ",1,0);
	$pdf->Cell(30,15," Reason ",1,0);
	$pdf->Cell(15,15," Status ",1,0);
	$pdf->Cell(40,15," Point of Origin ",1,0);
	$pdf->Cell(30,15," Headed to ",1,0);
	$pdf->ln();
	//loop data
	$record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecord();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Row(Array(
			$row['fullname'],
			$row['date'],
			$row['temp'],
			$row['reason'],
			$row['status'],
			$row['point'],
			$row['addressto'],
		));		
	}
	//make a dummy empty cell as a vertical spacer
	$pdf->Cell(189	,10,'',0,1);//end of line
	$pdf->Cell(189	,10,'',0,1);//end of line

	$pdf->Cell(30,15," ",0,0);
	$pdf->Cell(22,15,"  ",0,0);
	$pdf->Cell(50,15,"  ",0,0);
	$pdf->Cell(20,15,"  ",0,0);
	$pdf->Cell(40,15,"__________________________",0,0);

	$pdf->Cell(189	,10,'',0,1);//end of line
	$pdf->Cell(30,15," ",0,0);
	$pdf->Cell(22,15,"  ",0,0);
	$pdf->Cell(52,15,"  ",0,0);
	$pdf->Cell(20,15,"  ",0,0);
	$pdf->Cell(40,15," Signature over Printed Name",0,0);
	$pdf->ln();
	
	//output pdf
	$pdf->Output();
	$pdf->Footer();//call footer
?>