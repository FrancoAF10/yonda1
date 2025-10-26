<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Cargos;
/**
 * Controlador CargoController
 * 
 * Gestiona las operaciones relacionadas con los cargos laborales
 * del sistema de RRHH.
 * 
 * @package App\Controllers
 */
class CargoController extends BaseController
{
    /**
     * Obtiene los cargos asociados a un área específica
     * 
     * Consulta y retorna en formato JSON todos los cargos que pertenecen
     * al área indicada por su identificador. Útil para cargar selectores
     * dinámicos de cargos filtrados por área.
     * 
     * @param mixed $idarea Identificador del área
     * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con la lista de cargos
     */
    public function getCargosByArea($idarea=""){
      $cargo= new Cargos();
      $this->response->setContentType("application/json");
      
      $listaCargos= $cargo->where('idarea',$idarea)->findAll();
      return $this->response->setJSON($listaCargos);
    }

}