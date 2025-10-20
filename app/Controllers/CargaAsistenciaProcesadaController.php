<?php
namespace App\Controllers;

use App\Models\Personas;
use App\Models\Contratos;
use App\Models\Horarios;
use App\Models\AsistenciaDetallada;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CargaAsistenciaProcesadaController extends BaseController
{
    public function index()
    {
        return view('Asistencia/carga_asistencia_procesada', [
            'header' => view('layouts/header'),
            'footer' => view('layouts/footer')
        ]);
    }

    public function procesarExcel()
    {
        $file = $this->request->getFile('archivo');

        // Validar archivo
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Archivo no válido o no seleccionado.');
        }

        // Leer Excel
        $spreadsheet = IOFactory::load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $personasModel   = new Personas();
        $contratosModel  = new Contratos();
        $horariosModel   = new Horarios();
        $asistenciaModel = new AsistenciaDetallada();

        $datosAgrupados = [];

        // Agrupar por DNI + Fecha
        foreach ($rows as $i => $row) {
            $dni       = trim($row['A'] ?? '');
            $nombre    = trim($row['B'] ?? '');
            $fechaHora = trim($row['G'] ?? '');

            if (
                $i === 0 ||
                stripos($dni, 'id') !== false ||
                stripos($nombre, 'nombre') !== false ||
                stripos($fechaHora, 'fecha') !== false ||
                empty($dni) || empty($fechaHora) ||
                !is_numeric($dni)
            ) {
                continue;
            }

            $fecha = date('Y-m-d', strtotime($fechaHora));
            $hora  = date('H:i:s', strtotime($fechaHora));

            $key = $dni . '|' . $fecha;
            $datosAgrupados[$key]['dni'] = $dni;
            $datosAgrupados[$key]['nombre'] = $nombre;
            $datosAgrupados[$key]['fechas'][] = $hora;
        }

        // Arrays de errores
        $erroresNoExiste      = [];
        $erroresContrato      = [];
        $erroresFechaContrato = [];
        $erroresFechaFutura   = [];
        $erroresDuplicado     = [];

        $insertados = 0;
        $hoy = date('Y-m-d');

        foreach ($datosAgrupados as $key => $data) {
            $dni    = $data['dni'];
            $nombre = $data['nombre'];
            sort($data['fechas']);
            $fecha = explode('|', $key)[1];
            $horas = $data['fechas'];

            $entrada = $horas[0] ?? null;
            $inicioRefrig = null;
            $finRefrig = null;
            $salida = (count($horas) > 1) ? end($horas) : null;

            // Detectar refrigerio
            foreach ($horas as $h) {
                if ($h >= '11:30:00' && $h <= '13:30:00' && !$inicioRefrig) {
                    $inicioRefrig = $h;
                } elseif ($inicioRefrig && $h > $inicioRefrig && $h <= '15:00:00') {
                    $finRefrig = $h;
                    break;
                }
            }

            // Validar fecha futura
            if ($fecha > $hoy) {
                $erroresFechaFutura[] = [
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'fecha_asistencia' => $fecha,
                    'motivo' => "Fecha de asistencia es futura"
                ];
                continue;
            }

            // Validar persona
            $persona = $personasModel->where('numdoc', $dni)->first();
            if (!$persona) {
                $erroresNoExiste[] = [
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'fecha_asistencia' => $fecha,
                    'motivo' => "No existe persona"
                ];
                continue;
            }

            // Validar contrato
            $contrato = $contratosModel
                ->where('idpersona', $persona['idpersona'])
                ->where('fechainicio <=', $fecha)
                ->where('fechafin >=', $fecha)
                ->first();

            if (!$contrato) {
                $contratoExistente = $contratosModel->where('idpersona', $persona['idpersona'])->first();
                if ($contratoExistente) {
                    $erroresFechaContrato[] = [
                        'dni' => $dni,
                        'nombre' => $nombre,
                        'fecha_asistencia' => $fecha,
                        'motivo' => "Contrato no vigente para la fecha"
                    ];
                } else {
                    $erroresContrato[] = [
                        'dni' => $dni,
                        'nombre' => $nombre,
                        'fecha_asistencia' => $fecha,
                        'motivo' => "Contrato inexistente"
                    ];
                }
                continue;
            }

            // Día de la semana
            $diaSemana = strtolower(date('l', strtotime($fecha)));
            $dias = [
                'monday' => 'lunes', 'tuesday' => 'martes', 'wednesday' => 'miércoles',
                'thursday' => 'jueves', 'friday' => 'viernes',
                'saturday' => 'sábado', 'sunday' => 'domingo'
            ];
            $dia = $dias[$diaSemana] ?? null;

            // Buscar horario
            $horario = $horariosModel
                ->where('idcontrato', $contrato['idcontrato'])
                ->where('dia', $dia)
                ->first();

            if (!$horario) {
                $erroresContrato[] = [
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'fecha_asistencia' => $fecha,
                    'motivo' => "No hay horario para el día $dia"
                ];
                continue;
            }

            // Evitar duplicado
            $existe = $asistenciaModel
                ->where('idhorario', $horario['idhorario'])
                ->where('diamarcado', $fecha)
                ->first();

            if ($existe) {
                $erroresDuplicado[] = [
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'fecha_asistencia' => $fecha,
                    'motivo' => "Registro duplicado ya existente"
                ];
                continue;
            }

            // Cálculos de observaciones
            $observaciones = [];
            $tardanza = 0;
            $salidaAnticipada = 0;
            $excesoRefrigerio = 0;
            $minNoLaborados = 0;

            if ($entrada > $horario['entrada']) {
                $tardanza = $this->diferenciaMinutos($horario['entrada'], $entrada);
                $observaciones[] = "Tardanza {$tardanza} min";
            }

            if ($salida && $salida < $horario['salida']) {
                $salidaAnticipada = $this->diferenciaMinutos($salida, $horario['salida']);
                $observaciones[] = "Salida anticipada {$salidaAnticipada} min";
            }

            if ($inicioRefrig && $finRefrig) {
                $permitido = $this->diferenciaMinutos($horario['iniciorefrigerio'], $horario['finrefrigerio']);
                $real = $this->diferenciaMinutos($inicioRefrig, $finRefrig);
                if ($real > $permitido) {
                    $excesoRefrigerio = $real - $permitido;
                    $observaciones[] = "Exceso refrigerio {$excesoRefrigerio} min";
                }
            }

            if ($entrada && $salida) {
                $jornadaTotal = $this->diferenciaMinutos($horario['entrada'], $horario['salida']);
                $refrigerioPermitido = $this->diferenciaMinutos($horario['iniciorefrigerio'], $horario['finrefrigerio']);
                $total = $this->diferenciaMinutos($entrada, $salida);
                $refrigerioReal = ($inicioRefrig && $finRefrig)
                    ? $this->diferenciaMinutos($inicioRefrig, $finRefrig)
                    : 0;
                $minTrabajados = max(0, $total - $refrigerioReal);
                $minNoLaborados = max(0, ($jornadaTotal - $minTrabajados));
                if ($refrigerioReal > $refrigerioPermitido) {
                    $minNoLaborados += ($refrigerioReal - $refrigerioPermitido);
                }
            }

            // Insertar
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

        // Guardar errores en sesión
        $todosErrores = array_merge(
            $erroresNoExiste,
            $erroresContrato,
            $erroresFechaContrato,
            $erroresFechaFutura,
            $erroresDuplicado
        );
        session()->set('errores_asistencia', $todosErrores);

        // Mostrar resultados
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

    private function diferenciaMinutos($hora1, $hora2)
    {
        $t1 = strtotime($hora1);
        $t2 = strtotime($hora2);
        return ($t2 >= $t1) ? round(($t2 - $t1) / 60) : 0;
    }
}