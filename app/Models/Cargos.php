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
protected $allowedFields = ['cargo'];

}