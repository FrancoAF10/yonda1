<?php

namespace App\Controllers\Plantillas;

use App\Controllers\BaseController;

class PruebaController extends BaseController
{
    public function index(): string
    {
        $datos['header'] = view('layouts/header');
        $datos['footer'] = view('layouts/footer');

        return view('Plantillas/Prueba', $datos);
    }
}