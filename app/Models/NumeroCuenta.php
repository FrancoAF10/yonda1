<?php

namespace App\Models;
use CodeIgniter\Model;

class NumeroCuenta extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'numerocuenta';

//2. Clave primaria
protected $primaryKey = 'idnumcuenta';

//3. Campos operar
protected $allowedFields = ['tipomoneda','tipoinstitucion','nombre','numcuenta','cci','fechainicio','fechafin','idpersona'];

    public function getnumerocuenta($idpersona=null){
        $query =$this->db->query("SELECT * FROM numerocuenta WHERE idpersona=? ORDER BY idnumcuenta DESC",[$idpersona]);
        return $query->getResultArray();
    }
}