<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar el sistema de pensiones de los empleados
 * 
 * @package App\Models
 */
class SistemaPensiones extends Model {
    /**
     * Nombre de la tabla en la base de datos
     * @var string
     */
    protected $table='sispensiones';
    /**
     * Clave primaria de la tabla
     * @var string
     */
    protected $primaryKey='idsp';
    /**
     * Campos permitidos para operaciones de inserción y actualización
     * @var array
     */
    protected $allowedFields=['tiposistema','nombresistema','fechaafiliacion','fechatermino','cuspp','idpersona'];
    /**
     * Obtiene el historial de afiliaciones al sistema de pensiones de un empleado
     * @param mixed $idpersona
     * @return array
     */
    public function getsistemapensiones($idpersona=null){
        $query =$this->db->query("SELECT * FROM sispensiones WHERE idpersona=? ORDER BY idsp DESC",[$idpersona]);
        return $query->getResultArray();
    }


    
}
