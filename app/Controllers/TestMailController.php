<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestMailController extends Controller
{
    public function index()
    {
        $email = \Config\Services::email();

        $email->setFrom('erickjhampier2024@gmail.com', 'Sistema de Asistencia');
        $email->setTo('perezsaraviaerickjheanpier@gmail.com'); // destinatario real para probar
        $email->setSubject('Prueba con TurboSMTP');
        $email->setMessage('<h2>¡Hola!</h2><p>Este es un correo de prueba desde CodeIgniter 4 usando TurboSMTP.</p>');

        if ($email->send()) {
            echo "✅ Correo enviado correctamente";
        } else {
            echo "❌ Error al enviar<br>";
            print_r($email->printDebugger(['headers']));
        }
    }
}
