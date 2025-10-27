<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar los permisos de ausencia durante la jornada laboral
 * 
 * @package App\Models
 */
class Permiso extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'permisos';

//2. Clave primaria
/**
 * Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'idpermiso';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['horainicio','horafin','motivo','fechasolicitud','evidencia','idasistencia'];
/**
 * Inserta un nuevo registro de permiso en la base de datos
 * 
 * Este método ejecuta una consulta SQL personalizada para registrar un permiso
 * de ausencia durante la jornada laboral con todos los detalles necesarios.
 * @param mixed $data
 * @return int|string
 */
public function insertarPermiso($data){
   $query=("INSERT INTO permisos (horainicio,horafin,motivo,fechasolicitud,evidencia,idasistencia)VALUES(?,?,?,?,?,?);");
    $this->db->query($query, [
                $data['horainicio'],
                $data['horafin'],
                $data['motivo'],
                $data['fechasolicitud'],
                $data['evidencia'],
                $data['idasistencia'],
                ]);
    return $this->db->insertID();
}

}