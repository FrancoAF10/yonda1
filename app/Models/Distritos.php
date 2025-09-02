<?php

namespace App\Models;
use CodeIgniter\Model;

class Distritos extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'distritos';

//2. Clave primaria
protected $primaryKey = 'iddistrito';

//3. Campos operar
protected $allowedFields = ['distrito','idprovincia'];

}