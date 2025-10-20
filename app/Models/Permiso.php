<?php

namespace App\Models;
use CodeIgniter\Model;

class Permiso extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'permisos';

//2. Clave primaria
protected $primaryKey = 'idpermiso';

//3. Campos operar
protected $allowedFields = ['horainicio','horafin','motivo','fechasolicitud','evidencia','idasistencia'];

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