<?php

namespace App\Models;
use CodeIgniter\Model;

class Cargos extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'cargos';

//2. Clave primaria
protected $primaryKey = 'idcargo';

//3. Campos operar
protected $allowedFields = ['cargo','idarea'];
    /**
     * Obtiene el listado completo de cargos
     * 
     * Consulta la vista 'mostrar_cargos' que contiene la información
     * de todos los cargos registrados en el sistema.
     * 
     * @return array Arreglo de registros con la información de los cargos
     */
    public function Vista_Cargos(){
      $query =$this->db->query("SELECT * FROM mostrar_cargos");
      return $query->getResultArray();
    }


}