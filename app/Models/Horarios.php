<?php

namespace App\Models;
use CodeIgniter\Model;

class Horarios extends Model{

//Configurar 3 parámetros
//1. Nombre de la tabla
protected $table = 'horarios';

//2. Clave primaria
protected $primaryKey = 'idhorario';

//3. Campos operar
protected $allowedFields = ['dia','entrada','iniciorefrigerio','finrefrigerio','salida','idcontrato'];


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