<?php
	include_once '../../../config/database.php';
	include_once '../../../classes/record.php';

	require '../../../fpdf/fpdf.php';
	include 'pdf_mc_table.php';


	$database = new Database();
	$db = $database->getConnection();

	$record = new Record($db);

	$pdf = new PDF_MC_TABLE();
	$pdf->AddPage();

	// Logo
    $pdf->Image('../../../assets/img/logo.png',90,6,30);
    // Arial bold 15
    $pdf->SetFont('Arial','B',20);
    // Move to the right
    $pdf->Cell(80);
    // Title
    $record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecordPerson();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Cell(30,60,$row['fullname2']."'s Records",0,0,'C');
	}
    // Line break
    $pdf->Ln(10);
    $pdf->Cell(50);
    $pdf->Ln(13);

	$pdf->SetFont('Arial','B',12);		
	$pdf->AliasNbPages();
	$pdf->Ln(8);
	$pdf->SetFillColor(255,255,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(128,0,0);

	$pdf->SetWidths(Array(40,32,60,20,40));//set width for each column

	$pdf->SetLineHeight(5);//height of text lines

	$pdf->SetFont('Arial','',12);

	//make a dummy empty cell as a vertical spacer
	$pdf->Cell(189	,10,'',0,1);//end of line

	$pdf->Cell(40,15," Added By ",1,0);
	$pdf->Cell(32,15," Date and Time ",1,0);
	$pdf->Cell(60,15," Reason ",1,0);
	$pdf->Cell(20,15," Status ",1,0);
	$pdf->Cell(40,15," Point of Origin ",1,0);
	$pdf->ln();
	//loop data
	$record->pid = $_GET['id'];
	$stmt = $record->readrelatedRecord();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$pdf->Row(Array(
			$row['fullname'],
			$row['date'],
			$row['reason'],
			$row['status'],
			$row['point'],
		));		
	}
	//output pdf
	$pdf->Output();
	$pdf->Footer();//call footer
?>