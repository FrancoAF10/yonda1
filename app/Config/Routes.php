<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta que contiene un / es la principal => www.miweb.com

//Las rutas que se acceden por GET son las que se utilizan como URL
//Cuando se tratan de POST son por FORMULARIO



// ===================================================================
// =========== RUTAS DEL CONTROLADOR LoginController =================
// ===================================================================

//ruta de login
$routes->get('/', 'LoginController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/auth', 'LoginController::auth');
$routes->post('/login/reset', 'LoginController::resetPassword'); 
$routes->post('/login/validar', 'LoginController::validar'); 
$routes->post('/login/verificarCodigo', 'LoginController::verificarCodigo');
$routes->post('/login/cambiarClave', 'LoginController::cambiarClave');

// ===================================================================
// ========== FIN DE RUTAS DEL CONTROLADOR LoginController ===========
// ===================================================================







// ===================================================================
// ========== RUTAS DEL CONTROLADOR AsistenciaController =============
// ===================================================================

//miweb.com/clientes
//$objeto->metodo()   Se utiliza cuando $objeto es una instancia de una clase
//Clase::metodo()     Se está utilizando un método sin instanciar la clase
// ruta para mostrar la asistencia del personal asi como un filtro dinamico
$routes->get('/asistencia/hoy', 'AsistenciaController::hoy');
$routes->get('asistencia', 'AsistenciaController::index');
$routes->post('asistencia', 'AsistenciaController::index');

// ===================================================================
// ======== FIN DE RUTAS DEL CONTROLADOR AsistenciaController ========
// ===================================================================









// ===================================================================
// =========== RUTAS DEL CONTROLADOR PersonasController ==============
// ===================================================================

//personas
$routes->get('api/consultar-dni/(:num)', 'Administrativo\Trabajadores\PersonaController::consultarDNI/$1');
$routes->get('/personas', 'PersonasController::index');
$routes->get('/personas/buscarpersona', 'PersonasController::search');
$routes->get('/personas/crear', 'PersonasController::crear');
$routes->get('/personas/updatedata/(:num)', 'PersonasController::mostrardatos/$1');
$routes->post('/personas/registrar', 'PersonasController::registrar');
$routes->post('/personas/actualizar', 'PersonasController::updatedata');

//validamos si el trabajador esta en la database
$routes->get('/api/personas/buscarnumdocpersonas/(:any)', 'PersonasController::searchDNIPersonas/$1');
//buscamos datos de las personas con la api de decolecta
$routes->get('/api/personas/buscardni/(:num)', 'PersonasController::searchByDniAPI/$1');

//ruta para mostrar la informacion del empleado
$routes->get('/personas/info/(:num)', 'PersonasController::info/$1');
//full calendar
$routes->get('personas/calendar', 'PersonasController::calendar');
$routes->get('personas/calendarData', 'PersonasController::calendarData');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR PersonasController =========
// ===================================================================









// ===================================================================
// ========== RUTAS DEL CONTROLADOR ContratosController ==============
// ===================================================================

//VISTA DE NUEVO CONTRATO
$routes->get('/contratos/nuevocontrato/(:num)', 'ContratosController::crearcontrato/$1');
//CREAMOS UN NUEVO PERSONAL
$routes->post('/contratos/nuevopersonal', 'ContratosController::crearpersonal');
// Ruta para vista Contratos>contratosvencidos(Renovacion)
$routes->get('/Renovacion/ContratosVencidos', 'ContratosController::index');
// Ruta para vista Contratos>nuevocontrato
$routes->get('/Renovacion/NuevoContrato/(:num)','ContratosController::nuevoContrato/$1');
//Para crear un nuevo contrato
$routes->post('/renovacion/nuevocontrato', 'ContratosController::renovacion');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR ContratosController ========
// ===================================================================









// ===================================================================
// ============ RUTAS DEL CONTROLADOR HorarioController ==============
// ===================================================================

// vista para Contratos/horarios
$routes->get('/personas/horario', 'HorarioController::index');
//ruta para traer los datos de un colaborador dentro de horario
$routes->get('horario/buscar/(:any)',  'HorarioController::searchByDNI/$1');
//ruta para ingresar los dias laborales de cada trabajador
$routes->post('horario/registrar',  'HorarioController::asignarHorario');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR HorarioController ==========
// ===================================================================










//Departamento, Provincias y Distritos de la persona + sucursales, áreas cargos
$routes->get('/provincias/(:num)', 'ProvinciaController::getProvinciasByDepartamento/$1');  
$routes->get('/distritos/(:num)', 'DistritoController::getDistritosByProvincia/$1');

$routes->get('/areas/(:num)', 'AreaController::getAreasBySucursal/$1');
$routes->get('/cargos/(:num)', 'CargoController::getCargosByArea/$1');






// ===================================================================
// ============ RUTAS DEL CONTROLADOR SucursalController =============
// ===================================================================

