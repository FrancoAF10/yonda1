<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar la finalización de contratos
 * 
 * @package App\Models
 */
Class FinContrato extends Model{
    /**
     * Nombre de la tabla en la base de datos
     * @var string
     */
    protected $table = "fincontrato";
    /**
     * Clave primaria de la tabla
     * @var string
     */
    protected $primaryKey = "idfc";
    /**
     * Campos permitidos para operaciones de inserción y actualización
     * @var array
     */
    protected $allowedFields = ["motivo","descripcion","severidad","evidencia","fechacreacion","idcontrato"];
}