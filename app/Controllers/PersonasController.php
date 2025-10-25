<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CargaFamiliar;
use App\Models\NumeroCuenta;
use App\Models\Personas;
use App\Models\Departamentos;
use App\Models\Contratos;
use App\Models\SistemaPensiones;
use App\Models\Sucursal;
use App\Models\Asistencia;

use DateTime;


class PersonasController extends BaseController
{

  public function index()
  {
    $personas = new Personas();
    $datos['listarpersonas'] = $personas->Vista_Empleados();
    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    return view("personas/index", $datos);
  }
  public function search()
  {
    $datos['header'] = view('Layouts/header');
    $datos['footer'] = view('Layouts/footer');
    return view('personas/search', $datos);
  }
  public function searchDNIPersonas($numdoc = null)
  {
    $persona = new Personas();
    $this->response->setContentType('application/json');

    if (empty($numdoc)) {
      return $this->response->setJSON([
        'success' => false,
        'mensaje' => 'Debe indicar el Número de documento'
      ]);
    }

    $registro = $persona->where('numdoc', $numdoc)->first();

    if (!$registro) {
      return $this->response->setJSON([
        'success' => false,
        'mensaje' => 'No se encontraron registros'
      ]);
    }

    return $this->response->setJSON([
      'success' => true,
      'idpersona' => $registro['idpersona'],
      'nombres' => $registro['nombres'],
      'apepaterno' => $registro['apepaterno'],
      'apematerno' => $registro['apematerno'],
      'numdoc' => $registro['numdoc']
    ]);
  }


  public function crear()
  {
    $departamentos = new Departamentos();
    $sucursal = new Sucursal();
    //Para dirección de las personas
    $datos['departamentos'] = $departamentos->orderBy('iddepartamento', "ASC")->findAll();
    //Para la dirección de la Sucursal
    $datos['sucursal'] = $sucursal->orderBy('idsucursal', "ASC")->findAll();
    //para mostrar datos de cuenta bancaria dentro del registro

    $datos['header'] = view('Layouts/header');
    $datos['footer'] = view('Layouts/footer');
    //index es el nombre del archivo que está en al carpeta views
    return view('Personas/registrar', $datos);
  }


  public function registrar()
  {
    $personas = new Personas();

    // Captura de variables
    $apepaterno = $this->request->getVar('apepaterno');
    $apematerno = $this->request->getVar('apematerno');
    $nombres = $this->request->getVar('nombres');
    $fechanac = $this->request->getVar('fechanac');
    $genero = $this->request->getVar('genero');
    $estadocivil = $this->request->getVar('estadocivil');
    $tipodoc = $this->request->getVar('tipodoc');
    $numdoc = $this->request->getVar('numdoc');
    $direccion = $this->request->getVar('direccion');
    $referencia = $this->request->getVar('referencia');
    $telefono = $this->request->getVar('telefono');
    $email = $this->request->getVar('email');
    $iddistrito = $this->request->getVar('iddistrito');


    // Validar duplicado de DNI
    if ($personas->where('numdoc', $numdoc)->first()) {
      return redirect()->back()->withInput()->with('error', 'El número de documento ya está registrado');
    }

    // Datos a insertar
    $data = [
      'apepaterno' => $apepaterno,
      'apematerno' => $apematerno,
      'nombres' => $nombres,
      'fechanac' => $fechanac,
      'genero' => $genero,
      'estadocivil' => $estadocivil,
      'tipodoc' => $tipodoc,
      'numdoc' => $numdoc,
      'direccion' => $direccion,
      'referencia' => $referencia,
      'telefono' => $telefono,
      'email' => $email,
      'iddistrito' => $iddistrito
    ];

    if (!$personas->insert($data)) {
      return redirect()->back()->withInput()->with('error', 'Error al registrar la persona');
    }

    return redirect()->to(base_url('personas/buscarpersona'))->with('success', 'Registro exitoso');
  }


