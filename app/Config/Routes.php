<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta que contiene un / es la principal => www.miweb.com
$routes->get('/', 'Home::index');

//Las rutas que se acceden por GET son las que se utilizan como URL
//Cuando se tratan de POST son por FORMULARIO

//miweb.com/clientes
//$objeto->metodo()   Se utiliza cuando $objeto es una instancia de una clase
//Clase::metodo()     Se está utilizando un método sin instanciar la clase
$routes->get('/asistencia', 'AsistenciaController::index');


//personas
$routes->get('/personas', 'PersonasController::index');
$routes->get('/personas/registrar', 'PersonasController::select');
$routes->post('/personas/registrar', 'PersonasController::registrar');
$routes->post('/personas/provincias', 'PersonasController::provincias');
$routes->post('/personas/distritos', 'PersonasController::distritos');
$routes->post('/personas/sucursales', 'PersonasController::sucursales');
$routes->post('/personas/areas', 'PersonasController::areas');
$routes->post('/personas/cargos', 'PersonasController::cargos');

// Ruta para actualizar empleado
$routes->get('/personas/editar/(:num)', 'PersonasController::editar/$1');
$routes->post('/personas/actualizar', 'PersonasController::actualizar');


$routes->get('/personas/info/(:num)', 'PersonasController::info/$1');




