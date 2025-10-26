<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Areas;
use App\Models\Cargos;
/**
 * Gestiona la vista principal del dashboard del sistema,
 * cargando y mostrando información de áreas y cargos.
 * @package App\Controllers
 */
class DashboardController extends BaseController
{
    /**
     * Carga los datos de áreas y cargos desde sus respectivos modelos
     * y renderiza la vista principal del dashboard junto con los layouts
     * de header y footer.
     * @return string Vista del dashboard con los datos cargados
     */
    public function index()
    {
        $areas = new Areas();
        $cargos = new Cargos();

        $datos['listarareas']  = $areas->Vista_Areas();
        $datos['listarcargos'] = $cargos->Vista_Cargos();

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");

        return view('dashboard', $datos);
    }
}
