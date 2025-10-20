<?php

namespace App\Models;
use CodeIgniter\Model;

class Notificaciones extends Model{


    //Configurar 3 parámetros
    //1. Nombre de la tabla
    protected $table = 'notificaciones';

    //2. Clave primaria
    protected $primaryKey = 'idnotificacion';

    //3. Campos operar
    protected $allowedFields = ['titulo', 'descripcion', 'tipo', 'leido', 'fechacreacion'];


    public function Vista_Notificaiones(){
        $query =$this->db->query("SELECT * FROM mostrar_notificaciones ORDER BY idnotificacion DESC");
        return $query->getResultArray();
    }


}
