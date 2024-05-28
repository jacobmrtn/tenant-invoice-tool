<?php
require_once('TCPDF\examples\tcpdf_include.php');

$post_info = json_decode(file_get_contents('php://input'), true);

if(isset($post_info['file_name'])) {
    $file_name = $post_info['file_name'];
} else {
    echo 'Error';
    die();
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set header and footer fonts
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('helvetica', '', 12);


$pdf->AddPage();
$pdf->setCellPadding("0");
// set page margins
$tagvs = array('h3' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)), 'p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
$pdf->setHtmlVSpace($tagvs);

$html = file_get_contents(dirname(__DIR__). '/Includes/Templates/print.php');
$pdf->writeHTML($html, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output(dirname(__DIR__). '/Invoices/' .$file_name. '.pdf', 'F');
