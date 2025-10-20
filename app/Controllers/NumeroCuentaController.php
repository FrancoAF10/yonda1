<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\NumeroCuenta;
class NumeroCuentaController extends BaseController
{

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
