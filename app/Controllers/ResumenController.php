<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ResumenController extends BaseController
{
    public function index(): string
    {
        $datos['header'] = view('layouts/header');
        $datos['footer'] = view('layouts/footer');

        return view('Resumen', $datos);
    }
}