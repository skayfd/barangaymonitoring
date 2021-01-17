<?php
	include_once '../../../config/database.php';
	include_once '../../../classes/record.php';

	require '../../../fpdf/fpdf.php';
	include 'pdf_mc_table.php';


	$database = new Database();
	$db = $database->getConnection();

	$record = new Record($db);
	if($_POST){
		$record->sDate = date('Y-m-d', strtotime($_POST['sDate']));
		$record->eDate = date('Y-m-d', strtotime($_POST['eDate']));

		$pdf = new PDF_MC_TABLE();
		$pdf->AddPage();
		$pdf->Header1();//call header
		$pdf->SetFont('Arial','B',12);		
		$pdf->AliasNbPages();
		$pdf->Ln(8);
		$pdf->SetFillColor(255,255,0);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(128,0,0);

		$pdf->SetWidths(Array(45,40,65,40));//set width for each column

		$pdf->SetLineHeight(5);//height of text lines

		$pdf->Cell(45,15," Full Name ",1,0);
		$pdf->Cell(40,15," Date and Time ",1,0);
		$pdf->Cell(65,15," Reason ",1,0);
		$pdf->Cell(40,15," Status ",1,0);
		$pdf->ln();
		//loop data
		$stmt = $record->fromToDate($record->sDate, $record->eDate);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$pdf->Row(Array(
				$row['fullname'],
				$row['datetimerecorded'],
				$row['reason'],
				$row['status'],
			));		
		}
		//output pdf
		$pdf->Output();
		$pdf->Footer();//call footer
	}
?>