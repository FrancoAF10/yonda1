<?php
namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar la información de personas/empleados
 * 
 * @package App\Models
 */
class Personas extends Model {
    /**
     * Nombre de la tabla en la base de datos
     * @var string
     */
    protected $table="personas";
    /**
     * Clave primaria de la tabla
     * @var string
     */
    protected $primaryKey="idpersona";
    /**
     * Tipo de retorno para las consultas
     * @var string
     */
    protected $returnType = "array";
    /**
     * Campos permitidos para operaciones de inserción y actualización
     * @var array
     */
    protected $allowedFields=["apepaterno","apematerno","nombres","fechanac","genero","estadocivil","tipodoc","numdoc",
                                "direccion","referencia","telefono","email","iddistrito"];
    
     /**
      * Obtiene el listado completo de empleados con información con datos sobre el empleado
      * @return array
      */
     public function Vista_Empleados(){
        $query =$this->db->query("SELECT * FROM mostrar_personas ORDER BY idpersona ASC");
        return $query->getResultArray();
    }


    /**
     * Obtiene la información detallada de un empleado específico
     * @param mixed $idpersona
     * @return array|null
     */
    public function Vista_Info($idpersona=null){
        $query =$this->db->query("SELECT * FROM mostrar_personas WHERE idpersona=? LIMIT 1",[$idpersona]);
        return $query->getRowArray();
    }

}