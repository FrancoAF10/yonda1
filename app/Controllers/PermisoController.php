<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Contratos;
use App\Models\Permiso;
use App\Models\Asistencia;
use App\Models\Horarios;
/**
 * Controlador de Permisos Laborales
 * 
 * Gestiona el registro de permisos de salida durante la jornada laboral.
 * Valida que el trabajador tenga contrato activo, horario asignado y
 * asistencia registrada antes de aprobar el permiso.
 * 
 * @package App\Controllers
 */
class PermisoController extends BaseController
{
    /**
     * Vista principal de registro de permisos
     * 
     * Muestra el formulario para registrar permisos de salida
     * durante la jornada laboral de los trabajadores.
     * 
     * @return string Vista del formulario de permisos
     */
    public function index()
    {
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        return view('asistencia/permiso', $datos);
    }

    /**
     * Busca un trabajador por su número de documento
     * 
     * Realiza una búsqueda del contrato activo asociado al DNI proporcionado
     * para validar que el trabajador puede solicitar un permiso.
     * Retorna la información del trabajador en formato JSON.
     * 
     * @param mixed $dni Número de documento de identidad del trabajador
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con datos del trabajador o error
     */
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
    /**
     * Registra un nuevo permiso laboral
     * 
     * Procesa el formulario de solicitud de permiso realizando las siguientes validaciones:
     * 1. Verifica que todos los campos obligatorios estén completos
     * 2. Valida que el trabajador tenga un contrato activo
     * 3. Verifica que el trabajador tenga un horario asignado
     * 4. Confirma que el trabajador haya marcado asistencia el día de la solicitud
     * 
     * Si todas las validaciones son exitosas, registra el permiso asociado
     * a la asistencia del día correspondiente.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de éxito o error
     */
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
