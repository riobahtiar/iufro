<?php 
/*
* PDF Ticket for Member
* @author Rio Bahtiar 
* Output Folder PDF : wp-content/uploads/ticket
* Output Folder Barcode PNG : wp-content/uploads/barcode
*/

// ========= Include PDF Lib & Barcode Lib ========= //
require_once( IUFRO_DIR . 'addons/fpdf/fpdf.php' );
require_once( IUFRO_DIR . 'addons/barcode/src/BarcodeGenerator.php' );
require_once( IUFRO_DIR . 'addons/barcode/src/BarcodeGeneratorPNG.php' );


// $pdf = new FPDF('P', 'pt', array(500,233));
// $pdf->AddFont('Helvetica','','helvetica.php');
// $pdf->AddPage();
// $pdf->Image(WP_CONTENT_DIR.'/uploads/2016/07/Ministry-of-Environment-and-Forestry-Logo.png',0,0,500);
// $pdf->SetFont('helvetica','',16);
// $pdf->Cell(40,10,'Hello World!');
// // attachment name

// // encode data (puts attachment in proper format)
// $pdfdoc = $pdf->Output("Testing_21.pdf", "S");
// $theattachment = array( chunk_split(base64_encode($pdfdoc)) );

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
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
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();