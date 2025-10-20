<?php
namespace App\Models;
use CodeIgniter\Model;

class Asistencia extends Model {
    protected $table = "asistencias";
    protected $primaryKey = "idasistencia";
    protected $returnType = "array";
    protected $allowedFields = ['diamarcado','entrada','iniciorefrigerio','finrefrigerio','salida','minnolaborados','tipoasistencia','idhorario'];

    public function Vista_Asistencia($fechaInicio = null, $fechaFin = null, $dni = null) {
        // Si vienen vacíos, se mandan como NULL al procedimiento
        $fechaInicio = $fechaInicio ?: null;
        $fechaFin    = $fechaFin ?: null;
        $dni         = $dni ?: null;

        $sql = "CALL sp_mostrar_asistencia(?, ?, ?)";
        $query = $this->db->query($sql, [$fechaInicio, $fechaFin, $dni]);

        return $query->getResultArray();
    }


    
    public function Vista_Asistencia2(){
        $query =$this->db->query("SELECT * FROM mostrar_asistencia ORDER BY idpersona ASC");
        return $query->getResultArray();
    }



    public function Vista_Asistencia_Detallada(){
      $query =$this->db->query("SELECT * FROM vista_asistencia_detallada");
      return $query->getResultArray();
    }

    

    // Función para filtrar por fecha y DNI
    public function filtrar($fechaInicio = null, $fechaFin = null, $dni = null)
    {
        $builder = $this->db->table('vista_asistencia_detallada');

        if ($fechaInicio && $fechaFin) {
            $builder->where('diamarcado >=', $fechaInicio);
            $builder->where('diamarcado <=', $fechaFin);
        }

        if ($dni) {
            $builder->where('p.numdoc', $dni);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }


    
    public function Vista_Asistenciapersona($idpersona){
        $query =$this->db->query("SELECT * FROM vista_asistencia_detallada where idpersona=$idpersona ORDER BY idasistencia ASC");
        return $query->getResultArray();
    }

    
}
