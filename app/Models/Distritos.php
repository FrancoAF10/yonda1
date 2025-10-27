<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar la tabla de distritos
 * 
 * @package App\Models
 */
class Distritos extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'distritos';

//2. Clave primaria
/**
 * Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'iddistrito';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['distrito','idprovincia'];

}