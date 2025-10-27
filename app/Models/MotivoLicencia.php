<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar los motivos de licencia
 * 
 * @package App\Models
 */
class MotivoLicencia extends Model{

//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'motivolicencia';

//2. Clave primaria
/**
 * Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'idmotivolic';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['motivo'];

}