<?php

namespace App\Controllers;

use App\Models\TareoModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TareoController extends BaseController
{
    protected $tareoModel;

    public function __construct()
    {
        $this->tareoModel = new TareoModel();
    }

    /**
     * index -> simple entry point: delega a tareo() para mantener todo consistente
     */
    public function index()
    {
        return $this->tareo();
    }

    /**
     * Muestra el formulario y la tabla del tareo.
     * Siempre pasa las variables que la vista necesita (anio, mes, dni, tareo, header, footer).
     */
    public function tareo()
    {
        // valores por defecto si no vienen en GET
        $anio = $this->request->getGet('anio') ?? date('Y');
        $mes  = $this->request->getGet('mes')  ?? date('m');
        $dni  = $this->request->getGet('dni')  ?? '';

        // obtener datos desde el modelo (SP)
        $tareoData = $this->tareoModel->obtenerTareo((int)$anio, (int)$mes, $dni);

        // preparar array $data que se pasará a la vista
        $data = [
            'anio'   => $anio,
            'mes'    => $mes,
            'dni'    => $dni,
            'tareo'  => $tareoData,
            'header' => view('Layouts/header'),
            'footer' => view('Layouts/footer'),
        ];

        // Asegúrate que la vista exista en app/Views/Asistencia/tareo.php
        return view('Asistencia/tareo', $data);
    }

    /**
     * Exporta a Excel el resultado actual del tareo (usa PhpSpreadsheet).
     */
    public function exportarExcel()
    {
        $anio = $this->request->getGet('anio') ?? date('Y');
        $mes  = $this->request->getGet('mes')  ?? date('m');
        $dni  = $this->request->getGet('dni')  ?? '';

        $data = $this->tareoModel->obtenerTareo((int)$anio, (int)$mes, $dni);

        if (empty($data)) {
            return redirect()->to('/tareo')->with('error', 'No hay datos para exportar');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $titulo = "TAREO DE LA EMPRESA YONDA & GRUPO HUARACA";
        $sheet->setCellValue('A1', $titulo);
        $sheet->mergeCells('A1:' . chr(65 + count($data[0]) - 1) . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Headers
        $col = 'A';
        foreach (array_keys($data[0]) as $header) {
            $sheet->setCellValue($col . '2', $header);
            $sheet->getStyle($col . '2')->getFont()->setBold(true);
            $col++;
        }

        // Filas
        $row = 3;
        foreach ($data as $fila) {
            $col = 'A';
            foreach ($fila as $valor) {
                $sheet->setCellValue($col . $row, $valor);
                $col++;
            }
            $row++;
        }

        $filename = "Tareo_{$anio}_{$mes}.xlsx";
        $writer = new Xlsx($spreadsheet);

        // Cabeceras HTTP y salida
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
