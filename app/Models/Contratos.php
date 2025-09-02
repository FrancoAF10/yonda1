<?php

namespace App\Models;

use CodeIgniter\Model;

class Contratos extends Model{
    protected $table='contratos';
    protected $primaryKey='idcontrato';
    protected $allowedFields=[
        'fechainicio',
        'fechafin',
        'sueldobase',
        'toleranciadiaria',
        'toleranciamensual',
        'idpersona',
        'idcargo'
    ];
}