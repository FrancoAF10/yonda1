<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Asistencia;


class AsistenciaController extends BaseController {

    public function index() {
        $asistencia = new Asistencia();

        // Obtener filtros desde POST o GET
        $fechaInicio = $this->request->getVar('fechaInicio');
        $fechaFin    = $this->request->getVar('fechaFin');
        $dni         = $this->request->getVar('dni');

        // Si no se enviaron fechas, usar la fecha actual
        if (empty($fechaInicio) && empty($fechaFin)) {
            $hoy = date('Y-m-d');
            $fechaInicio = $hoy;
            $fechaFin = $hoy;
        }

        // Obtener datos filtrados desde la vista
        $datos['listarasistencia'] = $asistencia->filtrar($fechaInicio, $fechaFin, $dni);


        // Pasar filtros a la vista
        $datos['fechaInicio'] = $fechaInicio;
        $datos['fechaFin'] = $fechaFin;
        $datos['dni'] = $dni;

        // Cargar header y footer
        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");

        return view("asistencia/index", $datos);
    }

    


    public function hoy(){
        $asistencia=new Asistencia();
        $datos['listarasistencia']=$asistencia->Vista_Asistencia2();

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");
        return view("asistencia/hoy", $datos);
    }

    

}
