<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class Departamentos extends Model{

    //Configurar 3 parámetros
    //1. Nombre de la tabla
    protected $table = 'departamentos';

    //2. Clave primaria
    protected $primaryKey = 'iddepartamento';

    //3. Campos operar
    protected $allowedFields = ['departamento'];

    }