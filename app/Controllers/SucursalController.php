<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Sucursal;
class SucursalController extends BaseController
{
    public function getSucursalesByDistrito($iddistrito=""){
      $sucursal= new Sucursal();
      $this->response->setContentType("application/json");
      
      $listadistrito= $sucursal->where('iddistrito',$iddistrito)->findAll();
      return $this->response->setJSON($listadistrito);
    }

}
