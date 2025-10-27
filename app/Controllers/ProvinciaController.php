<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Provincias;
/**
 * Controlador para gestionar las operaciones relacionadas con provincias
 * 
 * @package App\Controllers
 */
class ProvinciaController extends BaseController
{
    /**
     * Obtiene las provincias filtradas por ID de departamento
     * 
     * Este método consulta la base de datos para recuperar todas las provincias
     * que pertenecen a un departamento específico y retorna los resultados en formato JSON.
     * @param mixed $iddepartamento
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getProvinciasByDepartamento($iddepartamento=""){
      $provincia= new Provincias();
      $this->response->setContentType("application/json");
      
      $listaprovincia = $provincia->where('iddepartamento',$iddepartamento)->findAll();
      return $this->response->setJSON($listaprovincia);

    }
}
