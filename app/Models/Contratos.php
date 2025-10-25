<?php

namespace App\Models;

use CodeIgniter\Model;
/**
 * Modelo de contratos
 * 
 * Gestiona la información de contratos laborales de los empleados,
 * incluyendo consultas de contratos activos, vencidos e historial.
 * @package App\Models
 */
class Contratos extends Model{
    protected $table='contratos';
    protected $primaryKey='idcontrato';
    protected $allowedFields=[
        'fechainicio',
        'fechafin',
        'sueldobase',
        'toleranciadiaria',
        'toleranciamensual',
        'estado',
        'idpersona',
        'idcargo'
    ];


    /**
     * Obtiene el contrato activo de un empleado mediante su DNI
     * 
     * Busca el contrato más reciente en estado "Activo" asociado al DNI proporcionado,
     * incluyendo información básica del empleado.
     * 
     * @param string $dni Número de documento del empleado
     * @return array|null Datos del contrato activo con información del empleado, null si no existe
     * 
     */
    public function getContratoActivoByDNI(string $dni): ?array
    {
        return $this->db->table($this->table . ' c')
        //cuando se ingrese el campo de estados en la database(activo,inactivo) agregar campo dentro del select c.estado
            ->select('c.idcontrato,c.estado, c.fechainicio, c.fechafin,
                    p.idpersona, p.nombres, p.apepaterno, p.apematerno, p.numdoc')
            ->join('personas p', 'p.idpersona = c.idpersona')
            ->where('p.numdoc', $dni)
            ->where('c.estado', 'Activo') // cuando ya lo uses
            ->orderBy('c.fechainicio', 'DESC')
            ->get()
            ->getRowArray();
    }


    /**
     * Obtiene los contratos vencidos más recientes de empleados sin contrato vigente
     * 
     * Consulta el último contrato vencido de cada empleado que actualmente
     * no tiene ningún contrato activo o futuro. Útil para identificar empleados
     * cuyo contrato ha finalizado y no ha sido renovado.
     * 
     * @return array Arreglo de contratos vencidos desde la vista historial_contratos_vencidos
     */
    public function Vista_Contratos_Vencidos(){
    $query =$this->db->query(
        "
                SELECT c.*
                FROM historial_contratos_vencidos c
                INNER JOIN (
                    SELECT idpersona, MAX(fechafin) AS ultima_fecha
                    FROM contratos
                    GROUP BY idpersona
                ) ult ON c.idpersona = ult.idpersona AND c.fechafin = ult.ultima_fecha
                WHERE c.idpersona NOT IN (
                    SELECT idpersona
                    FROM contratos
                    WHERE fechafin >= CURDATE()
                );"
            );
    
    return $query->getResultArray();
    }
        


    public function Vista_dias_restantes($idpersona=null){
        $query =$this->db->query("SELECT * FROM mostrar_dias_restantes WHERE idpersona=? LIMIT 1",[$idpersona]);
        return $query->getRowArray();
    }


    /**
     * Obtiene los días restantes del contrato actual de un empleado
     * 
     * Consulta la vista 'mostrar_dias_restantes' que calcula los días
     * faltantes hasta la finalización del contrato vigente.
     * 
     * @param mixed $idpersona Identificador del empleado
     * @return array Registro con información de días restantes, null si no existe
     */
    public function getHistorialContratos($idpersona)
    {
        return $this->db->table('contratos c')
            ->select('c.*, a.area, cg.cargo, s.sucursal')
            ->join('cargos cg', 'cg.idcargo = c.idcargo', 'left')
            ->join('areas a', 'a.idarea = cg.idarea', 'left')
            ->join('sucursales s', 's.idsucursal = a.idsucursal', 'left')
            ->where('c.idpersona', $idpersona)
            ->orderBy('c.fechainicio', 'DESC')
            ->get()
            ->getResultArray();
    }


    /**
     * Obtiene el historial de contratos vencidos de un empleado
     * 
     * Similar a getHistorialContratos pero filtra únicamente contratos
     * en estado "Inactivo". Incluye información relacionada del cargo,
     * área y sucursal. Útil para consultar contratos finalizados.
     * 
     * @param mixed $idpersona Identificador del empleado
     * @return array Arreglo de contratos inactivos con datos de cargo, área y sucursal
     */
    public function getHistorialContratosVencidos($idpersona)
    {
        return $this->db->table('contratos c')
            ->select('c.*, a.area, cg.cargo, s.sucursal')
            ->join('cargos cg', 'cg.idcargo = c.idcargo', 'left')
            ->join('areas a', 'a.idarea = cg.idarea', 'left')
            ->join('sucursales s', 's.idsucursal = a.idsucursal', 'left')
            ->where('c.idpersona', $idpersona)
            ->where('c.estado', 'Inactivo') // Filtrar solo contratos vencidos
            ->orderBy('c.fechainicio', 'DESC')
            ->get()
            ->getResultArray();
    }


    
}


