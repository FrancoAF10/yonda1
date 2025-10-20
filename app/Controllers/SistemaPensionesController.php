<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SistemaPensiones;

class SistemaPensionesController extends BaseController
{
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
