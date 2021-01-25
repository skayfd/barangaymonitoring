<?php
	session_start();
	ini_set('display_errors', 1);
	include_once '../../../config/database.php';
	include_once '../../../classes/record.php';

	require '../../../fpdf/fpdf.php';
	include 'pdf_mc_table.php';


	$database = new Database();
	$db = $database->getConnection();

	$record = new Record($db);
	$barangay = new Barangay($db);
	if($_POST){
		// $pdf->Output();
		$record->sDate = date('Y-m-d', strtotime($_POST['sDate']));
		$record->eDate = date('Y-m-d', strtotime($_POST['eDate']));
		$record->referral = $_POST['referral'];

		$pdf = new PDF_MC_TABLE();
		$pdf->AddPage();
		$pdf->Header1();//call header
		$pdf->SetFont('Arial','B',12);		
		$pdf->AliasNbPages();
		$pdf->Ln(8);
		$pdf->SetFillColor(255,255,0);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(128,0,0);

		$pdf->SetWidths(Array(40,32,60,20,40));//set width for each column

		$pdf->SetLineHeight(5);//height of text lines

		$pdf->Cell(189	,10,'',0,1);//end of line
		//Column Contents
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(45	,5,'Status',1,0);
		$pdf->Cell(25	,5,'Count',1,1);//end of line

		$pdf->SetFont('Arial','',12);
		//APOR
		$pdf->Cell(45	,5,'APOR',1,0);
		$stmt = $record->numAPOR($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,'0',1,1);
			}
			else {
				$pdf->Cell(25	,5,$row['number'],1,1);
			}
		}
		//PUM
		$pdf->Cell(45	,5,'PUM',1,0);
		$stmt = $record->numPUM($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);		
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",1,1);
			}
			else {
				$pdf->Cell(25	,5,$row['number'],1,1);
			}
		}
		//PUI
		$pdf->Cell(45	,5,'PUI',1,0);
		$stmt = $record->numPUI($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",1,1);
			}
			else {
				$pdf->Cell(25	,5,$row['number'],1,1);
			}
		}
		//LSI
		$pdf->Cell(45	,5,'LSI',1,0);
		$stmt = $record->numLSI($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",1,1);
			}
			else {
				$pdf->Cell(25	,5,$row['number'],1,1);
			}
		}

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189	,10,'',0,1);//end of line

		$pdf->Cell(40,15," Full Name ",1,0);
		$pdf->Cell(32,15," Date and Time ",1,0);
		$pdf->Cell(60,15," Reason ",1,0);
		$pdf->Cell(20,15," Status ",1,0);
		$pdf->Cell(40,15," Address ",1,0);
		$pdf->ln();
		//loop data
		$stmt = $record->peopleStatus($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$pdf->Row(Array(
				$row['fullname'],
				$row['datetimerecorded'],
				$row['reason'],
				$row['status'],
				$row['address'],
			));		
		}
		
		//output pdf
		$pdf->Output();
		$pdf->Footer();//call footer
	}
?>