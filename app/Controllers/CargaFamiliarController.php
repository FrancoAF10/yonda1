<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CargaFamiliar;

class CargaFamiliarController extends BaseController
{
    public function crear()
    {
        $cargafamiliar = new CargaFamiliar();
        $idpersona = $this->request->getVar('idpersona');

        $validacion = $this->validate([
            'evidencia' => [
                'mime_in[evidencia,image/jpg,image/jpeg,image/png,application/pdf]',
                'max_size[evidencia,2048]'
            ]
        ]);

        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Revise la información');
            return redirect()->back()->withInput();
        }

        // Manejo del archivo (opcional)
        $archivo = $this->request->getFile('evidencia');
        $nombreArchivo = null; // Por defecto null
        if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
            $nombreArchivo = $archivo->getRandomName();
            $archivo->move('../public/uploads/', $nombreArchivo);
        }

        // Preparar datos para insertar
        $data = [
            "nombre" => $this->request->getVar('nombre'),
            "apepaterno" => $this->request->getVar('apepaterno'),
            "apematerno" => $this->request->getVar('apematerno'),
            "fechanac" => $this->request->getVar('fechanac'),
            "genero" => $this->request->getVar('genero'),
            "parentesco" => $this->request->getVar('parentesco'),
            "estudia" => $this->request->getVar('estudia') ? 1 : 0,
            "dependiente" => $this->request->getVar('dependiente') ? 1 : 0,
            "tipodoc" => $this->request->getVar('tipodoc'),
            "evidencia" => $nombreArchivo,
            "idpersona" => $idpersona
        ];

        $cargafamiliar->insert($data);

        $asigfamiliar = $cargafamiliar->getcargafamiliar($idpersona);

        return $this->response->setJSON(['status' => 'ok', 'cargafamiliar' => $asigfamiliar]);
    }
}
