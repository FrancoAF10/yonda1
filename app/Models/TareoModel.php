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

    /**
     * Llama al procedimiento almacenado para generar el tareo mensual dinámico.
     * Incluye la corrección crítica para limpiar los resultados del SP.
     *
     * @param int $anio Año del tareo (YYYY).
     * @param int $mes Mes del tareo (1-12).
     * @param string|null $dni DNI o parte del nombre para filtrar (opcional).
     * @return array La matriz del tareo con datos pivotados.
     */
    public function obtenerTareo(int $anio, int $mes, ?string $dni = null)
    {
        try {
            // Asegúrate de usar el nombre correcto de tu procedimiento almacenado final
            $query = $this->db->query("CALL spu_generar_tareo_real(?, ?)", [$anio, $mes]);
            
            $resultados = $query->getResultArray();

            // 🚨 CORRECCIÓN CRÍTICA: Limpiar los resultados del Store Procedure.
            // Esto evita el error "Commands out of sync" en llamadas subsecuentes al SP.
            if ($this->db->connID->more_results()) {
                $this->db->connID->next_result();
                // Algunos drivers pueden requerir un segundo chequeo
                if ($this->db->connID->more_results()) {
                    $this->db->connID->use_result();
                }
            }
            
            // Filtrado adicional por DNI o parte del nombre
            if (!empty($dni)) {
                // El filtro ahora asume que la columna 'dni' y 'colaborador' existen en $resultados
                $resultados = array_filter($resultados, function ($fila) use ($dni) {
                    $dni_existe = isset($fila['dni']) && $fila['dni'] == $dni;
                    $nombre_contiene = isset($fila['colaborador']) && strpos($fila['colaborador'], $dni) !== false;
                    
                    return $dni_existe || $nombre_contiene;
                });
                
                // Reindexar el array después de usar array_filter
                $resultados = array_values($resultados);
            }

            return $resultados;

        } catch (Exception $e) {
            log_message('error', 'Error en TareoModel::obtenerTareo: ' . $e->getMessage());
            return [];
        }
    }
}