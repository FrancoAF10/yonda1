<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Licencias;

class LicenciasController extends BaseController{
    public function registrar(){
        $licencias=new Licencias();

        $conGoce=$this->request->getVar('conGoce');
        $fechainicio=$this->request->getVar('fechainicio');
        $fechafin=$this->request->getVar('fechafin');
        $evidencia=$this->request->getVar('evidencia');
        $estado=$this->request->getVar('estado');
        $fechasolicitud=$this->request->getVar('fechasolicitud');
        $idcontrato=$this->request->getVar('idcontrato');
        $idmotivolic=$this->request->getVar('idmotivolic');

        $data=[
            "conGoce"       =>$conGoce,
            "fechainicio"   =>$fechainicio,
            "fechafin"      =>$fechafin,
            "evidencia"     =>$evidencia,
            "estado"        =>$estado,
            "fechasolicitud"=>$fechasolicitud,
            "idcontrato"    =>$idcontrato,
            "idmotivolic"   =>$idmotivolic,         
        ];

        $licencias->insert($data);
        return $this->response->redirect(base_url('Administrativo/Trabajadores/Otros'));

    }

}