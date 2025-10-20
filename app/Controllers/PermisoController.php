<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Contratos;
use App\Models\Permiso;
use App\Models\Asistencia;
use App\Models\Horarios;
class PermisoController extends BaseController
{
    public function index()
    {
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        return view('asistencia/permiso', $datos);
    }

    
    public function searchByDNI($dni)
        {
            $contratos = new Contratos();

            $contrato = $contratos->getContratoActivoByDNI($dni);

            if ($contrato) {
                return $this->response->setJSON([
                    'success' => true,
                    'persona' => $contrato
                ]);
            }

            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'No se encontró contrato activo para este DNI'
            ]);
    }
    public function registrarPermiso(){
    $permisos = new Permiso();
    $contratos= new Contratos();
    $horarios = new Horarios();
    $asistencias = new Asistencia();

    $dni = $this->request->getPost('dni');
    $horainicio = $this->request->getPost('horainicio');
    $horafin    = $this->request->getPost('horafin');
    $motivo     = $this->request->getPost('motivo');
    $fechasolicitud = $this->request->getPost('fechasolicitud');

    if (!$dni || !$horainicio || !$horafin || !$motivo) {
        return redirect()->back()->with('error', 'Faltan datos obligatorios');
    }

    $contrato = $contratos->getContratoActivoByDNI($dni);
    if (!$contrato) {
        return redirect()->back()->with('error', 'No se encontró contrato activo para este DNI');
    }

    $horario = $horarios->where('idcontrato', $contrato['idcontrato'])->first();
    if (!$horario) {
        return redirect()->back()->with('error', 'No se encontró horario para este contrato el dia de hoy');
    }

    $asistencia = $asistencias
        ->where('idhorario', $horario['idhorario'])
        ->where('diamarcado', $fechasolicitud)
        ->first();

    if (!$asistencia) {
        return redirect()->back()->with('error', 'No existe un registro de asistencia porque el Colaborador no ha marcado Hoy');
    }
    $idasistencia = $asistencia['idasistencia'];

    $permisos->insertarPermiso([
        'horainicio'     => $horainicio,
        'horafin'        => $horafin,
        'motivo'         => $motivo,
        'fechasolicitud' => $fechasolicitud,
        'evidencia'      => null, 
        'idasistencia'   => $idasistencia
    ]);

    return redirect()->to(base_url('asistencia'))->with('success', 'Permiso registrado');
}

}
