<?php
namespace App\Models;
use CodeIgniter\Model;

class Asistencia extends Model {
    protected $table = "asistencias";
    protected $primaryKey = "idasistencia";
    protected $returnType = "array";
    protected $allowedFields = ['diamarcado','entrada','iniciorefrigerio','finrefrigerio','salida','minnolaborados','tipoasistencia','idhorario'];

    /**
     * Obtiene registros de asistencia filtrados mediante procedimiento almacenado
     * @param mixed $fechaInicio Fecha inicial del filtro en formato Y-m-d (opcional)
     * @param mixed $fechaFin Fecha final del filtro en formato Y-m-d (opcional)
     * @param mixed $dni DNI del empleado para filtrar (opcional)
     * @return array Arreglo de registros de asistencia filtrados
     * @uses sp_mostrar_asistencia Procedimiento almacenado de MySQL
     */
    public function Vista_Asistencia($fechaInicio = null, $fechaFin = null, $dni = null) {
        // Si vienen vacíos, se mandan como NULL al procedimiento
        $fechaInicio = $fechaInicio ?: null;
        $fechaFin    = $fechaFin ?: null;
        $dni         = $dni ?: null;

        $sql = "CALL sp_mostrar_asistencia(?, ?, ?)";
        $query = $this->db->query($sql, [$fechaInicio, $fechaFin, $dni]);

        return $query->getResultArray();
    }


    /**
     * Obtiene todos los registros de asistencia ordenados por persona
     * Ejecuta una consulta a la  vista 'mostrar_asistencia' y retorna todos los registros ordenados ascendentemente por ID persona.
     * @return array Arreglo de los registros de persona
     */
    public function Vista_Asistencia2(){
        $query =$this->db->query("SELECT * FROM mostrar_asistencia ORDER BY idpersona ASC");
        return $query->getResultArray();
    }


    /**
     * Obtiene el listado completo de asistencias con información detallada
     * 
     * Consulta la vista 'vista_asistencia_detallada' que contiene información
     * extendida de las asistencias (posiblemente incluyendo datos del empleado,
     * sucursal, área, horarios, etc.).
     * 
     * @return array Arreglo de registros de asistencia con detalles completos
     */
    public function Vista_Asistencia_Detallada(){
      $query =$this->db->query("SELECT * FROM vista_asistencia_detallada");
      return $query->getResultArray();
    }

    

    /**
     * Filtra registros de asistencia por rango de fechas y/o DNI
     * 
     * Consulta la vista 'vista_asistencia_detallada' aplicando filtros opcionales
     * por rango de fechas de marcado y número de documento del empleado.
     * Si no se proporcionan filtros, retorna todos los registros.
     * @param mixed $fechaInicio Fecha inicial del rango en formato Y-m-d (opcional)
     * @param mixed $fechaFin Fecha final del rango en formato Y-m-d (opcional)
     * @param mixed $dni Número de documento del empleado para filtrar (opcional)
     * @return array Arreglo de registros de asistencia filtrados con información detallada
     */
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


    /**
     * Obtiene el historial de asistencias de un empleado específico
     * 
     * Consulta la vista 'vista_asistencia_detallada' filtrando por el ID
     * del empleado y ordenando los registros ascendentemente por ID de asistencia.
     * @param mixed $idpersona
     * @return array
     */
    public function Vista_Asistenciapersona($idpersona){
        $query =$this->db->query("SELECT * FROM vista_asistencia_detallada where idpersona=$idpersona ORDER BY idasistencia ASC");
        return $query->getResultArray();
    }

    
}
