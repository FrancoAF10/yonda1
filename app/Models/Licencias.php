<?php

namespace App\Models;
use CodeIgniter\Model;
/**
 * Modelo para gestionar las licencias laborales
 * 
 * @package App\Models
 */
class Licencias extends Model{

//1. Nombre de la tabla
/**
 * Nombre de la tabla en la base de datos
 * @var string
 */
protected $table = 'licencias';

//2. Clave primaria
/**
 * Clave primaria de la tabla
 * @var string
 */
protected $primaryKey = 'idlicencia';

//3. Campos operar
/**
 * Campos permitidos para operaciones de inserción y actualización
 * @var array
 */
protected $allowedFields = ['conGoce','fechainicio','fechafin','evidencia','estado','fechasolicitud','idcontrato','idmotivolic'];
    /**
     * Obtiene el listado completo de licencias con información relacionada
     * 
     * Este método ejecuta una consulta JOIN que combina información de múltiples tablas
     * para obtener un registro completo de cada licencia, incluyendo:
     * - Datos de la licencia (fechas, estado, evidencia)
     * - Motivo de la licencia
     * - Información del contrato asociado
     * - Datos personales del empleado
     *  
     * Los resultados se ordenan por fecha de solicitud descendente (más recientes primero).
     * 
     * @return array
     */
    public function getLicenciasCompletas()
    {
        return $this->db->table('licencias l')
            ->select('l.idlicencia, l.conGoce, l.fechainicio as fecha_inicio_lic, l.fechafin as fecha_fin_lic, l.evidencia, l.estado as estado_lic, l.fechasolicitud,
                      m.motivo,
                      c.idcontrato, c.fechainicio as fecha_inicio_cont, c.fechafin as fecha_fin_cont, c.sueldobase,
                      p.idpersona, p.nombres, p.apepaterno, p.apematerno, p.tipodoc, p.numdoc')
            ->join('contratos c', 'l.idcontrato = c.idcontrato')
            ->join('personas p', 'c.idpersona = p.idpersona')
            ->join('motivolicencia m', 'l.idmotivolic = m.idmotivolic')
            ->orderBy('l.fechasolicitud', 'DESC')
            ->get()
            ->getResultArray();
    }


    
}