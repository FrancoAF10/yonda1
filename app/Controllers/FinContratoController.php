<?php
namespace App\Controllers;

use App\Models\Contratos;
use App\Models\Personas;
use App\Models\FinContrato;

class FinContratoController extends BaseController
{
    public function indexDespido($idpersona){
        $personas = new Personas();
        $contratos= new Contratos();
        
        $datos['trabajador'] = $personas->Vista_Info($idpersona);
        $datos['contrato'] = $contratos
        ->where('idpersona', $idpersona)
        ->orderBy('idcontrato', 'DESC') 
        ->first();

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");

        return view("personas/borrar", $datos);
    }


    public function registrarDespido(){

        $terminocontrato= new FinContrato();
        $idcontrato    = $this->request->getVar('idcontrato');

        $terminocontrato->query(
            "UPDATE contratos 
            SET estado = 'Inactivo'
            WHERE idcontrato = ?",
            [$idcontrato]
        );
        $data=[
        'motivo'=>$this->request->getPost('motivo'),
        'descripcion'=>$this->request->getPost('descripcion'),
        'severidad'=>$this->request->getPost('severidad'),
        'evidencia'=>$this->request->getPost('evidencia'),
        'fecharegistro'=>$this->request->getPost('fecharegistro'),
        'idcontrato'=>$this->request->getPost('idcontrato')
        ];

        $terminocontrato->insert($data);
        return $this->response->redirect(base_url("personas"));
            
    } 


}
