<?php

namespace App\Models;
use CodeIgniter\Model;

class MotivoLicencia extends Model{

//1. Nombre de la tabla
protected $table = 'motivolicencia';

//2. Clave primaria
protected $primaryKey = 'idmotivolic';

//3. Campos operar
protected $allowedFields = ['motivo'];

}