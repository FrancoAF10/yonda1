<?php
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\Asistencia;

    class AsistenciaController extends BaseController {
        public function index(){
            $asistencia=new Asistencia();
            $datos['listarasistencia']=$asistencia->Vista_Asistencia();

            $datos['header'] = view("Layouts/header");
            $datos['footer'] = view("Layouts/footer");
            return view("asistencia/index", $datos);
        }

    }