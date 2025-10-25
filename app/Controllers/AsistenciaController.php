<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Asistencia;


class AsistenciaController extends BaseController {
    /**
     * Vista principal de asistencias con filtros aplicados desde el Modelo(Models)
     * Este método maneja la visualizacion de registros de asistencia permitiendo filtrar por rango de fechas y dni del empleado.
     * En caso de no proporcionar fecha , utilizara la fecha actual como valor predeterminado,
     * @return string Vista HTML dentro del index.php con la lista de asistencias filtradas
     * - header (string): vista del encabezado
     * - footer (string): vista del pie de página
     */
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

    /**
     * Muestra la vista de asistencia del día actual.
     * Este método carga todos los registros de la asistencia desde la vista de la abse de datos "mostrar_asistencia"
     * y los presenta en la interfaz correspondiente del día de hoy.
     * @return string Vista asistencia/hoy con el listado completo de asistencias
     * - header (string): vista del encabezado
     * - footer (string): vista del pie de página
     */
    public function hoy(){
        $asistencia=new Asistencia();
        $datos['listarasistencia']=$asistencia->Vista_Asistencia2();

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");
        return view("asistencia/hoy", $datos);
    }

    

}
