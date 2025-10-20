<?php

namespace App\Controllers\Administrativo\Trabajadores;

use App\Controllers\BaseController;

class VacacionesController extends BaseController
{
    public function index(): string
    {
        $datos['header'] = view('layouts/header');
        $datos['footer'] = view('layouts/footer');

        return view('Administrativo/Trabajadores/Vacaciones', $datos);
    }
}