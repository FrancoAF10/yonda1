<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar los horarios de trabajo
 * 
 * @package App\Models
 */
class Horarios extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'horarios';

//2. Clave primaria
/**
 * Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'idhorario';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['dia','entrada','iniciorefrigerio','finrefrigerio','salida','idcontrato'];

    /**
     * Inserta un nuevo registro de horario en la base de datos
     * 
     * Este método ejecuta una consulta SQL personalizada para insertar un horario
     * completo incluyendo todos los campos necesarios para definir la jornada laboral.
     * 
     * @param mixed $data
     * @return int|string
     */
    public function insertarHorario($data){
        $query= 
        " INSERT INTO HORARIOS(dia, entrada, iniciorefrigerio, finrefrigerio, salida, inicio, fin, idcontrato)
                        VALUES(?,?,?,?,?,?,?,?)";
        $this->db->query($query, [
                $data['dia'],
                $data['entrada'],
                $data['iniciorefrigerio'],
                $data['finrefrigerio'],
                $data['salida'],
                $data['idcontrato']
                ]);
        return $this->db->insertID();
    }


    
}