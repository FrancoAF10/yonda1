<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Cargos;
class CargoController extends BaseController
{
    public function getCargosByArea($idarea=""){
      $cargo= new Cargos();
      $this->response->setContentType("application/json");
      
      $listaCargos= $cargo->where('idarea',$idarea)->findAll();
      return $this->response->setJSON($listaCargos);
    }

}