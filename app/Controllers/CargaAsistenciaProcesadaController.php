<?php
namespace App\Controllers;

use App\Models\Personas;
use App\Models\Contratos;
use App\Models\Horarios;
use App\Models\AsistenciaDetallada;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class CargaAsistenciaProcesadaController extends BaseController
{
    // *** Los métodos index() y procesarExcel() no han cambiado. ***
    
    public function index()
    {
        return view('Asistencia/carga_asistencia_procesada', [
            'header' => view('layouts/header'),
            'footer' => view('layouts/footer')
        ]);
    }

    public function procesarExcel()
    {
        // La lógica de procesarExcel no requiere cambios para la estructura del reporte.
        $file = $this->request->getFile('archivo');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Archivo no válido o no seleccionado.');
        }

        $spreadsheet = IOFactory::load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true); 

        $personasModel   = new Personas();
        $contratosModel  = new Contratos();
        $horariosModel   = new Horarios();
        $asistenciaModel = new AsistenciaDetallada();

        $datosAgrupados = [];

        foreach ($rows as $i => $row) {
            $dni        = trim($row['A'] ?? '');
            $nombre     = trim($row['B'] ?? '');
            $fechaHora  = trim($row['G'] ?? '');

            if ($i === 1 || empty($dni) || empty($fechaHora) || !is_numeric($dni)) {
                continue;
            }
            
            $fecha = null; $hora = null;
            if (is_numeric($fechaHora) && $fechaHora > 1) {
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($fechaHora);
                $fecha = date('Y-m-d', $timestamp);
                $hora  = date('H:i:s', $timestamp);
            } else {
                $timestamp = strtotime($fechaHora);
                if ($timestamp !== false) {
                    $fecha = date('Y-m-d', $timestamp);
                    $hora  = date('H:i:s', $timestamp);
                }
            }

            if (!$fecha || !$hora) { continue; }

            $key = $dni . '|' . $fecha;
            $datosAgrupados[$key]['dni'] = $dni;
            $datosAgrupados[$key]['nombre'] = $nombre;
            $datosAgrupados[$key]['fechas'][] = $hora;
        }

        $erroresNoExiste = $erroresContrato = $erroresFechaContrato = $erroresFechaFutura = $erroresDuplicado = [];
        $insertados = 0;
        $hoy = date('Y-m-d');

        foreach ($datosAgrupados as $key => $data) {
            $dni    = $data['dni'];
            $nombre = $data['nombre'];
            sort($data['fechas']);
            $fecha = explode('|', $key)[1];
            $horas = $data['fechas'];

            if ($fecha > $hoy) { 
                $erroresFechaFutura[] = ['dni' => $dni, 'nombre' => $nombre, 'fecha_asistencia' => $fecha, 'motivo' => "Fecha de asistencia es futura"];
                continue; 
            }
            $persona = $personasModel->where('numdoc', $dni)->first();
            if (!$persona) { 
                $erroresNoExiste[] = ['dni' => $dni, 'nombre' => $nombre, 'fecha_asistencia' => $fecha, 'motivo' => "No existe persona"];
                continue; 
            }

            $contrato = $contratosModel
                ->where('idpersona', $persona['idpersona'])
                ->where('fechainicio <=', $fecha)
                ->where('fechafin >=', $fecha)
                ->first();
            if (!$contrato) { 
                $contratoExistente = $contratosModel->where('idpersona', $persona['idpersona'])->first();
                if ($contratoExistente) {
                    $erroresFechaContrato[] = ['dni' => $dni, 'nombre' => $nombre, 'fecha_asistencia' => $fecha, 'motivo' => "Contrato no vigente para la fecha"];
                } else {
                    $erroresContrato[] = ['dni' => $dni, 'nombre' => $nombre, 'fecha_asistencia' => $fecha, 'motivo' => "Contrato inexistente"];
                }
                continue; 
            }
            
            $diaSemana = strtolower(date('l', strtotime($fecha)));
            $dias = ['monday' => 'lunes', 'tuesday' => 'martes', 'wednesday' => 'miércoles', 'thursday' => 'jueves', 'friday' => 'viernes', 'saturday' => 'sábado', 'sunday' => 'domingo'];
            $dia = $dias[$diaSemana] ?? null;

            $horario = $horariosModel
                ->where('idcontrato', $contrato['idcontrato'])
                ->where('dia', $dia)
                ->first();

            if (!$horario) { 
                $erroresContrato[] = ['dni' => $dni, 'nombre' => $nombre, 'fecha_asistencia' => $fecha, 'motivo' => "No hay horario para el día $dia"];
                continue; 
            }
            
            $existe = $asistenciaModel
                ->where('idhorario', $horario['idhorario'])
                ->where('diamarcado', $fecha)
                ->first();
            if ($existe) { 
                $erroresDuplicado[] = ['dni' => $dni, 'nombre' => $nombre, 'fecha_asistencia' => $fecha, 'motivo' => "Registro duplicado ya existente"];
                continue; 
            }
            
            $entrada = null; $inicioRefrig = null; $finRefrig = null; $salida = null;
            $numMarcas = count($horas);

            if ($numMarcas >= 4) {
                $entrada = $horas[0]; $inicioRefrig = $horas[1]; $finRefrig = $horas[2]; $salida = $horas[3];
            } elseif ($numMarcas == 3) {
                $marca1 = $horas[0]; $marca2 = $horas[1]; $marca3 = $horas[2];
                
                if ($marca1 >= '11:00:00') {
                    $inicioRefrig = $marca1;
                    $finRefrig = $marca2; 
                    $salida = $marca3;
                    $entrada = null; 
                } else {
                    $entrada = $marca1;
                    $salida = $marca3;
                    if ($marca2 > $horario['iniciorefrigerio']) {
                        $finRefrig = $marca2; 
                    } else {
                        $inicioRefrig = $marca2;
                    }
                }
            } elseif ($numMarcas == 2) {
                $marca1 = $horas[0];
                $marca2 = $horas[1];

                if ($marca1 >= '11:00:00') {
                    $inicioRefrig = $marca1;
                    $salida = $marca2;
                    $entrada = null; 
                } else {
                    $entrada = $marca1;
                    $salida = $marca2;
                }
            } elseif ($numMarcas == 1) {
                $marcaUnica = $horas[0];
                
                if ($marcaUnica >= '11:00:00' && $marcaUnica <= '16:00:00') {
                    $inicioRefrig = $marcaUnica; 
                    $entrada = null; 
                    $salida = null; 
                } else {
                    $entrada = $marcaUnica;
                    $salida = null;
                }
            }
            
            $observaciones = [];
            $tardanza = 0; $salidaAnticipada = 0; $excesoRefrigerio = 0; $minNoLaborados = 0;
            
            $tieneRefrigerio = ($horario['iniciorefrigerio'] != '00:00:00' && $horario['finrefrigerio'] != '00:00:00');
            
            if ($entrada && $entrada > $horario['entrada']) {
                $tardanza = $this->diferenciaMinutos($horario['entrada'], $entrada);
                $observaciones[] = "Tardanza {$tardanza} min";
            } elseif (!$entrada) {
                $observaciones[] = "Cálculo de Tardanza omitido: Falta marca de Entrada.";
            }
            
            if ($salida && $salida < $horario['salida']) {
                $salidaAnticipada = $this->diferenciaMinutos($salida, $horario['salida']);
                $observaciones[] = "Salida anticipada {$salidaAnticipada} min";
            } elseif (!$salida) {
                $observaciones[] = "Cálculo de Salida Anticipada omitido: Falta marca de Salida.";
            }

            if ($tieneRefrigerio) {
                $refrigerioPermitidoMin = $this->diferenciaMinutos($horario['iniciorefrigerio'], $horario['finrefrigerio']);
                
                if ($inicioRefrig && $finRefrig) {
                    $real = $this->diferenciaMinutos($inicioRefrig, $finRefrig);
                    if ($real > $refrigerioPermitidoMin) {
                        $excesoRefrigerio = $real - $refrigerioPermitidoMin;
                        $observaciones[] = "Exceso refrigerio {$excesoRefrigerio} min";
                    }
                } else {
                    $motivo_falta = (!$inicioRefrig && (!$finRefrig || $finRefrig == '00:00:00')) ? "Inicio y Fin" : (!$inicioRefrig ? "Inicio" : "Fin");
                    $observaciones[] = "Cálculo de Exceso Refrigerio omitido: Falta marca de {$motivo_falta} de refrigerio.";
                }
            }
            
            $minNoLaborados = $tardanza + $salidaAnticipada + $excesoRefrigerio;

            $asistenciaModel->insert([
                'diamarcado' => $fecha,
                'entrada' => $entrada, 
                'iniciorefrigerio' => $inicioRefrig, 
                'finrefrigerio' => $finRefrig, 
                'salida' => $salida, 
                'tardanza_minutos' => $tardanza, 
                'salida_anticipada_minutos' => $salidaAnticipada, 
                'exceso_refrigerio_minutos' => $excesoRefrigerio,
                'minnolaborados' => $minNoLaborados,
                'observacion' => implode('; ', $observaciones),
                'idhorario' => $horario['idhorario']
            ]);

            $insertados++;
        }

        $todosErrores = array_merge(
            $erroresNoExiste,
            $erroresContrato,
            $erroresFechaContrato,
            $erroresFechaFutura,
            $erroresDuplicado
        );
        session()->set('errores_asistencia', $todosErrores);

        return view('Asistencia/carga_resultados_procesados', [
            'header' => view('layouts/header'),
            'footer' => view('layouts/footer'),
            'insertados' => $insertados,
            'erroresNoExiste' => $erroresNoExiste,
            'erroresContrato' => $erroresContrato,
            'erroresFechaContrato' => $erroresFechaContrato,
            'erroresFechaFutura' => $erroresFechaFutura,
            'erroresDuplicado' => $erroresDuplicado
        ]);
    }
    
    // ------------------------------------------------------------------
    // FUNCIÓN DE DESCARGA DE REPORTE SEMANAL 
    // ------------------------------------------------------------------
    
    public function descargarAsistencia()
    {
        $fechaInicio = $this->request->getPost('fechaInicio');
        $fechaFin = $this->request->getPost('fechaFin');
        $dni = $this->request->getPost('dni'); 
        
        if (empty($fechaInicio) || empty($fechaFin)) {
             return redirect()->back()->with('error', 'Debe especificar una fecha de inicio y una fecha de fin para generar el reporte.');
        }

        $asistenciaModel = new AsistenciaDetallada();

        $query = $asistenciaModel
            ->select('ad.*, p.numdoc, CONCAT(p.apepaterno, " ", p.apematerno, " ", p.nombres) as nombre_completo, h.dia as dia_semana')
            ->from('asistencias ad') 
            ->join('horarios h', 'h.idhorario = ad.idhorario')
            ->join('contratos c', 'c.idcontrato = h.idcontrato')
            ->join('personas p', 'p.idpersona = c.idpersona')
            ->where('ad.diamarcado >=', $fechaInicio)
            ->where('ad.diamarcado <=', $fechaFin)
            ->orderBy('p.numdoc, ad.diamarcado');
            
        if (!empty($dni)) {
            $query->where('p.numdoc', $dni);
        }

        $registros = $query->findAll();

        if (empty($registros)) {
            $msg = "No se encontraron registros de asistencia procesada entre {$fechaInicio} y {$fechaFin}";
            if (!empty($dni)) {
                $msg .= " para el DNI {$dni}";
            }
            return redirect()->back()->with('error', $msg . ".");
        }

        $reporte = $this->estructurarDatosParaReporte($registros);
        
        // Se llama a la función corregida para generar el Excel
        return $this->generarReporteSemanalExcel($reporte, $fechaInicio, $fechaFin);
    }
    
    /**
     * Estructura los datos planos de asistencia en una matriz pivoteada por Persona y Semana.
     * Mantiene la lógica de formato de fecha a dd/mm/yyyy.
     */
    private function estructurarDatosParaReporte(array $registros)
    {
        $reporte = [];

        foreach ($registros as $reg) {
            $timestamp = strtotime($reg['diamarcado']);
            $numeroSemana = date('W', $timestamp); 
            
            $dni = $reg['numdoc'];
            $nombre = $reg['nombre_completo'];
            $diaSemana = strtolower(date('l', $timestamp)); 
            
            // Formato de fecha a dd/mm/yyyy
            $fechaCompleta = date('d/m/Y', $timestamp); 

            if (!isset($reporte[$numeroSemana])) {
                $reporte[$numeroSemana] = [
                    'inicio_semana' => date('d/m/Y', strtotime('this monday', $timestamp)),
                    'fin_semana' => date('d/m/Y', strtotime('this sunday', $timestamp)),
                    'personas' => [],
                    'fechas_por_dia' => [] // Para almacenar la fecha específica de cada día en la semana
                ];
            }
            
            // Almacenar la fecha real del día para el encabezado
            $reporte[$numeroSemana]['fechas_por_dia'][$diaSemana] = $fechaCompleta;

            if (!isset($reporte[$numeroSemana]['personas'][$dni])) {
                $reporte[$numeroSemana]['personas'][$dni] = [
                    'DNI' => $dni,
                    'Nombre' => $nombre,
                    'dias' => []
                ];
            }
            
            $reporte[$numeroSemana]['personas'][$dni]['dias'][$diaSemana] = [
                'Entrada'               => $reg['entrada'] ? date('H:i', strtotime($reg['entrada'])) : '',
                'InicioRefrigerio'      => $reg['iniciorefrigerio'] ? date('H:i', strtotime($reg['iniciorefrigerio'])) : '',
                'FinRefrigerio'         => $reg['finrefrigerio'] ? date('H:i', strtotime($reg['finrefrigerio'])) : '',
                'Salida'                => $reg['salida'] ? date('H:i', strtotime($reg['salida'])) : '',
                'Tardanza_minutos'      => $reg['tardanza_minutos'],
                'SalidaAnticipada_min'  => $reg['salida_anticipada_minutos'],
                'exceso_refrigerio_minutos' => $reg['exceso_refrigerio_minutos'], 
                'minnolaborados'        => $reg['minnolaborados'],
                'Observacion'           => $reg['observacion'] 
            ];
        }

        return $reporte;
    }

    /**
     * Genera el archivo Excel (XLSX) con el formato de reporte semanal.
     * CORRECCIÓN FINAL: Lógica de colores ajustada:
     * - ROJO: Falta Completa.
     * - AMARILLO: SÓLO si hay Tardanza. Ignora Salida Anticipada y Exceso Refrigerio para el color de fondo.
     */
    private function generarReporteSemanalExcel(array $reporte, $fechaInicioFiltro, $fechaFinFiltro)
    {
        $spreadsheet = new Spreadsheet();
        // Días de Lunes a Sábado.
        $diasOrden = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']; 
        $diasMap = [
            'monday' => 'LUNES', 'tuesday' => 'MARTES', 'wednesday' => 'MIÉRCOLES', 
            'thursday' => 'JUEVES', 'friday' => 'VIERNES', 'saturday' => 'SÁBADO'
        ];
        // 4 COLUMNAS DE MARCA POR DÍA
        $marcas = ['Entrada', 'I. Refrig.', 'F. Refrig.', 'Salida']; 
        $colsPorDia = count($marcas); 

        $firstSheetCreated = false;

        // Definir estilos de colores para el reporte
        $COLOR_HEADER_BG = ['rgb' => 'D9D9D9']; // Gris para encabezados principales
        $COLOR_SUBHEADER_BG = ['rgb' => 'D0CECE']; // Gris más claro para subtítulos de marcas
        $COLOR_ROJO_FALTA = ['rgb' => 'FF0000']; // Rojo para falta
        $COLOR_AMARILLO_TARDANZA = ['rgb' => 'FFFF00']; // Amarillo para tardanza/penalización
        $COLOR_BLANCO = ['rgb' => 'FFFFFF']; // Blanco por defecto

        // Estilo para bordes de celdas
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Ordenar las semanas por número de semana
        ksort($reporte);

        foreach ($reporte as $numSemana => $datosSemana) {
            
            // Crear o seleccionar hoja por número de semana (S1, S2, etc.)
            if (!$firstSheetCreated) {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle("S{$numSemana}");
                $firstSheetCreated = true;
            } else {
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle("S{$numSemana}");
            }
            
            // Ajustes iniciales de la hoja
            $sheet->getDefaultColumnDimension()->setWidth(8); // Ancho por defecto (reducido a 8)
            $sheet->getColumnDimension('A')->setWidth(12); // DNI
            $sheet->getColumnDimension('B')->setWidth(25); // PERSONAL
            $sheet->getDefaultRowDimension()->setRowHeight(15); 

            // ------------------ 1. LEYENDAS Y TÍTULO ------------------
            $sheet->setCellValue('C1', 'Tardanza'); // Etiqueta ajustada solo a Tardanza
            $sheet->getStyle('C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_AMARILLO_TARDANZA['rgb']);
            $sheet->getStyle('C1')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
            $sheet->getStyle('C1')->getFont()->setBold(true);

            // LEYENDA FALTA
            $sheet->setCellValue('E1', 'No marcó asistencia'); // Texto para Falta Completa
            $sheet->getStyle('E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_ROJO_FALTA['rgb']);
            $sheet->getStyle('E1')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
            $sheet->getStyle('E1')->getFont()->setBold(true);

            // Título principal de la semana 
            $sheet->setCellValue('A3', 'ASISTENCIA SEMANAL');
            $sheet->mergeCells('A3:' . Coordinate::stringFromColumnIndex(count($diasOrden) * $colsPorDia + 2) . '3');
            $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0'); 

            // ------------------ 2. ENCABEZADOS DE DÍAS Y MARCAS (Filas 4, 5 y 6) ------------------
            $currentRow = 4; // Fila donde inician los Días de la semana
            $colIndex = 3; // Inicia en Columna C
            
            // Encabezados 'DNI' y 'PERSONAL' (Fila 4 y 5)
            $sheet->setCellValue('A' . $currentRow, 'DNI');
            $sheet->setCellValue('B' . $currentRow, 'PERSONAL');
            $sheet->mergeCells('A' . $currentRow . ':A' . ($currentRow + 2)); // Fusionar DNI en 3 filas
            $sheet->mergeCells('B' . $currentRow . ':B' . ($currentRow + 2)); // Fusionar PERSONAL en 3 filas

            // Alinear y aplicar estilo a DNI/PERSONAL
            $sheet->getStyle('A' . $currentRow . ':B' . ($currentRow + 2))->applyFromArray($styleBorder);
            $sheet->getStyle('A' . $currentRow . ':B' . ($currentRow + 2))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $currentRow . ':B' . ($currentRow + 2))->getFont()->setBold(true);
            $sheet->getStyle('A' . $currentRow . ':B' . ($currentRow + 2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_HEADER_BG['rgb']);

            foreach ($diasOrden as $diaKey) {
                // Encabezado del DÍA DE LA SEMANA (Fila 4)
                $startCol = Coordinate::stringFromColumnIndex($colIndex);
                $endCol = Coordinate::stringFromColumnIndex($colIndex + $colsPorDia - 1); // 4 columnas por día
                
                $sheet->setCellValue($startCol . $currentRow, $diasMap[$diaKey] ?? '');
                $sheet->mergeCells($startCol . $currentRow . ':' . $endCol . $currentRow);
                $sheet->getStyle($startCol . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($startCol . $currentRow)->getFont()->setBold(true);
                $sheet->getStyle($startCol . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_HEADER_BG['rgb']);
                $sheet->getStyle($startCol . $currentRow . ':' . $endCol . $currentRow)->applyFromArray($styleBorder);

                // Encabezado de la FECHA (Fila 5)
                $fechaDelDia = $datosSemana['fechas_por_dia'][$diaKey] ?? ''; // Obtener la fecha real del día (dd/mm/yyyy)
                $sheet->setCellValue($startCol . ($currentRow + 1), $fechaDelDia);
                $sheet->mergeCells($startCol . ($currentRow + 1) . ':' . $endCol . ($currentRow + 1));
                $sheet->getStyle($startCol . ($currentRow + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($startCol . ($currentRow + 1))->getFont()->setBold(true)->setSize(9);
                $sheet->getStyle($startCol . ($currentRow + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_HEADER_BG['rgb']);
                $sheet->getStyle($startCol . ($currentRow + 1) . ':' . $endCol . ($currentRow + 1))->applyFromArray($styleBorder);


                // Sub-encabezados de MARCAS (Fila 6)
                for ($i = 0; $i < $colsPorDia; $i++) {
                    $colMark = Coordinate::stringFromColumnIndex($colIndex + $i);
                    $sheet->setCellValue($colMark . ($currentRow + 2), $marcas[$i]);
                    $sheet->getStyle($colMark . ($currentRow + 2))->applyFromArray($styleBorder);
                    $sheet->getStyle($colMark . ($currentRow + 2))->getFont()->setBold(true)->setSize(9);
                    $sheet->getStyle($colMark . ($currentRow + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($colMark . ($currentRow + 2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_SUBHEADER_BG['rgb']);
                }

                $colIndex += $colsPorDia; // Mover al inicio del siguiente día
            }
            
            // ------------------ 3. DATOS POR PERSONA ------------------
            $rowNum = $currentRow + 3; // Los datos inician en la fila 7
            
            foreach ($datosSemana['personas'] as $dni => $dataPersona) {
                $sheet->setCellValue('A' . $rowNum, $dataPersona['DNI']);
                $sheet->setCellValue('B' . $rowNum, $dataPersona['Nombre']);
                
                // Aplicar bordes a DNI y PERSONAL
                $sheet->getStyle('A' . $rowNum)->applyFromArray($styleBorder);
                $sheet->getStyle('B' . $rowNum)->applyFromArray($styleBorder);

                $colIndex = 3; // Reiniciar para los días de la semana
                
                foreach ($diasOrden as $diaKey) {
                    $datosDia = $dataPersona['dias'][$diaKey] ?? [];
                    
                    // Solo aplicar lógica si hay datos de asistencia procesada para ese día
                    if (isset($dataPersona['dias'][$diaKey])) {
                        $currentCol = $colIndex;
                        
                        // Setear valores de datos (Entrada, I. Refrig., F. Refrig., Salida)
                        $valoresMarcas = [
                            $datosDia['Entrada'] ?? '',
                            $datosDia['InicioRefrigerio'] ?? '',
                            $datosDia['FinRefrigerio'] ?? '',
                            $datosDia['Salida'] ?? ''
                        ];
                        
                        // Lógica de Colores FINAL (AJUSTADA)
                        $colorFondo = $COLOR_BLANCO;
                        
                        // 1. ROJO: Falta Completa (No marcó Entrada Y no marcó Salida)
                        if (empty($datosDia['Entrada']) && empty($datosDia['Salida'])) {
                            $colorFondo = $COLOR_ROJO_FALTA;
                        }
                        // 2. AMARILLO: SÓLO si hay Tardanza
                        elseif ($datosDia['Tardanza_minutos'] > 0) {
                            $colorFondo = $COLOR_AMARILLO_TARDANZA;
                        }
                        // 3. BLANCO: En todos los demás casos (correcto, o penalizaciones de refrigerio/salida anticipada)
                        
                        
                        // Aplicar datos y colores a las 4 celdas de marca del día
                        for ($i = 0; $i < $colsPorDia; $i++) {
                             $colCell = Coordinate::stringFromColumnIndex($currentCol + $i);
                             $sheet->setCellValue($colCell . $rowNum, $valoresMarcas[$i]);
                             $sheet->getStyle($colCell . $rowNum)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($colorFondo['rgb']);
                             $sheet->getStyle($colCell . $rowNum)->applyFromArray($styleBorder);
                             $sheet->getStyle($colCell . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        }
                    } else {
                        // Si el día no existe en el registro, queda BLANCO por defecto
                        $startColCell = Coordinate::stringFromColumnIndex($colIndex);
                        $endColCell = Coordinate::stringFromColumnIndex($colIndex + $colsPorDia - 1);
                        $sheet->getStyle($startColCell . $rowNum . ':' . $endColCell . $rowNum)->applyFromArray($styleBorder);
                        $sheet->getStyle($startColCell . $rowNum . ':' . $endColCell . $rowNum)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($COLOR_BLANCO['rgb']);
                    }
                    
                    $colIndex += $colsPorDia; // Mover al inicio del siguiente bloque de día
                }
                
                $rowNum++;
            }
            
            // Ajustar el ancho de las columnas (final)
            $lastColFinal = Coordinate::stringFromColumnIndex($colIndex - 1);
            foreach (range('A', $lastColFinal) as $c) {
                $sheet->getColumnDimension($c)->setAutoSize(true);
            }
        }
        
        // ------------------ 4. DESCARGA EN XLSX ------------------
        $writer = new Xlsx($spreadsheet);
        $filename = 'reporte_semanal_asistencia_' . $fechaInicioFiltro . '_a_' . $fechaFinFiltro . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
    
    // ------------------------------------------------------------------
    // FUNCIONES AUXILIARES (Descarga de errores y diferencia de minutos)
    // ------------------------------------------------------------------
    
    public function descargarErrores()
    {
        $errores = session()->get('errores_asistencia') ?? [];
        if (empty($errores)) {
            return redirect()->back()->with('error', 'No hay errores para descargar.');
        }
        return $this->descargarErroresExcel($errores);
    }

    private function descargarErroresExcel(array $errores)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'DNI');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Fecha Asistencia');
        $sheet->setCellValue('D1', 'Motivo');

        $rowNum = 2;
        foreach ($errores as $err) {
            $sheet->setCellValue('A' . $rowNum, $err['dni'] ?? '');
            $sheet->setCellValue('B' . $rowNum, $err['nombre'] ?? '');
            $sheet->setCellValue('C' . $rowNum, $err['fecha_asistencia'] ?? '');
            $sheet->setCellValue('D' . $rowNum, $err['motivo'] ?? '');
            $rowNum++;
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'errores_asistencia_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Calcula la diferencia en minutos entre dos horas.
     */
    private function diferenciaMinutos($hora1, $hora2)
    {
        $t1 = strtotime($hora1);
        $t2 = strtotime($hora2);
        return ($t2 >= $t1) ? round(($t2 - $t1) / 60) : 0;
    }
}
