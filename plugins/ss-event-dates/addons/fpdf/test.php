
<?php
require('eticket.php');
// === CONTENT === //
$title= 'IUFRO ACACIA CONFERENCE 2017';
$venue_name= 'The Alana Yogyakarta Hotel and Convention Center';
$venue_address= 'Jalan Palagan Tentara Pelajar Km 15, Pakem, Sleman, Yogyakarta 55582';
$barcode_number= 2108912;
$barcode_text= 'PROF. RIO BAHTIAR MS.c ';
$barcode = 'ID'.$barcode_number.' | '.$barcode_text;

// === END CONTENT === //




$pdf=new PDF_Code128();
$pdf->AddPage('L','A4');
$pdf->SetFont('Arial','b',13);
$pdf->Cell(90,9,$title,1,0,'C');
$pdf->Cell(110,9,$barcode,1,1,'C');
$pdf->SetFont('Arial','B',15);
$pdf->Cell(200,25,'',1,1,'C');
$pdf->SetFont('Arial','',11);
//B set
$pdf->SetXY(11,20);
$pdf->Write(5,'VENUE');
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(35,27);
$pdf->Write(5,'The Alana Yogyakarta Hotel and Convention Center');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(30,33);
$pdf->Write(5,'Jalan Palagan Tentara Pelajar Km 15, Pakem, Sleman, Yogyakarta 55582');
// End Venue
$pdf->SetXY(10,44);
$pdf->Cell(200,25,'',1,1,'C');

$pdf->SetXY(11,46);
$pdf->Write(5,'DETAILS');

$pdf->Code128(120,47,$barcode_number,80,20);


$pdf->Output();
?>