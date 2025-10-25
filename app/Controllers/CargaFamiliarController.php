<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CargaFamiliar;
use App\Models\Personas;

/**
 * Controlador CargaFamiliarController
 * 
 * Gestiona las operaciones relacionadas con la carga familiar de los empleados,
 * incluyendo registro de dependientes y búsqueda de personas por DNI.
 * 
 * @package App\Controllers
 */
class CargaFamiliarController extends BaseController
{
    /**
     * Registra un nuevo dependiente en la carga familiar de un empleado
     * 
     * Valida y procesa el formulario de registro de carga familiar,
     * incluyendo la carga opcional de un archivo de evidencia (imagen o PDF).
     * Retorna la lista actualizada de carga familiar en formato JSON.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
     */
    public function crear()
    {
        $cargafamiliar = new CargaFamiliar();
        $idpersona = $this->request->getVar('idpersona');

        $validacion = $this->validate([
            'evidencia' => [
                'mime_in[evidencia,image/jpg,image/jpeg,image/png,application/pdf]',
                'max_size[evidencia,2048]'
            ]
        ]);

        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Revise la información');
            return redirect()->back()->withInput();
        }

        // Manejo del archivo (opcional)
        $archivo = $this->request->getFile('evidencia');
        $nombreArchivo = null; // Por defecto null
        if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
            $nombreArchivo = $archivo->getRandomName();
            $archivo->move('../public/uploads/', $nombreArchivo);
        }

        // Preparar datos para insertar
        $data = [
            "parentesco" => $this->request->getVar('parentesco'),
            "evidencia" => $nombreArchivo,
            "idpersona" => $idpersona,
            "idhijo" => $this->request->getVar('idhijo')
        ];

        $cargafamiliar->insert($data);

        $asigfamiliar = $cargafamiliar->getcargafamiliar($idpersona);

        return $this->response->setJSON(['status' => 'ok', 'cargafamiliar' => $asigfamiliar]);
    }
  /**
   * Busca una persona por su número de documento
   * 
   * Realiza una búsqueda en la base de datos de personas utilizando
   * el número de documento como criterio. Útil para autocompletar formularios
   * o validar la existencia de dependientes antes de registrarlos.
   * 
   * @param mixed $numdoc Número de documento a buscar
   * @return \CodeIgniter\HTTP\ResponseInterface
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
}
