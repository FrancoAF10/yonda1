<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Licencias;
/**
 * Controlador de Licencias
 * 
 * Gestiona el registro de licencias laborales para trabajadores,
 * incluyendo licencias con o sin goce de haber, según el motivo
 * y las fechas especificadas.
 * 
 * @package App\Controllers
 */
class LicenciasController extends BaseController{
    /**
     * Registra una nueva licencia laboral
     * 
     * Procesa el formulario de solicitud de licencia y registra la información
     * en la base de datos, incluyendo el tipo de licencia (con o sin goce),
     * fechas, evidencias y el estado de la solicitud.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface Redirección a la vista de otros datos del trabajador
     */
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