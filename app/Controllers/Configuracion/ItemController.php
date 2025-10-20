<?php

namespace App\Controllers\Configuracion;

use App\Controllers\BaseController;

class ItemController extends BaseController
{
    public function index(): string
    {
        $datos['header'] = view('layouts/header');
        $datos['footer'] = view('layouts/footer');

        return view('Configuracion/Item', $datos);
    }
}