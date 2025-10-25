<?= $header ?>
<div class="pc-container my-2">
    <div class="pc-content">

        <h2 class="mb-3">Tareo Mensual</h2>

        <form method="get" action="<?= base_url('tareo/tareo') ?>" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Año</label>
                <input type="number" name="anio" class="form-control" value="<?= esc($anio) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Mes</label>
                <input type="number" name="mes" min="1" max="12" class="form-control" value="<?= esc($mes) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">DNI / Colaborador</label>
                <input type="text" name="dni" class="form-control" value="<?= esc($dni) ?>" placeholder="Buscar DNI o Nombre">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                <a href="<?= base_url('tareo/tareo') ?>" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <?php if (!empty($tareo)) : ?>
            <div class="mb-3 d-flex justify-content-between flex-wrap">
                <div>
                    <a href="<?= base_url('tareo/exportarExcel?anio='.$anio.'&mes='.$mes.'&dni='.$dni) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel-fill"></i> Exportar Excel
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-2 small mt-2 mt-md-0">
                    <span class="badge text-bg-success">X/LC: Asistencia/Lic. C/G</span>
                    <span class="badge text-bg-danger">Faltas INJ/S/G</span>
                    <span class="badge text-bg-info text-dark">O/FN: Descanso</span>
                    <span class="badge text-bg-primary">D: Feriado Trab.</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover table-striped" style="font-size: 0.75rem; border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr class="align-middle">
                            <?php
                            $columnas_a_omitir = ['idpersona']; 
                            $headers_map = [
                                'dni' => 'DNI',
                                'colaborador' => 'COLABORADOR',
                                'area' => 'ÁREA',
                                'cargo' => 'CARGO',
                                'dias_trabajados' => 'DÍAS TRAB.',
                                'dias_descanso_obligatorio' => 'D. D.S.O.',
                                'feriado_no_laborado' => 'D. F.N.',
                                'feriado_laborado' => 'D. F.L.',
                                'falta_injustificada' => 'FALTA INJ.',
                                'dias_no_remunerados' => 'DIAS S/G',
                                'licencia_con_goce' => 'DIAS C/G',
                                'dias_remunerados_totales' => 'TOTAL REMUN.',
                            ];
                            
                            $columnas_a_mostrar = array_keys($tareo[0]);
                            
                            foreach ($columnas_a_mostrar as $col):
                                if (in_array($col, $columnas_a_omitir)) continue; 

                                $header_display = $col;
                                
                                if (isset($headers_map[$col])) {
                                    $header_display = $headers_map[$col];
                                } elseif (preg_match('/^d(\d+)$/', $col, $matches)) {
                                    $header_display = $matches[1]; 
                                }
                                
                                // Estilos y clases para fijar DNI/Colaborador
                                $total_class = (in_array($col, ['dias_remunerados_totales', 'dias_trabajados'])) ? 'bg-primary text-white text-center' : '';
                                $sticky_class = (in_array($col, ['dni', 'colaborador'])) ? 'sticky-header ' . ($col === 'dni' ? 'sticky-col-dni' : 'sticky-col-colab') : '';

                                echo '<th scope="col" class="' . $total_class . ' ' . $sticky_class . '" title="' . esc($col) . '">' . esc($header_display) . '</th>';
                            endforeach;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tareo as $fila): ?>
                            <tr class="align-middle">
                                <?php foreach($fila as $columna => $valor): ?>
                                    <?php 
                                        if (in_array($columna, $columnas_a_omitir)) continue;

                                        $clase_color = '';
                                        $valor_mostrar = esc($valor);
                                        
                                        // 1. Aplicar Semáforo a las columnas de días (d1, d2, d3...)
                                        if (preg_match('/^d\d+$/', $columna)) {
                                            switch ($valor) {
                                                case '-': 
                                                case 'LS': 
                                                case 'F': 
                                                    $clase_color = 'bg-danger text-white text-center fw-bold'; 
                                                    break;
                                                case 'T': 
                                                    $clase_color = 'bg-warning text-dark text-center'; 
                                                    break;
                                                case 'X': 
                                                case 'LC': 
                                                    $clase_color = 'bg-success-subtle text-center'; 
                                                    break;
                                                case 'O': 
                                                case 'FN': 
                                                    $clase_color = 'bg-info-subtle text-center'; 
                                                    break;
                                                case 'D': 
                                                    $clase_color = 'bg-primary text-white text-center fw-bold'; 
                                                    break;
                                                case NULL: 
                                                    $clase_color = 'bg-light text-center';
                                                    $valor_mostrar = ''; 
                                                    break;
                                            }
                                        } 
                                        
                                        // 2. Estilo para DNI, Colaborador y Totales
                                        $is_sticky = in_array($columna, ['dni', 'colaborador']);
                                        $sticky_cell_class = '';
                                        if ($is_sticky) {
                                            $sticky_cell_class = 'sticky-cell bg-white ' . ($columna === 'dni' ? 'sticky-col-dni' : 'sticky-col-colab');
                                        }

                                        if (in_array($columna, ['dias_remunerados_totales'])) {
                                            $clase_color = 'bg-primary text-white text-center fw-bold';
                                        } elseif (in_array($columna, ['dias_trabajados'])) {
                                             $clase_color = 'bg-info-subtle text-dark text-center fw-bold';
                                        } elseif (in_array($columna, ['falta_injustificada', 'dias_no_remunerados'])) {
                                            $clase_color = 'bg-danger-subtle text-dark text-center';
                                        } elseif (in_array($columna, ['area', 'cargo'])) {
                                            $clase_color = 'bg-light align-middle';
                                        }
                                        // Combinar clases (sticky_cell_class debe ir último para sobrescribir el color de fondo si es necesario)
                                        $final_classes = trim($clase_color . ' ' . $sticky_cell_class);

                                    ?>
                                    <td class="<?= $final_classes ?>"><?= $valor_mostrar ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay registros de tareo para el filtro aplicado.</div>
        <?php endif; ?>
    </div>
</div>
<?= $footer ?>

<style>
    /* Asegurar que los bordes no se rompan y el sticky funcione bien */
    .table-responsive > .table {
        border-collapse: separate !important;
        border-spacing: 0;
    }

    /* Base Sticky: Aplicar a todas las celdas y cabeceras que se fijarán */
    .sticky-cell, .sticky-header {
        position: sticky;
        z-index: 10; 
    }
    
    /* Sticky Vertical: Fijar cabecera al hacer scroll vertical */
    .sticky-header {
         top: 0; 
         background-color: #f8f9fa !important; /* Asegura el color de fondo de la cabecera (Bootstrap gray-100) */
         z-index: 12; /* Superior a la celda sticky normal */
    }

    /* Posicionamiento Horizontal: DNI */
    .sticky-col-dni {
        left: 0px; 
        min-width: 100px;
        max-width: 120px;
    }
    
    /* Posicionamiento Horizontal: COLABORADOR */
    .sticky-col-colab {
        /* Posición = ancho de DNI */
        left: 100px; 
        min-width: 200px; 
        max-width: 300px;
    }
    
    /* Asegurar que las celdas sticky tengan fondo blanco al deslizar */
    .sticky-cell {
        background-color: white !important; 
        box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Sombra ligera para diferenciar */
    }
</style>