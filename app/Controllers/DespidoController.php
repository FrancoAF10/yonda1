<?php
namespace App\Controllers;
use App\Models\Personas;
use App\Models\Contratos;
use App\Models\Terminacionescontrato;

class DespidoController extends BaseController
{
    // Entrar con idcontrato en la ruta
    public function indexDespido($idcontrato)
    {
        $contratos = new Contratos();
        $personas  = new Personas();

        // 1. Buscar contrato


        $contrato = $contratos->find($idcontrato);

        if (!$contrato) {
            return redirect()->to(base_url('contratos'))
                ->with('error', 'No se encontró el contrato.');
        }

        $trabajador = $personas->Vista_Info($contrato['idpersona']);


        if (!$trabajador) {
            return redirect()->to(base_url('personas'))
                ->with('error', 'No se encontró el trabajador.');
        }

        // 3. Pasar datos a la vista
        $datos = [
            'trabajador' => $trabajador,
            'contrato'   => $contrato,
            'header'     => view("Layouts/header"),
            'footer'     => view("Layouts/footer"),
        ];

        return view("personas/borrar", $datos);
    }       

    public function registrarDespido()
    {
        $terminacionescontrato = new Terminacionescontrato();

        $data = [
            'motivo'      => $this->request->getPost('motivo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'gravedad'    => $this->request->getPost('gravedad'),
            'evidencia'   => $this->request->getPost('evidencia'), // 👈 si subes archivo hay que ajustarlo
            'idcontrato'  => $this->request->getPost('idcontrato')
        ];

        $terminacionescontrato->RegistrarDespido($data);

        return redirect()->to(base_url("personas"))
            ->with('success', 'Despido registrado correctamente.');
    }
}
