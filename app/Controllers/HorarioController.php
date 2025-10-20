<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Contratos;
use App\Models\Horarios;
class HorarioController extends BaseController
{
    public function index(): string
    {
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        return view('personas/horario', $datos);
    }

    //Buscamos al trabajador mediante su numero de documento para asignarle su horario
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
