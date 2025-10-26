<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Distritos;

/**
 * Controlador de Distritos
 * 
 * Gestiona las operaciones relacionadas con los distritos,
 * principalmente la obtención de distritos filtrados por provincia
 * para uso en selects dinámicos y peticiones AJAX.
 * 
 * @package App\Controllers
 */
class DistritoController extends BaseController
{
    /**
     * Obtiene los distritos de una provincia específica
     * 
     * @param mixed $idprovincia ID de la provincia para filtrar distritos
     * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con array de distritos
     * 
     */
    public function getDistritosByProvincia($idprovincia=""){
      $distrito= new Distritos();
      $this->response->setContentType("application/json");
      
      $listadistrito= $distrito->where('idprovincia',$idprovincia)->findAll();
      return $this->response->setJSON($listadistrito);
    }
}
