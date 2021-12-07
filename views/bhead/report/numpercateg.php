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
	$currentdate = date("F d, Y");
	if($_POST){
		// $pdf->Output();
		$record->sDate = date('Y-m-d', strtotime($_POST['sDate']));
		$record->eDate = date('Y-m-d', strtotime($_POST['eDate']));
		$record->referral = $_POST['referral'];

		$pdf = new PDF_MC_TABLE();
		$pdf->AddPage();
		$pdf->Header1();//call header
        $pdf->Header2();//call header
		$pdf->SetFont('Arial','B',12);		
		$pdf->AliasNbPages();
		//$pdf->Ln(8);
		//$pdf->SetFillColor(255,255,0);
		$pdf->SetTextColor(0,0,0);
		//$pdf->SetDrawColor(128,0,0);


		//PUI
		$pdf->SetWidths(Array(10,60,40,50,20,12));//set width for each column
		$pdf->SetLineHeight(5);//height of text lines
		$pdf->Cell(189	,20,'',0,1);//end of line
		
        $pdf->SetFont('Arial','B',15);
		$pdf->Cell(30	,5,'Status: PUI',0,0);
		$pdf->SetFont('Arial','',13);
		$pdf->Cell(15,5,'Count:',0,0);
		$stmt = $record->numPUI($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",0,0);
			}
			else {
				$pdf->Cell(25	,5, $row['number'],0,0);
			}
		}
		
      
		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189	,7,'',0,1);//end of line

        //$pdf->SetWidths(Array(00,00,00,00,00,00));//set width for each column
		$pdf->SetFont('Arial','B',12);
		
		$pdf->Cell(10,10,"No.",1,0);
		$pdf->Cell(60,10," Full Name ",1,0);
		$pdf->Cell(40,10,"Date Recorded",1,0);
		$pdf->Cell(50,10," Recorded By ",1,0);
		
		$pdf->ln();
		//loop data
        $pdf->SetFont('Arial','',12);
		$stmt = $record->peopleStatusPUI($record->sDate, $record->eDate, $record->referral);
		$counter = 1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$pdf->Row(Array(
				$counter,
				$row['fullname2'],
				date("F d, Y",strtotime($row['date'])),
				$row['fullname1'],
			));
			$counter++;		
		}



		//PUM
		$pdf->SetWidths(Array(40,40,26,60,20,12));//set width for each column
		$pdf->SetLineHeight(5);//height of text lines
		$pdf->Cell(189	,10,'',0,1);//end of line
		
        $pdf->SetFont('Arial','B',15);
		$pdf->Cell(35	,5,'Status: PUM',0,0);
		$pdf->SetFont('Arial','',13);
		$pdf->Cell(15,5,'Count:',0,0);
		$stmt = $record->numPUM($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",0,0);
			}
			else {
				$pdf->Cell(25	,5, $row['number'],0,0);
			}
		}
		
      
		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189	,7,'',0,1);//end of line

        $pdf->SetWidths(Array(10,60,40,50,20,12));//set width for each column
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10,10,"No.",1,0);
		$pdf->Cell(60,10," Full Name ",1,0);
		$pdf->Cell(40,10,"Date Recorded",1,0);
		$pdf->Cell(50,10," Recorded By ",1,0);
		$pdf->ln();
		//loop data
        $pdf->SetFont('Arial','',12);
		$stmt = $record->peopleStatusPUM($record->sDate, $record->eDate, $record->referral);
		$counter = 1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$pdf->Row(Array(
				$counter,
				$row['fullname2'],
				date("F d, Y",strtotime($row['date'])),
				$row['fullname1'],
			));
			$counter++;		
		}

		//Recovered
		$pdf->SetWidths(Array(40,40,26,60,20,12));//set width for each column
		$pdf->SetLineHeight(5);//height of text lines
		$pdf->Cell(189	,10,'',0,1);//end of line
		
        $pdf->SetFont('Arial','B',15);
		$pdf->Cell(50,5,'Status: Recovered',0,0);
		$pdf->SetFont('Arial','',13);
		$pdf->Cell(15,5,'Count:',0,0);
		$stmt = $record->numREC($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",0,0);
			}
			else {
				$pdf->Cell(25	,5, $row['number'],0,0);
			}
		}
		
      
		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189	,7,'',0,1);//end of line

        $pdf->SetWidths(Array(10,60,40,50,20,12));//set width for each column
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10,10,"No.",1,0);
		$pdf->Cell(60,10," Full Name ",1,0);
		$pdf->Cell(40,10,"Date Recorded",1,0);
		$pdf->Cell(50,10," Recorded By ",1,0);
		$pdf->ln();
		//loop data
        $pdf->SetFont('Arial','',12);
		$stmt = $record->peopleStatusREC($record->sDate, $record->eDate, $record->referral);
		$counter = 1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$pdf->Row(Array(
				$counter,
				$row['fullname2'],
				date("F d, Y",strtotime($row['date'])),
				$row['fullname1'],
			));
			$counter++;		
		}

		//Death
		$pdf->SetWidths(Array(40,40,26,60,20,12));//set width for each column
		$pdf->SetLineHeight(5);//height of text lines
		$pdf->Cell(189	,10,'',0,1);//end of line
		
        $pdf->SetFont('Arial','B',15);
		$pdf->Cell(35	,5,'Status: Death',0,0);
		$pdf->SetFont('Arial','',13);
		$pdf->Cell(15,5,'Count:',0,0);
		$stmt = $record->numDEC($record->sDate, $record->eDate, $record->referral);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['number'] == NULL){
				$pdf->Cell(25	,5,"Empty",0,0);
			}
			else {
				$pdf->Cell(25	,5, $row['number'],0,0);
			}
		}
		
      
		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189	,7,'',0,1);//end of line

        $pdf->SetWidths(Array(10,60,40,50,20,12));//set width for each column
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10,10,"No.",1,0);
		$pdf->Cell(60,10," Full Name ",1,0);
		$pdf->Cell(40,10,"Date Recorded",1,0);
		$pdf->Cell(50,10," Recorded By ",1,0);
		$pdf->ln();
		//loop data
        $pdf->SetFont('Arial','',12);
		$stmt = $record->peopleStatusDEC($record->sDate, $record->eDate, $record->referral);
		$counter = 1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$pdf->Row(Array(
				$counter,
				$row['fullname2'],
				date("F d, Y",strtotime($row['date'])),
				$row['fullname1'],
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
	}
?>