<?php
namespace App\Controllers;



    class IniciarSesionController extends BaseController {
        public function iniciarSesion(){

            $datos['header'] = view("Layouts/header");
            $datos['footer'] = view("Layouts/footer");
            return view("iniciarsesion", $datos);
        }

    }