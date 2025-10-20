<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class TareoModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }



    public function obtenerTareo(int $anio, int $mes, ?string $dni = null)
    {
        try {
            // Llamada al SP
            $query = $this->db->query("CALL spu_generar_tareo_dinamico(?, ?)", [$anio, $mes]);
            $resultados = $query->getResultArray();

            // Filtrado adicional por DNI
            if (!empty($dni)) {
                $resultados = array_filter($resultados, function ($fila) use ($dni) {
                    return (isset($fila['dni']) && $fila['dni'] == $dni)
                        || (strpos($fila['colaborador'], $dni) !== false);
                });
            }

            return $resultados;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return [];
        }
    }


    
}
