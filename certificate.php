<?php
require_once('tcpdf/tcpdf.php');

// Retrieve name and age from cookies
$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : '';
$age = isset($_COOKIE['age']) ? $_COOKIE['age'] : '';

// Create a new PDF instance
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Certificate of Achievement');
$pdf->SetSubject('Certificate');
$pdf->SetKeywords('Certificate, Achievement, PDF');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Certificate', PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Set certificate content
$awardImage = '<img src="award.jpg" alt="Star Award" style="width:200px; height:200px; text-align:center">';
$html = "<div>$awardImage</div>";
$html .= '<h1 style="text-align:center">Certificate of Achievement</h1>';
$html .= '<p style="text-align:center">This is to certify that '.$name.', aged '.$age.', has successfully completed the CHILD WELFARE GAME.</p>';
$html .= '<p style="text-align:center">Given this day of '.date('F j, Y').'</p>';

// Add star award graphic


// Write the HTML content into the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF
$pdf->Output('certificate.pdf', 'D');
?>