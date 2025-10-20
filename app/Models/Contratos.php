<?php

namespace App\Models;

use CodeIgniter\Model;

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


