<?php

namespace App\Models;
use CodeIgniter\Model;

class Provincias extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'provincias';
 //2. Clave primaria
protected $primaryKey = 'idprovincia';

//3. Campos operar
protected $allowedFields = ['provincia','iddepartamento'];

}