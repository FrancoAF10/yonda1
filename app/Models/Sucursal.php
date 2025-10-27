<?php

    namespace App\Models;
    use CodeIgniter\Model;
    /**
     * Modelo para gestionar las sucursales de la empresa
     * 
     * @package App\Models
     */
    class Sucursal extends Model{

    //Configurar 3 parámetros
    //1. Nombre de la tabla
    /**
     * Nombre de la tabla en la base de datos
     * @var string
     */
    protected $table = 'sucursales';

    //2. Clave primaria
    /**
     * Clave primaria de la tabla
     * @var string
     */
    protected $primaryKey = 'idsucursal';

    //3. Campos operar
    /**
     * Campos permitidos para operaciones de inserción y actualización
     * @var array
     */
    protected $allowedFields = ['sucursal',"direccion","referencia","iddistrito"];

    }