$routes->get('/sucursales/(:num)', 'SucursalController::getSucursalesByDistrito/$1');
//ruta para sucursales
$routes->get('/sucursal', 'Administrativo\Organizacion\SucursalController::index');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR SucursalController =========
// ===================================================================









// ===================================================================
// ========== RUTAS DEL CONTROLADOR FinContratoController ============
// ===================================================================

$routes->get('/fincontrato/(:num)', 'FinContratoController::indexDespido/$1');
$routes->post('/fincontrato/finalizacion', 'FinContratoController::registrarDespido');

// ===================================================================
// ======= FIN DE RUTAS DEL CONTROLADOR FinContratoController ========
// ===================================================================






// ===================================================================
// =========== RUTAS DEL CONTROLADOR PermisoController ===============
// ===================================================================

//ruta para permiso
$routes->get('asistencia/permiso', 'PermisoController::index');
$routes->get('permiso/buscar/(:num)',  'PermisoController::searchByDNI/$1');
$routes->post('permiso/registrar',  'PermisoController::registrarPermiso');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR PermisoController ==========
// ===================================================================






// ===================================================================
// ============= RUTAS DEL CONTROLADOR TareoController ===============
// ===================================================================

// ruta para el tareo mensual 
$routes->get('tareo', 'TareoController::index');
$routes->get('tareo/tareo', 'TareoController::tareo');
$routes->get('tareo/exportarExcel', 'TareoController::exportarExcel');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR TareoController ============
// ===================================================================






// ===================================================================
// =========== RUTAS DEL CONTROLADOR DespidoController ===============
// ===================================================================

//ruta para formulario de despido
$routes->get('/personas/borrar/(:num)', 'DespidoController::indexDespido/$1');
$routes->post('/personas/borrar', 'DespidoController::registrarDespido/$1');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR DespidoController ==========
// ===================================================================






// ===================================================================
// ============ RUTAS DEL CONTROLADOR ReporteController ==============
// ===================================================================

$routes->get('/personas/r1','ReporteController::getReport1');
$routes->get('/personas/r1/(:num)', 'ReporteController::getReport1/$1');

// ===================================================================
// ========= FIN DE RUTAS DEL CONTROLADOR ReporteController ==========
// ===================================================================






// ===================================================================
// ==== RUTAS DEL CONTROLADOR CargaAsistenciaProcesadaController =====
// ===================================================================

//ruta para carga de asistencia detallada
$routes->get('carga-asistencia-procesada', 'CargaAsistenciaProcesadaController::index');
$routes->post('carga-asistencia-procesada/procesar', 'CargaAsistenciaProcesadaController::procesarExcel');
$routes->post('carga-asistencia-procesada/descargar-errores', 'CargaAsistenciaProcesadaController::descargarErrores');

// ===================================================================
// = FIN DE RUTAS DEL CONTROLADOR CargaAsistenciaProcesadaController =
// ===================================================================












// boleta

//AGREGAR CUENTA BANCARIA
$routes->post('/numcuenta/guardar','NumeroCuentaController::crear');
//AGREGAR PARENTESCO
$routes->post('/cargafamiliar/guardar','CargaFamiliarController::crear');
//AGREGAR SISTEMA PENSIONES
$routes->post('/sispensiones/guardar','SistemaPensionesController::crear');


//ruta para area
$routes->get('/areas', 'Administrativo\Organizacion\AreasController::index');

//ruta para colaboradores
$routes->get('/colaboradores', 'Administrativo\Organizacion\ColaboradoresController::index');


//ruta para desvinculados
$routes->get('/desvinculados', 'Administrativo\Trabajadores\DesvinculadosController::index');

//ruta para otros->LICENCIAS
$routes->get('/otros', 'Administrativo\Trabajadores\OtrosController::index');
$routes->post('/otros/licencias/registrar','LicenciasController::registrar');
$routes->get('/licencias/buscar/(:any)','Administrativo\Trabajadores\OtrosController::searchByDNI/$1');

//ruta para registrar_personal
$routes->get('/registrar_personal', 'Administrativo\Trabajadores\Registrar_PersonalController::index');

//ruta para vacaciones
$routes->get('/vacaciones', 'Administrativo\Trabajadores\VacacionesController::index');

//ruta para vigentes
$routes->get('/vigentes', 'Administrativo\Trabajadores\VigentesController::index');

//ruta para item
$routes->get('/item', 'Configuracion\ItemController::index');

//ruta para plantilla
$routes->get('/plantilla', 'Plantillas\PlantillaController::index');

//ruta para prueba
$routes->get('/prueba', 'Plantillas\PruebaController::index');

//ruta para resumen
$routes->get('/resumen', 'ResumenController::index');


//prueba
$routes->get('test-mail', 'TestMailController::index');

//rutas para dashboard
$routes->get('/dashboard', 'DashboardController::index');
