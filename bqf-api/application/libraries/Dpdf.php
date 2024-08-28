<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once APPPATH . '/third_party/dompdf/lib/html5lib/Parser.php';
//require_once APPPATH . '/third_party/dompdf/src/Autoloader.php';
require_once(APPPATH . '/libraries/dompdf/dompdf_config.inc.php');

use \Dompdf\Dompdf;

class Dpdf
{

    public function __construct()
    {
        \Dompdf\Autoloader::register();
    }

    public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = "portrait")
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $dompdf = new DOMPDF();
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }

    public function setTextoInicioFooter($texto)
    {
        $this->textoInicio = $texto;
    }

    public function setTextoFimFooter($texto)
    {
        $this->textoFim = $texto;
    }

    // Page footer
    public function footer()
    {

    }
}