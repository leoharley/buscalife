<?php

class Excel
{

    private $excel;

    public function __construct()
    {
        require_once APPPATH.'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
        $this->excel->getDefaultStyle()->applyFromArray(array(
            'borders' => array(
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                                      'color' => array('rgb' => PHPExcel_Style_Color::COLOR_BLACK)
                )
            )
        ));
    }

    public function load($path)
    {
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $this->excel = $objReader->load($path);
    }

    public function loadHtml($tmpFile)
    {
        $reader = new PHPExcel_Reader_HTML;
        $this->excel = $reader->load($tmpFile);
    }

    public function save($path)
    {
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save($path);
    }

    public function stream($filename)
    {
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
        header("Cache-control: private");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function  __call($name, $arguments)
    {
        if (method_exists($this->excel, $name)) {
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }
}

?>