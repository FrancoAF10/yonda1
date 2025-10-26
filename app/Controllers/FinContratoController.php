<?php
namespace App\Controllers;

use App\Models\Contratos;
use App\Models\Personas;
use App\Models\FinContrato;
/**
 * Controlador de Finalización de Contratos
 * 
 * Gestiona el proceso de terminación de contratos laborales,
 * incluyendo despidos y finalizaciones con registro de motivos,
 * severidad y evidencias. Actualiza el estado del contrato a 'Inactivo'.
 * 
 * @package App\Controllers
 */
class FinContratoController extends BaseController
{
    /**
     * Vista principal para finalizar contrato de un trabajador
     * 
     * Carga la información del trabajador y su contrato más reciente
     * para mostrar el formulario de finalización/despido.
     * Obtiene el último contrato registrado ordenado por ID descendente.
     * 
     * @param mixed $idpersona ID del trabajador cuyo contrato se va a finalizar
     * 
     * @return string Vista del formulario de finalización de contrato
     */
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

    /**
     * Registra la finalización/despido del contrato
     * 
     * Procesa el formulario de finalización de contrato realizando dos operaciones:
     * 1. Actualiza el estado del contrato a 'Inactivo' en la tabla contratos
     * 2. Inserta el registro de finalización con motivo, descripción, severidad y evidencia
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface  Redirección a la lista de personas
     */
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
