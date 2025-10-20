<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;
use App\Models\Personas;
use App\Models\Contratos;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use function PHPUnit\Framework\returnArgument;


class ReporteController extends BaseController{


  public function getReport1($idpersona){

    $personas = new Personas();
    $data = [
      'personas' =>$personas->Vista_Info($idpersona)
    ];

    $html = view('personas/reporte',$data);

    try{
      $html2PDF = new Html2Pdf('P','A4','es',true,'UTF-8',[20,10,10,10]);
      $html2PDF->writeHTML($html);

      $this->response->setHeader('Content-type','application/pdf');
      $html2PDF->output('Reporte-superhero-publisher.pdf');
      exit();
    }catch(Html2PdfException $e){
      $html2PDF->clean();
      $formatter = new ExceptionFormatter($e);
      echo $formatter->getMessage();

    }

  }
}