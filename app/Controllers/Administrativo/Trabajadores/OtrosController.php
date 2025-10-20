<?php

namespace App\Controllers\Administrativo\Trabajadores;

use App\Controllers\BaseController;
use App\Models\Licencias;
use App\Models\MotivoLicencia;
use App\Models\Contratos;

class OtrosController extends BaseController
{
    public function index()
    {
        $motivoLic=new MotivoLicencia();
        $licencias=new Licencias();
        $datos['header'] = view('layouts/header');
        $datos['footer'] = view('layouts/footer');
        $datos['motivos']=$motivoLic->orderBy('idmotivolic', 'ASC')->findAll();
        $datos['licencias']=$licencias->getLicenciasCompletas();
        return view('Administrativo/Trabajadores/Otros', $datos);
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
}