<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Areas;
use App\Models\Cargos;
class AreaController extends BaseController
{
      /**
       * Muestra la pantalla principal con el Dashboard: areas, cargos
       * @return string
       */
      public function index(){
        $areas = new Areas();
        $cargos = new Cargos();

        $datos['listarareas'] = $areas->Vista_Areas();
        $datos['listarcargos'] = $cargos->Vista_Cargos();

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");

        return view('dashboard', $datos);
    }
    /**
     * Obtiene las areas asociadas a una sucursal
     * Función consulta y retorna todas las areas que pertenecen a la sucursal indicada por su identificador.
     * @param mixed $idsucursal
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getAreasBySucursal($idsucursal=""){
      $area= new Areas();
      $this->response->setContentType("application/json");
      
      $listaAreas= $area->where('idsucursal',$idsucursal)->findAll();
      return $this->response->setJSON($listaAreas);
    }

}
