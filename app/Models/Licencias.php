<?php

namespace App\Models;
use CodeIgniter\Model;

class Licencias extends Model{

//1. Nombre de la tabla
protected $table = 'licencias';

//2. Clave primaria
protected $primaryKey = 'idlicencia';

//3. Campos operar
protected $allowedFields = ['conGoce','fechainicio','fechafin','evidencia','estado','fechasolicitud','idcontrato','idmotivolic'];

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