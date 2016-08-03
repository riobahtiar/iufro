
<?php
require('eticket.php');
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
// === CONTENT === //
$title= 'IUFRO ACACIA CONFERENCE 2017';
$barcode_number= 83332666212154;
$barcode_text= 'PROF. RIO BAHTIAR MS.c ';
$barcode = 'ID'.$barcode_number.' | '.$barcode_text;
$upload_dir = wp_upload_dir();
// === END CONTENT === //

// Setting Page
$pdf=new PDF_Code128();
$pdf->AddPage('P','A4');
// Barcode
$pdf->Cell(28,115,'',1,0,'C');
$pdf->Rotate(90,88,120);
$pdf->Code128(100,46,$barcode_number,90,15);
$pdf->Rotate(0);
$pdf->SetFont('Arial','B',14);
$pdf->RotatedText(36,80,'ID 54545454',90);
$pdf->Cell(160,30,'',1,0,'C');
$pdf->Image('http://staging.iufroacacia2017.com/wp-content/uploads/2016/06/logo.png',146,17,50);
$pdf->SetFont('Arial','B',15);
$pdf->SetXY(45,23);
$pdf->Write(5,$title);
$pdf->SetXY(39,11);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,'EVENT');
$pdf->SetXY(38,40);
$pdf->Cell(80,30,'',1,0,'C');
$pdf->Cell(80,30,'',1,0,'C');
$pdf->SetXY(39,41);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,'DATE');
$pdf->SetXY(49,52);
$pdf->Write(5,'24 July 2017 - 28 July 2017');
$pdf->SetXY(119,41);
$pdf->Write(5,'VENUE');
$pdf->SetXY(128,47);
$pdf->SetFont('Arial','B',12);
$pdf->Write(5,'The Alana Yogyakarta Hotel');
$pdf->SetXY(133,52);
$pdf->Write(5,'and Convention Center');
$pdf->SetFont('Arial','',12);
$pdf->SetXY(123,58);
$pdf->Write(5,'Jalan Palagan Tentara Pelajar Km 15,');
$pdf->SetXY(125,64);
$pdf->Write(5,'Pakem, Sleman, Yogyakarta 55582');
$pdf->SetXY(38,70);
$pdf->Cell(160,55,'',1,0,'C');


$pdf->SetXY(39,71);
$pdf->Write(5,'DETAILS');
$pdf->SetXY(45,79);
$pdf->Write(5,'Full Name : ');
$pdf->SetXY(45,85);
$pdf->Write(5,'Address : ');
$pdf->SetXY(45,91);
$pdf->Write(5,'Membership Type : ');
$pdf->SetXY(45,97);
$pdf->Write(5,'Field Trip :');
$pdf->SetXY(47,104);
$pdf->Write(5,' ~ Mid Conference : ');
$pdf->SetXY(47,110);
$pdf->Write(5,' ~ Post Conference : ');
$pdf->SetXY(45,116);
$pdf->Write(5,' Dinner Conference : ');

$pdf->SetXY(50,200);
$pdf->SetFont('Arial','',10);
$pdf->Write(5,'generated by system on '.date('Y-m-d H:i:s T'));


$filename=$upload_dir['basedir']."/dumpticket/testrio.pdf";
$pdf->Output($filename,'F');


?>