<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Provincias;
class ProvinciaController extends BaseController
{

    public function getProvinciasByDepartamento($iddepartamento=""){
      $provincia= new Provincias();
      $this->response->setContentType("application/json");
      
      $listaprovincia = $provincia->where('iddepartamento',$iddepartamento)->findAll();
      return $this->response->setJSON($listaprovincia);

    }
}
