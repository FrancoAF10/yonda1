<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class Terminacionescontrato extends Model{

        //Configurar 3 parámetros
        //1. Nombre de la tabla
        protected $table = 'terminacionescontrato';

        //2. Clave primaria
        protected $primaryKey = 'idterminacion';

        //3. Campos operar
        protected $allowedFields = ['motivo','descripcion','gravedad','evidencia','fecharegistro','idcontrato'];


        public function Vista_despidos(){
            return $this->db->query("SELECT * FROM mostrar_despidos ORDER BY idterminacion ASC");
            return $query->getResultArray();
        }



        public function Vista_Empleados(){
            $query =$this->db->query("SELECT * FROM mostrar_personas ORDER BY idpersona ASC");
            return $query->getResultArray();
        }



        public function RegistrarDespido($data){
            return $this->db->query("CALL sp_registrar_terminacion(?,?,?,?,?)",[
                $data['motivo'],
                $data['descripcion'],
                $data['gravedad'],
                $data['evidencia'],
                $data['idcontrato']
            ]);
        }


        
    }     