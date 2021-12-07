<?php
//call main fpdf file
// require('../../../fpdf/fpdf.php');
include_once '../../../classes/barangay.php';
include_once '../../../config/database.php';



//create new class extending fpdf class
class PDF_MC_Table extends FPDF {

// variable to store widths and aligns of cells, and line height
var $widths;
var $aligns;
var $lineHeight;

    // Page header
    function Header1()
    {
        $database = new Database();
        $db = $database->getConnection();
        $barangay = new Barangay($db);
        $barangay->readoneGroup();

        // Arial bold 15
        $this->SetFont('Arial','',13);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,70,'Republic of the Philippines',0,0,'C');
        $this->Ln(10);
        $this->Cell(80);
        $this->SetFont('Arial','B',19);
        $this->Cell(30,70,$barangay->brgyname,0,0,'C');
        $this->Ln(10);
        $this->Cell(80);
        $this->SetFont('Arial','',20);
        $this->Cell(30,70,'OFFICE OF THE PUNONG BARANGAY',0,0,'C');
        // Line break
        $this->Ln(10);
        $this->Cell(80);
        $this->SetFont('Arial','B',20);
        $this->Cell(30,70,'List of death',0,0,'C');
        $this->Ln(10);
        $this->Cell(80);
        $this->SetFont('Arial','',15);
        $this->Cell(30,70,date('M d, Y', strtotime($_POST['sDate'])).' - '.date('M d, Y', strtotime($_POST['eDate'])),0,0,'C');
        $this->Ln(33);
    }
    function Header2()
    {
        // Logo
        $this->Image('../../../assets/img/logo.png',85,1,40);
        // Arial bold 15
       // $this->SetFont('Arial','B',20);
        // Move to the right
        //$this->Cell(80);
        // Title
        //$this->Cell(30,60,'',0,0,'C');
        // Line break
       // $this->Ln(10);
       // $this->Cell(80);
        //$this->Cell(30,70,'Placeholder Title',0,0,'C');
        //$this->Ln(33);
    }
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

//Set the array of column widths
function SetWidths($w){
    $this->widths=$w;
}

//Set the array of column alignments
function SetAligns($a){
    $this->aligns=$a;
}

//Set line height
function SetLineHeight($h){
    $this->lineHeight=$h;
}

//Calculate the height of the row
function Row($data)
{
    // number of line
    $nb=0;

    // loop each data to find out greatest line number in a row.
    for($i=0;$i<count($data);$i++){
        // NbLines will calculate how many lines needed to display text wrapped in specified width.
        // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    }
    
    //multiply number of line with line height. This will be the height of current row
    $h=$this->lineHeight * $nb;

    //Issue a page break first if needed
    $this->CheckPageBreak($h);

    //Draw the cells of current row
    for($i=0;$i<count($data);$i++)
    {
        // width of the current col
        $w=$this->widths[$i];
        // alignment of the current col. if unset, make it left.
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //calculate the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>