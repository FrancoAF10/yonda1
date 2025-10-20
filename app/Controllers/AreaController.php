<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Areas;
use App\Models\Cargos;
class AreaController extends BaseController
{

      public function index(){
        $areas = new Areas();
        $cargos = new Cargos();

        $datos['listarareas'] = $areas->Vista_Areas();
        $datos['listarcargos'] = $cargos->Vista_Cargos();

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");

        return view('dashboard', $datos);
    }

    public function getAreasBySucursal($idsucursal=""){
      $area= new Areas();
      $this->response->setContentType("application/json");
      
      $listaAreas= $area->where('idsucursal',$idsucursal)->findAll();
      return $this->response->setJSON($listaAreas);
    }

}