  public function info($idpersona)
  {
    $personas = new Personas();
    $contratos = new Contratos();
    $asistencia = new Asistencia();

    $datos['tiemporestante'] = $contratos->Vista_dias_restantes($idpersona);
    $datos['trabajador'] = $personas->Vista_Info($idpersona);
    $datos['contratosVencido'] = $contratos->getHistorialContratosVencidos($idpersona);
    $datos['asistenciapersona'] = $asistencia->Vista_Asistenciapersona($idpersona);


    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    return view("personas/info", $datos);
  }
  public function calendar()
  {
    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    return view("personas/calendar", $datos);
  }
  public function calendarData()
  {
    $personas = new Personas();
    $empleados = $personas->Vista_Empleados();
    $eventos = [];

    foreach ($empleados as $e) {
      // Evento fin de contrato
      $eventos[] = [
        'title' => 'Fin contrato: ' . $e['apepaterno'] . ' ' . $e['nombres'],
        'start' => $e['fechafin'],
        'color' => 'red'
      ];

      // Evento cumpleaños (día y mes, pero para este año)
      $fechaNacimiento = new DateTime($e['fechanac']);
      $cumpleEsteAnio = date('Y') . '-' . $fechaNacimiento->format('m-d');

      $eventos[] = [
        'title' => 'Cumpleaños: ' . $e['apepaterno'] . ' ' . $e['nombres'],
        'start' => $cumpleEsteAnio,
        'color' => 'blue'
      ];
    }

    return $this->response->setJSON($eventos);
  }

  public function searchByDniAPI($dni = "")
  {
    $api_endpoint = "https://api.decolecta.com/v1/reniec/dni?numero=" . $dni;
    $api_token = "sk_10065.YI6OCcaRNSNDpH1dlvk7M4dnMZ0tb59m";
    $content_type = "application/json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Content-Type:" . $content_type,
      "Authorization: Bearer " . $api_token
    ]);

    //ejecutar la peticion
    $api_response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($api_response === false) {
      return $this->response->setJSON([
        'success' => false,
        'mensaje' => 'Error en la conexión a la API'
      ]);
    }
    //Decodificar la respuesta JSON
    $decoded_response = json_decode($api_response, true);
    if ($http_code === 404) {
      return $this->response->setJSON([
        'success' => false,
        'mensaje' => 'No se encontraro a la persona'
      ]);
    }
    return $this->response->setJSON([
      'success' => true,
      'apepaterno' => $decoded_response['first_last_name'],
      'apematerno' => $decoded_response['second_last_name'],
      'nombres' => $decoded_response['first_name'],
      'numerodoc' => $decoded_response['document_number']
    ]);
  }

  public function mostrardatos($idpersona = null)
  {
    $numerocuenta = new NumeroCuenta();
    $asignacionfamiliar = new CargaFamiliar();
    $sispensiones = new SistemaPensiones();
    $personas = new Personas();

    $persona = $personas->find($idpersona);
    $datos['persona'] = $persona;

    $datos['numcuenta'] = $numerocuenta->getnumerocuenta($idpersona);
    $datos['sispensiones'] = $sispensiones->getsistemapensiones($idpersona);
    $datos['cargafamiliar'] = $asignacionfamiliar->getcargafamiliar($idpersona);
    $datos['header'] = view('Layouts/header');
    $datos['footer'] = view('Layouts/footer');
    return view('Personas/actualizaciones', $datos);
  }

  public function updatedata()
  {
    $personas = new Personas();
    $datos = [
      "apepaterno" => $this->request->getVar('apepaterno'),
      "apematerno" => $this->request->getVar('apematerno'),
      "nombres" => $this->request->getVar('nombres'),
      "fechanac" => $this->request->getVar('fechanac'),
      "genero" => $this->request->getVar('genero'),
      "estadocivil" => $this->request->getVar('estadocivil'),
      "tipodoc" => $this->request->getVar('tipodoc'),
      "numdoc" => $this->request->getVar('numdoc'),
      "direccion" => $this->request->getVar('direccion'),
      "referencia" => $this->request->getVar('referencia'),
      "telefono" => $this->request->getVar('telefono'),
      "email" => $this->request->getVar('email'),
    ];
    $id = $this->request->getVar('idpersona');
    $personas->update($id, $datos);
    return $this->response->redirect(base_url('personas'));
  }
}