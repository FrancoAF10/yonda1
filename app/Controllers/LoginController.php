<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function validar()
    {
        $usuario = $this->request->getPost('usuario');
        $clave   = $this->request->getPost('clave');

        $userModel = new UsuarioModel();
        $user = $userModel->where('nombreusuario', $usuario)->first();

        if ($user && $user['claveacceso'] === $clave) {
            session()->setFlashdata('success', 'Bienvenido, ' . $user['nombreusuario']);
            return redirect()->to(base_url('dashboard'));
        }

        session()->setFlashdata('error', 'Usuario o contraseña incorrecta');
        return redirect()->to(base_url('/'));
    }

    // 🔹 Paso 1: Solicitar recuperación
    public function resetPassword()
    {
        $usuario = $this->request->getPost('usuario');
        $userModel = new UsuarioModel();
        $contacto = $userModel->getDatosContacto($usuario);

        if (!$contacto) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuario no encontrado'
            ]);
        }

        // Generar código aleatorio
        $codigo = rand(100000, 999999);

        // Guardar en sesión por 5 minutos
        session()->set('codigo_reset', $codigo);
        session()->set('usuario_reset', $usuario);
        session()->set('codigo_reset_expira', time() + (5 * 60)); // 5 minutos

        // Enviar email
        $email = \Config\Services::email();
        $email->setFrom('erickjhampier2024@gmail.com', 'Sistema Yonda & Grupo Huaraca');
        $email->setTo($contacto['email']); // campo real
        $email->setSubject('Recuperación de contraseña');
        $email->setMessage("<p>Tu código de recuperación es: <b>$codigo</b></p><p>Este código expirará en 5 minutos.</p>");

        if ($email->send()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Se envió un código a tu correo registrado'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se pudo enviar el correo'
            ]);
        }
    }

    // 🔹 Paso 2: Verificar código
    public function verificarCodigo()
    {
        $codigoIngresado = $this->request->getPost('codigo');
        $codigoGuardado  = session()->get('codigo_reset');
        $expira          = session()->get('codigo_reset_expira');

        if (!$codigoGuardado || time() > $expira) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'El código ha expirado. Solicita uno nuevo.'
            ]);
        }

        if ($codigoIngresado == $codigoGuardado) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Código válido'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Código incorrecto'
        ]);
    }

    // 🔹 Paso 3: Cambiar clave después de verificar código
    public function cambiarClave()
    {
        $codigoIngresado = $this->request->getPost('codigo');
        $nuevaClave      = $this->request->getPost('nueva_clave');
        $codigoGuardado  = session()->get('codigo_reset');
        $expira          = session()->get('codigo_reset_expira');
        $usuario         = session()->get('usuario_reset');

        if (!$codigoGuardado || time() > $expira) {
            session()->setFlashdata('error', 'El código ha expirado. Solicita uno nuevo.');
            return redirect()->to(base_url('/'));
        }

        if ($codigoIngresado != $codigoGuardado) {
            session()->setFlashdata('error', 'Código incorrecto');
            return redirect()->to(base_url('/'));
        }

        // Actualizar clave en la BD
        $userModel = new UsuarioModel();
        $user = $userModel->where('nombreusuario', $usuario)->first();

        if ($user) {
            $userModel->update($user['idusuario'], [
                'claveacceso' => $nuevaClave // 🔒 si quieres, aplica hash aquí
            ]);

            // Limpiar sesión temporal
            session()->remove('codigo_reset');
            session()->remove('usuario_reset');
            session()->remove('codigo_reset_expira');

            session()->setFlashdata('success', 'Contraseña actualizada correctamente');
            return redirect()->to(base_url('/'));
        }

        session()->setFlashdata('error', 'No se pudo actualizar la contraseña');
        return redirect()->to(base_url('/'));
    }
}
