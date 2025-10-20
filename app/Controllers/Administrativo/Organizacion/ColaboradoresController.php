<?php

namespace App\Controllers\Administrativo\Organizacion;

use App\Controllers\BaseController;

class ColaboradoresController extends BaseController
{
    public function index(): string
    {
        $datos['header'] = view('layouts/header');
        $datos['footer'] = view('layouts/footer');

        return view('Administrativo/Organizacion/Colaboradores', $datos);
    }
}