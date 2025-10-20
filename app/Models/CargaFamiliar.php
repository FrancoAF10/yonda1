<?php

namespace App\Models;
use CodeIgniter\Model;

class CargaFamiliar extends Model
{

    //Configurar 3 parámetros
//1. Nombre de la tabla
    protected $table = 'cargafamiliar';

    //2. Clave primaria
    protected $primaryKey = 'idcargafamiliar';

    //3. Campos operar
    protected $allowedFields = ['nombre',
                                'apepaterno',
                                'apematerno',
                                'fechanac',
                                'genero',
                                'parentesco',
                                'estudia',
                                'dependiente',
                                'tipodoc',
                                'evidencia',
                                'idpersona'
                                ];

    public function getcargafamiliar($idpersona = null)
    {
        $query = $this->db->query("SELECT * FROM cargafamiliar WHERE idpersona=? ORDER BY idcargafamiliar DESC", [$idpersona]);
        return $query->getResultArray();
    }
}