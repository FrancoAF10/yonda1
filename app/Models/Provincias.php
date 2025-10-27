<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar la tabla de provincias
 * 
 * @package App\Models
 */
class Provincias extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'provincias';
 //2. Clave primaria
/**
 *  Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'idprovincia';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['provincia','iddepartamento'];

}