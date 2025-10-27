<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Sucursal;
/**
 * Controlador para gestionar las operaciones relacionadas con sucursales
 * 
 * @package App\Controllers
 */
class SucursalController extends BaseController
{
    /**
     * Obtiene las sucursales filtradas por ID de distrito
     * 
     * Este método consulta la base de datos para recuperar todas las sucursales
     * que pertenecen a un distrito específico y retorna los resultados en formato JSON.
     * 
     * @param mixed $iddistrito ID del distrito para filtrar las sucursales (por defecto vacío)
     * @return \CodeIgniter\HTTP\ResponseInterface Respuesta HTTP con el listado de sucursales en formato JSON
     */
    public function getSucursalesByDistrito($iddistrito=""){
      $sucursal= new Sucursal();
      $this->response->setContentType("application/json");
      
      $listadistrito= $sucursal->where('iddistrito',$iddistrito)->findAll();
      return $this->response->setJSON($listadistrito);
    }

}
