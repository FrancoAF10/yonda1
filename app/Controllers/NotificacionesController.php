<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Notificaciones;
class NotificacionesController extends BaseController
{


    public function notificaciones(){

        $notificaciones = new Notificaciones();
        $datos['notificaciones'] = $notificaciones->Vista_Notificaiones();
        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");
        return $datos;

    }


}