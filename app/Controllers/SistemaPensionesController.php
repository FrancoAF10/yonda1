<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SistemaPensiones;
/**
 * Controlador para gestionar las operaciones del sistema de pensiones
 * 
 *  Maneja la creación y actualización de registros de afiliación al sistema
 * de pensiones (AFP y ONP) de los empleados.
 * 
 * @package App\Controllers
 */
class SistemaPensionesController extends BaseController
{
    /**
     * Crea un nuevo registro de afiliación al sistema de pensiones
     * 
     * Este método realiza dos operaciones principales:
     * 1. Cierra (finaliza) cualquier afiliación activa anterior del empleado
     *    estableciendo la fecha de término con la fecha de la nueva afiliación
     * 2. Crea un nuevo registro de afiliación al sistema de pensiones
     * 
     * El proceso asegura que solo exista una afiliación activa por persona,
     * manteniendo el historial de afiliaciones anteriores.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function crear()
    {

        $sispensiones = new SistemaPensiones();

        $idpersona = $this->request->getVar('idpersona');
        $fechaAfiliacion = $this->request->getVar('fechaafiliacion');
        $sispensiones->query(
            "UPDATE sispensiones 
            SET fechatermino = ? 
            WHERE idpersona = ? AND fechatermino IS NULL",
            [$fechaAfiliacion, $idpersona]
        );

        $data = [
            "tiposistema" => $this->request->getVar('tiposistema'),
            "nombresistema" => $this->request->getVar('nombresistema'),
            "fechaafiliacion" => $this->request->getVar('fechaafiliacion'),
            "fechatermino" => null,
            "cuspp" => $this->request->getVar('cuspp'),
            "idpersona" => $this->request->getVar('idpersona')
        ];
        $sispensiones->insert($data);
        $sistemapensiones = $sispensiones->getsistemapensiones($idpersona);

        return $this->response->setJSON(['status' => 'ok', 'sispensiones' => $sistemapensiones]);
    }
}
