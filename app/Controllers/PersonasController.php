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

/**
 * Controlador de Personas
 * 
 * Gestiona todas las operaciones relacionadas con el registro, consulta,
 * actualización y visualización de información de trabajadores.
 * Incluye búsqueda por DNI (local y API externa), gestión de contratos,
 * calendario de eventos y datos complementarios (cuentas bancarias,
 * sistema de pensiones, carga familiar).
 * 
 * @package App\Controllers

 */
class PersonasController extends BaseController
{
  /**
   * Lista todos los empleados registrados
   * 
   * Muestra la vista principal con el listado completo de todos
   * los trabajadores activos en el sistema.
   * 
   * @return string Vista con listado de empleados
   */
  public function index()
  {
    $personas = new Personas();
    $datos['listarpersonas'] = $personas->Vista_Empleados();
    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    return view("personas/index", $datos);
  }
  /**
   * Vista de búsqueda de personas
   * 
   * Muestra el formulario para realizar búsquedas de trabajadores
   * por su número de DNI
   * @return string
   */
  public function search()
  {
    $datos['header'] = view('Layouts/header');
    $datos['footer'] = view('Layouts/footer');
    return view('personas/search', $datos);
  }
  /**
   * Busca una persona por número de documento en la base de datos local
   * 
   * Realiza una búsqueda en la base de datos local del sistema
   * y retorna la información básica del trabajador si existe.
   * La cual nos sirve para validar si una persona ya esta registrada
   * 
   * @param mixed $numdoc Número de documento a buscar
   * 
   * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con datos o error
   */
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

  /**
   * Vista del formulario de registro de nueva persona
   * 
   * Carga el formulario de registro con los catálogos necesarios:
   * departamentos para la dirección del trabajador y sucursales disponibles.
   * 
   * @return string Vista del formulario de registro
   */
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

  /**
   * Registra una nueva persona en el sistema
   * 
   * Procesa el formulario de registro validando que no exista
   * duplicado de número de documento. Inserta todos los datos
   * personales del trabajador en la base de datos.

   * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de éxito o error
   */
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

  /**
   * Muestra información detallada de un trabajador
   * 
   * Presenta una vista completa con:
   * - Datos personales del trabajador
   * - Días restantes de contrato actual
   * - Historial de contratos vencidos
   * - Registro de asistencias

   * @param mixed $idpersona ID del trabajador
   * @return string Vista con información completa del trabajador
   */
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
  /**
   * Vista del calendario de eventos
   * 
   * Muestra un calendario interactivo con eventos importantes:
   * cumpleaños de trabajadores y vencimientos de contratos.
   *
   * @return string Vista del calendario
   */
  public function calendar()
  {
    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    return view("personas/calendar", $datos);
  }
  /**
   * Obtiene datos de eventos para el calendario
   * 
   * Genera un array JSON con dos tipos de eventos:
   * 1. Fin de contratos (color rojo) - Fecha exacta de vencimiento
   * 2. Cumpleaños (color azul) - Fecha del cumpleaños en el año actual
   *
   * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con array de eventos
   */
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
  /**
   * Busca una persona por DNI mediante API externa de RENIEC
   * 
   * Consulta los datos de una persona en la API de RENIEC (Perú)
   * utilizando el número de DNI. Útil para autocompletar datos
   * al registrar nuevos trabajadores.
   * 
   * Utiliza la API de decolecta.com con autenticación Bearer token.

   * @param mixed $dni Número de DNI a consultar (8 dígitos)
   * @return \CodeIgniter\HTTP\ResponseInterface Respuesta JSON con datos de RENIEC o error
   */
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
  /**
   * Muestra datos complementarios de un trabajador
   * 
   * Presenta una vista con información adicional del trabajador:
   * - Datos personales
   * - Cuentas bancarias registradas (historial completo)
   * - Sistema de pensiones (AFP/ONP)
   * - Carga familiar registrada
   *
   * @param mixed $idpersona ID del trabajador
   * @return string Vista con datos complementarios
   */
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

  /**
   * Actualiza los datos personales de un trabajador
   * 
   * Procesa el formulario de actualización de datos personales
   * modificando la información básica del trabajador.
   * No permite cambiar datos relacionados a contratos.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
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