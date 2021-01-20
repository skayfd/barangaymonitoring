<?php
	ini_set('display_errors', 1);
	include_once '../../../config/database.php';
	include_once '../../../classes/record.php';

	require '../../../fpdf/fpdf.php';
	include 'pdf_mc_table.php';


	$database = new Database();
	$db = $database->getConnection();

	$record = new Record($db);
	if($_POST){
		// $record->sDate = date('Y-m-d', strtotime($_POST['sDate']));
		// $record->eDate = date('Y-m-d', strtotime($_POST['eDate']));
		// $record->referral = $_POST['referral'];

		// $pdf = new FPDF('P','mm','A4');
		// $pdf->AliasNbPages();
		// $pdf->AddPage();

		// $pdf->SetFont('Arial','B',30);
		// $pdf->Cell(130	,5,'Number of People',0,1);

		// //make a dummy empty cell as a vertical spacer
		// $pdf->Cell(189	,10,'',0,1);//end of line

		// //set font to arial, regular, 12pt
		// $pdf->SetFont('Arial','B',20);
		// $pdf->Cell(130	,5,date('M/d/Y', strtotime($_POST['sDate'])).' - '.date('M/d/y', strtotime($_POST['eDate'])),0,0);
		// $pdf->Cell(59	,5,'',0,1);//end of line


		// //make a dummy empty cell as a vertical spacer
		// $pdf->Cell(189	,10,'',0,1);//end of line
		// //Column Contents
		// $pdf->SetFont('Arial','B',12);
		// $pdf->Cell(45	,5,'Status',1,0);
		// $pdf->Cell(25	,5,'Count',1,1);//end of line

		// $pdf->SetFont('Arial','',12);
		// //APOR
		// $pdf->Cell(45	,5,'APOR',1,0);
		// $stmt = $record->numAPOR($record->sDate, $record->eDate, $record->referral);
		// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	extract($row);
		// 	if($row['number'] == NULL){
		// 		$pdf->Cell(25	,5,'0',1,1);
		// 	}
		// 	else {
		// 		$pdf->Cell(25	,5,$row['number'],1,1);
		// 	}
		// }
		// //PUM
		// $pdf->Cell(45	,5,'PUM',1,0);
		// $stmt = $record->numPUM($record->sDate, $record->eDate, $record->referral);
		// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	extract($row);		
		// 	if($row['number'] == NULL){
		// 		$pdf->Cell(25	,5,"Empty",1,1);
		// 	}
		// 	else {
		// 		$pdf->Cell(25	,5,$row['number'],1,1);
		// 	}
		// }
		// //PUI
		// $pdf->Cell(45	,5,'PUI',1,0);
		// $stmt = $record->numPUI($record->sDate, $record->eDate, $record->referral);
		// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	extract($row);
		// 	if($row['number'] == NULL){
		// 		$pdf->Cell(25	,5,"Empty",1,1);
		// 	}
		// 	else {
		// 		$pdf->Cell(25	,5,$row['number'],1,1);
		// 	}
		// }
		// //LSI
		// $pdf->Cell(45	,5,'LSI',1,0);
		// $stmt = $record->numLSI($record->sDate, $record->eDate, $record->referral);
		// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	extract($row);
		// 	if($row['number'] == NULL){
		// 		$pdf->Cell(25	,5,"Empty",1,1);
		// 	}
		// 	else {
		// 		$pdf->Cell(25	,5,$row['number'],1,1);
		// 	}
		// }
		// //make a dummy empty cell as a vertical spacer
		// $pdf->Cell(189	,10,'',0,1);//end of line
		
		// $pdf->SetFont('Arial','B',12);
		// $pdf->Cell(0,10,"",0,0,"R");
		// $pdf->Ln(8);
		// $pdf->SetFillColor(255,255,255);
		// $pdf->SetTextColor(0,0,0);
		// $pdf->SetDrawColor(128,0,0);
		// $pdf->SetLineWidth(.3);
		// $pdf->Cell(45,15," Full Name ",1,0,"C",true);
		// $pdf->Cell(20,15," Status ",1,0,"C",true);
		// $pdf->Cell(60,15," Address ",1,0,"C",true);
		// $pdf->SetTextColor(0,0,0);
		// $pdf->SetFont('Arial','',13);
		// $pdf->Ln(15);

		
		// $stmt = $record->peopleStatus($record->sDate, $record->eDate, $record->referral);
		// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	extract($row);		
		// 	$pdf->SetFillColor(255,255,255);
		// 	$pdf->SetTextColor(0);

		// 	$x = $pdf->GetX();
		// 	$y = $pdf->GetY();
		// 	$push_right = 0;
		// 	$pdf->MultiCell($w = 45,10,$row['fullname'],1,0,"C",true);
		// 	$push_right += $w;
		// 	$pdf->SetXY($x + $push_right, $y);

		// 	$pdf->MultiCell($w = 20,10,$row['status'],1,0,"C",true);
		// 	$push_right += $w;
		// 	$pdf->SetXY($x + $push_right, $y);

		// 	$pdf->MultiCell(60,10,$row['address'],1,1,"C",true);

		// }

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