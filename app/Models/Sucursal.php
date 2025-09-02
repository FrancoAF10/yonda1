<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class Sucursal extends Model{

    //Configurar 3 parámetros
    //1. Nombre de la tabla
    protected $table = 'sucursales';

    //2. Clave primaria
    protected $primaryKey = 'idsucursal';

    //3. Campos operar
    protected $allowedFields = ['sucursal',"direccion","referencia","iddistrito"];

    }