<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contratos;
use App\Models\Personas;
use Exception;
use App\Models\Planilla;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use function PHPUnit\Framework\returnArgument;


class PlanillaController extends BaseController{

  public function pagos(){
    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    //return view('administrativo/planilla',$data);
    echo view('plantillas/pagos',$datos);
    
  }

  public function pdfplanilla(){


    $personas = new Personas();
    $contratos = new Contratos();

    $data =[
        'personas' =>$personas->findAll(),
        'contratos' =>$contratos->findAll()
    ];

    $html = view('administrativo/pdfplanilla',$data);

    try{
      $html2PDF = new Html2Pdf('L','A4','es',true,'UTF-8',[20,10,10,10]);
      $html2PDF->writeHTML($html);

      $this->response->setHeader('Content-type','application/pdf');
      $html2PDF->output('pdfplanilla.pdf');
      exit();
    }catch(Html2PdfException $e){
      $html2PDF->clean();
      $formatter = new ExceptionFormatter($e);
      echo $formatter->getMessage();

    }

  }
}