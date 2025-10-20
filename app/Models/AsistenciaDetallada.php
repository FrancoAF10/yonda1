<?php
namespace App\Models;

use CodeIgniter\Model;

class AsistenciaDetallada extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'idasistencia';

    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'diamarcado',
        'entrada',
        'iniciorefrigerio',
        'finrefrigerio',
        'salida',
        'idhorario',
        'tardanza_minutos',
        'exceso_refrigerio_minutos',
        'salida_anticipada_minutos',
        'observacion',
        'minnolaborados' // 👈 agregado aquí
    ];

    protected $validationRules = [
        'diamarcado' => 'required|valid_date[Y-m-d]',
        'idhorario'  => 'required|integer',
    ];

    protected $validationMessages = [
        'diamarcado' => [
            'required' => 'Debe registrar la fecha del marcaje.',
            'valid_date' => 'La fecha de marcaje no es válida.'
        ],
        'idhorario' => [
            'required' => 'Debe especificar el horario asociado.',
            'integer'  => 'El ID de horario debe ser numérico.'
        ]
    ];

    protected $skipValidation = false;
}
