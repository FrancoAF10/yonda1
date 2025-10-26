<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Contratos;
use App\Models\Horarios;
/**
 * Controlador de Horarios
 * 
 * Gestiona la asignación y búsqueda de horarios laborales para trabajadores.
 * Permite buscar contratos activos por DNI y asignar horarios semanales
 * con validación de duplicados.
 * 
 * @package App\Controllers
 */
class HorarioController extends BaseController
{
    /**
     * Vista principal de gestión de horarios
     * 
     * Muestra el formulario para buscar trabajadores por DNI
     * y asignar sus horarios laborales semanales.
     * 
     * @return string Vista del formulario de horarios
     */
    public function index(): string
    {
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        return view('personas/horario', $datos);
    }

        /**
         * Busca un trabajador mediante su número de documento
         * 
         *  Realiza una búsqueda del contrato activo asociado al DNI proporcionado.
         * Retorna la información del trabajador en formato JSON si existe,
         * o un error 404 si no se encuentra ningún contrato activo.
         * 
         * @param mixed $dni Número de documento de identidad del trabajador
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
     * Asigna horarios semanales a un trabajador
     * 
     * Procesa el formulario de asignación de horarios permitiendo configurar
     * múltiples días con sus respectivos horarios de entrada, salida y refrigerio.
     * Valida que no existan horarios duplicados antes de insertarlos.
     * 
     * Si se detectan horarios duplicados, los omite y muestra un mensaje
     * con los días que ya tenían ese horario asignado.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function asignarHorario() {
        $horario = new Horarios();
        $rows = $this->request->getPost('row');
        $idcontrato = $this->request->getPost('idcontrato');
        
        // Lista de días duplicados para mostrar en un solo mensaje
        $diasDuplicados = [];

        foreach ($rows as $row) {
            if (!empty($row['checked'])) {
                // Validar que no exista un registro idéntico
                $existe = $horario
                    ->where('idcontrato', $idcontrato)
                    ->where('dia', $row['dia'])
                    ->where('entrada', $row['entrada'])
                    ->where('salida', $row['salida'])
                    ->where('iniciorefrigerio', $row['iniciorefrigerio'])
                    ->where('finrefrigerio', $row['finrefrigerio'])
                    ->first();

                if ($existe) {
                    // Guardamos el día duplicado
                    $diasDuplicados[] = $row['dia'];
                    continue; // Saltamos este registro
                }

                // Insertar horario
                $horario->insert([
                    'idcontrato' => $idcontrato,
                    'dia' => $row['dia'],
                    'entrada' => $row['entrada'],
                    'salida' => $row['salida'],
                    'iniciorefrigerio' => $row['iniciorefrigerio'],
                    'finrefrigerio' => $row['finrefrigerio']
                ]);
            }
        }

        // Si hubo días duplicados, mostramos un mensaje de error
        if (!empty($diasDuplicados)) {
            $mensaje = "El horario ya existe para los días: " . implode(", ", $diasDuplicados);
            session()->setFlashdata('error', $mensaje);
        }

        return redirect()->to(base_url("personas/horario"));
    }

}
