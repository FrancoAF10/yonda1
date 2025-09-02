<?php

namespace App\Models;
use CodeIgniter\Model;

class Asistencia extends Model {
    protected $table="asistencia";
    protected $primarykey="idasistencia";
      protected $returnType = "array";
    protected $allowedFields=[];

  public function Vista_Asistencia(){
    $query =$this->db->query("SELECT * FROM mostrar_asistencia ORDER BY idpersona ASC");
    return $query->getResultArray();
  }
}