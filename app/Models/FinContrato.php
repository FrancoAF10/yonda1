<?php

namespace App\Models;
use CodeIgniter\Model;

Class FinContrato extends Model{
    protected $table = "fincontrato";
    protected $primaryKey = "idfc";
    protected $allowedFields = ["motivo","descripcion","severidad","evidencia","fechacreacion","idcontrato"];
}