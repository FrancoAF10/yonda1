<?php

namespace App\Models;
use CodeIgniter\Model;

class SistemaPensiones extends Model {
    protected $table='sispensiones';
    protected $primaryKey='idsp';
    protected $allowedFields=['tiposistema','nombresistema','fechaafiliacion','fechatermino','cuspp','idpersona'];

    public function getsistemapensiones($idpersona=null){
        $query =$this->db->query("SELECT * FROM sispensiones WHERE idpersona=? ORDER BY idsp DESC",[$idpersona]);
        return $query->getResultArray();
    }


    
}
