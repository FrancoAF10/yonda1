<?php

namespace App\Models;
use CodeIgniter\Model;

class Areas extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'areas';

//2. Clave primaria
protected $primaryKey = 'idarea';

//3. Campos operar
protected $allowedFields = ['area','idsucursal'];

}