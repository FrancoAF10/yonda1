<?php
namespace App\Models;
use CodeIgniter\Model;

class Personas extends Model {
    protected $table="personas";
    protected $primaryKey="idpersona";
    protected $returnType = "array";
    protected $allowedFields=["apepaterno","apematerno","nombres","fechanac","genero","estadocivil","tipodoc","numdoc",
                                "direccion","referencia","telefono","email","iddistrito"];
    

     public function Vista_Empleados(){
        $query =$this->db->query("SELECT * FROM mostrar_personas ORDER BY idpersona ASC");
        return $query->getResultArray();
    }


    
    public function Vista_Info($idpersona=null){
        $query =$this->db->query("SELECT * FROM mostrar_personas WHERE idpersona=? LIMIT 1",[$idpersona]);
        return $query->getRowArray();
    }

    

    public function RegistrarEmpleado($data){
        return $this->db->query("CALL sp_registrar_empleado(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[
                $data['apepaterno'],
                $data['apematerno'],
                $data['nombres'],
                $data['fechanac'],
                $data['genero'],
                $data['estadocivil'],
                $data['tipodoc'],
                $data['numdoc'],
                $data['direccion'],
                $data['referencia'],
                $data['telefono'],
                $data['email'],
                $data['iddistrito'],
                $data['idsucursal'],
                $data['idarea'],
                $data['idcargo'],
                $data['fechainicio'],
                $data['fechafin'],
                $data['sueldobase'],
                $data['toleranciadiaria'],
                $data['toleranciamensual']
        ]);
    }
}