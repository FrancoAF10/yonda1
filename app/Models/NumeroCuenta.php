<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar las cuentas bancarias de los empleados
 * 
 * @package App\Models
 */
class NumeroCuenta extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'numerocuenta';

//2. Clave primaria
/**
 * Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'idnumcuenta';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['tipomoneda','tipoinstitucion','nombre','numcuenta','cci','fechainicio','fechafin','idpersona'];
    /**
     * Obtiene el historial de cuentas bancarias de un empleado
     * 
     * Este método recupera todas las cuentas bancarias asociadas a un empleado
     * específico, ordenadas por ID descendente (mostrando las más recientes primero).
     * Incluye tanto cuentas activas como históricas.
     * @param mixed $idpersona
     * @return array
     */
    public function getnumerocuenta($idpersona=null){
        $query =$this->db->query("SELECT * FROM numerocuenta WHERE idpersona=? ORDER BY idnumcuenta DESC",[$idpersona]);
        return $query->getResultArray();
    }
}