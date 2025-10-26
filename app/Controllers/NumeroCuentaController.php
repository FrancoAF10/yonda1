<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\NumeroCuenta;
/**
 * Controlador de Números de Cuenta Bancaria
 * 
 * Gestiona las cuentas bancarias de los trabajadores, permitiendo
 * el registro de nuevas cuentas y el cierre automático de cuentas
 * anteriores cuando se asigna una nueva.
 * 
 * @package App\Controllers
 */
class NumeroCuentaController extends BaseController
{
    /**
     * Crea una nueva cuenta bancaria para un trabajador
     * 
     * Este método realiza dos operaciones:
     * 1. Cierra la cuenta bancaria anterior del trabajador estableciendo su fecha de fin
     * 2. Inserta la nueva cuenta bancaria con la información proporcionada
     * 
     * Solo puede existir una cuenta activa (fechafin = NULL) por trabajador.
     * Al crear una nueva cuenta, la anterior se cierra automáticamente.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con estado y lista actualizada de cuentas
     */
    public function crear()
    {
        $numerocuenta = new NumeroCuenta();

        $idpersona = $this->request->getVar('idpersona');
        $fechaInicio = $this->request->getVar('fechainicio');

        // Cerrar la cuenta anterior (si existe)
        $numerocuenta->query(
            "UPDATE numerocuenta 
            SET fechafin = ? 
            WHERE idpersona = ? AND fechafin IS NULL",
            [$fechaInicio, $idpersona]
        );

        //insertar nueva cuenta
        $data = [
            "tipomoneda" => $this->request->getVar('tipomoneda'),
            "tipoinstitucion" => $this->request->getVar('tipoinstitucion'),
            "nombre" => $this->request->getVar('nombre'),
            "numcuenta" => $this->request->getVar('numcuenta'),
            "cci" => $this->request->getVar('cci'),
            "fechainicio" => $fechaInicio,
            "fechafin" => null,
            "idpersona" => $idpersona
        ];

        $numerocuenta->insert($data);
        $cuentas = $numerocuenta->getnumerocuenta($idpersona);

        return $this->response->setJSON(['status' => 'ok', 'cuentas' => $cuentas]);
    }

}
