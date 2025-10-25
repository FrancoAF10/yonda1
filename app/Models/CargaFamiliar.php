<?php

namespace App\Models;
use CodeIgniter\Model;

class CargaFamiliar extends Model
{

    //Configurar 3 parámetros
//1. Nombre de la tabla
    protected $table = 'cargafamiliar';

    //2. Clave primaria
    protected $primaryKey = 'idcargafamiliar';

    //3. Campos operar
    protected $allowedFields = [
                                'parentesco',
                                'evidencia',
                                'idpersona',
                                'idhijo'
                                ];
   /**
    * Obtiene la carga familiar de un empleado en específo
    *
    * Consulta todos los dependientes (hijos) asociados a un empleado,
    * incluyendo la información completa de la carga familiar y los datos
    * personales de cada dependiente (nombres y apellidos).
    *
    * @param mixed $idpersona Identificador único del empleado
    * @return array Arreglo de registros con información de la carga familiar
    *               Incluye: datos de cargafamiliar + nombres_hijo, apepaterno_hijo, apematerno_hijo
    */
   public function getcargafamiliar($idpersona){
        return $this->select('cargafamiliar.*, 
                            p2.nombres as nombres_hijo, 
                            p2.apepaterno as apepaterno_hijo, 
                            p2.apematerno as apematerno_hijo')
                    ->join('personas as p2', 'p2.idpersona = cargafamiliar.idhijo')
                    ->where('cargafamiliar.idpersona', $idpersona)
                    ->findAll();
    }

}