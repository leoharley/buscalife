<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
//use Dompdf\Options;

class Pdfgenerator {

  public function generate($html, $filtro, $filename='', $stream=TRUE, $paper = 'A2', $orientation = "landscape")
  {
	$data = new DateTime();
    $dompdf = new DOMPDF();
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream("notatecnicasaps.pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }
}