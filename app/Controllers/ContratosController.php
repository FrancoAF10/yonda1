<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Areas;
use App\Models\Cargos;
use App\Models\Contratos;
use App\Models\Departamentos;
use App\Models\Provincias;
use App\Models\Distritos;
use App\Models\Personas;
use App\Models\Sucursal;
class ContratosController extends BaseController
{
    public function index(){
        
      $contrato=new Contratos();
      $datos['contratosvencidos']=$contrato->Vista_Contratos_Vencidos();
      $datos['header'] = view("Layouts/header");
      $datos['footer'] = view("Layouts/footer");
      return view("Renovacion/renovacion", $datos);
    }
    public function crearcontrato($idpersona=null){
        $sucursal=new Sucursal();
        $datos['idpersona'] = $idpersona;
        $datos['sucursal']= $sucursal->orderBy('idsucursal','ASC')->findAll();
        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");
        return view("Contratos/registrar", $datos);
    }
    public function crearpersonal()
    {
        $contratos = new Contratos();
        // Recolectar datos del formulario
        $idpersona = $this->request->getPost('idpersona');
        $idcargo          = $this->request->getPost('idcargo');
        $fechainicio      = $this->request->getPost('fechainicio');
        $fechafin         = $this->request->getPost('fechafin');
        $sueldobase       = $this->request->getPost('sueldobase');
        $toleranciadiaria = $this->request->getPost('toleranciadiaria');
        $toleranciamensual= $this->request->getPost('toleranciamensual');

        //  Validar fechas
        if (strtotime($fechafin) < strtotime($fechainicio)) {
            return redirect()->back()->withInput()->with('error', 'La fecha de fin no puede ser anterior a la fecha de inicio.');
        }

        //  Validar números positivos
        $validaciones = [
            'Sueldo' => $sueldobase,
            'Tolerancia Diaria' => $toleranciadiaria,
            'Tolerancia Mensual' => $toleranciamensual,
        ];

        foreach ($validaciones as $campo => $valor) {
            if (!is_numeric($valor)) {
                return redirect()->back()->withInput()->with('error', "El $campo debe ser un número válido");
            }
            if ($valor < 0) {
                return redirect()->back()->withInput()->with('error', "El $campo no puede ser negativo");
            }
        }

        //  Preparar datos para insertar
        $data = [
            'idcargo'          => $idcargo,
            'fechainicio'      => $fechainicio,
            'fechafin'         => $fechafin,
            'sueldobase'       => $sueldobase,
            'toleranciadiaria' => $toleranciadiaria,
            'toleranciamensual'=> $toleranciamensual,
            'idpersona'        => $idpersona
        ];

        // Insertar contrato en BD
        $contratos->insert($data);

        return redirect()->to(base_url("personas"))->with('success', 'Contrato registrado correctamente');
    }


    //VISTA
    public function nuevoContrato($idpersona=null){
        $personas    = new Personas();
        $contratos   = new Contratos();
        $departamento= new Departamentos();
        $provincias  = new Provincias();
        $distritos   = new Distritos();
        $sucursales  = new Sucursal();
        $areas       = new Areas();
        $cargos      = new Cargos();

        // Datos de la persona
        $persona = $personas->find($idpersona);
        $datos['persona'] = $persona;

        // Para el primer select de departamento siempre
        $datos['departamentoSucursales'] = $departamento->orderBy('iddepartamento','ASC')->findAll();
        $datos['vencidos'] = $contratos->getHistorialContratos($idpersona);

        // Inicializamos variables para que la vista no reviente
        $datos['iddepartamento']    = null;
        $datos['idprovincia']       = null;
        $datos['iddistrito']        = null;
        $datos['idsucursal']        = null;
        $datos['idarea']            = null;
        $datos['idcargo']           = null;
        $datos['fechainicio']       = null;
        $datos['fechafin']          = null;
        $datos['sueldobase']        = null;
        $datos['toleranciadiaria']  = null;
        $datos['toleranciamensual'] = null;

        // También listas vacías para los selects dependientes
        $datos['provincias'] = [];
        $datos['distritos']  = [];
        $datos['sucursales'] = [];
        $datos['areas']      = [];
        $datos['cargos']     = [];

        // Buscar el último contrato de la persona
        $ultimoContrato = $contratos->where('idpersona', $idpersona)
                                    ->orderBy('idcontrato','DESC')
                                    ->first();

        if ($ultimoContrato) {
            // Guardamos los IDs para marcar el selected en la vista
            $datos['idcargo'] = $ultimoContrato['idcargo'];

            $datos['fechainicio']       = $ultimoContrato['fechainicio'];
            $datos['fechafin']          = $ultimoContrato['fechafin'];
            $datos['sueldobase']        = $ultimoContrato['sueldobase'];
            $datos['toleranciadiaria']  = $ultimoContrato['toleranciadiaria'];
            $datos['toleranciamensual'] = $ultimoContrato['toleranciamensual'];

            $cargo = $cargos->find($ultimoContrato['idcargo']);
            if ($cargo) {
                $datos['idarea'] = $cargo['idarea'];

                $area = $areas->find($cargo['idarea']);
                if ($area) {
                    $datos['idsucursal'] = $area['idsucursal'];

                    $sucursal = $sucursales->find($area['idsucursal']);
                    if ($sucursal) {
                        $datos['iddistrito'] = $sucursal['iddistrito'];

                        $distrito = $distritos->find($sucursal['iddistrito']);
                        if ($distrito) {
                            $datos['idprovincia'] = $distrito['idprovincia'];

                            $provincia = $provincias->find($distrito['idprovincia']);
                            if ($provincia) {
                                $datos['iddepartamento'] = $provincia['iddepartamento'];
                            }
                        }
                    }
                }
            }

            // Llenamos las listas dependientes para precargar en la vista
            if ($datos['iddepartamento']) {
                $datos['provincias'] = $provincias->where('iddepartamento', $datos['iddepartamento'])->findAll();
            }
            if ($datos['idprovincia']) {
                $datos['distritos']  = $distritos->where('idprovincia', $datos['idprovincia'])->findAll();
            }
            if ($datos['iddistrito']) {
                $datos['sucursales'] = $sucursales->where('iddistrito', $datos['iddistrito'])->findAll();
            }
            if ($datos['idsucursal']) {
                $datos['areas']      = $areas->where('idsucursal', $datos['idsucursal'])->findAll();
            }
            if ($datos['idarea']) {
                $datos['cargos']     = $cargos->where('idarea', $datos['idarea'])->findAll();
            }
        }

        $datos['header'] = view("Layouts/header");
        $datos['footer'] = view("Layouts/footer");
        return view("Renovacion/Nuevocontrato", $datos);
    }

    //RENOVACION
    public function renovacion()
    {
        $contratos = new Contratos();

        $fechainicio      = $this->request->getPost('fechainicio');
        $fechafin         = $this->request->getPost('fechafin');
        $sueldobase       = $this->request->getPost('sueldobase');
        $toleranciadiaria = $this->request->getPost('toleranciadiaria');
        $toleranciamensual= $this->request->getPost('toleranciamensual');
        $idpersona        = $this->request->getPost('idpersona');
        $idcargo          = $this->request->getPost('idcargo');

        // Validar fechas
        if (strtotime($fechafin) < strtotime($fechainicio)) {
            return redirect()->back()->withInput()
                ->with('error', 'La fecha de fin no puede ser anterior a la fecha de inicio del contrato.');
        }

        // Validar números positivos
        $validaciones = [
            'Sueldo' => $sueldobase,
            'Tolerancia Diaria' => $toleranciadiaria,
            'Tolerancia Mensual' => $toleranciamensual,
        ];

        foreach ($validaciones as $campo => $valor) {
            if (!is_numeric($valor)) {
                return redirect()->back()->withInput()->with('error', "El $campo debe ser un número válido");
            }
            if ($valor < 0) {
                return redirect()->back()->withInput()->with('error', "El $campo no puede ser negativo");
            }
        }

        // Preparar datos para nuevo contrato
        $data = [
            'fechainicio'      => $fechainicio,
            'fechafin'         => $fechafin,
            'sueldobase'       => $sueldobase,
            'toleranciadiaria' => $toleranciadiaria,
            'toleranciamensual'=> $toleranciamensual,
            'idpersona'        => $idpersona,
            'idcargo'          => $idcargo,
        ];

        // Validar que no exista un contrato duplicado en esas fechas
        $existe = $contratos->where('idpersona', $idpersona)
                            ->where('fechainicio', $fechainicio)
                            ->where('fechafin', $fechafin)
                            ->first();

        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Ya existe un contrato con esas fechas para esta persona.');
        }

        // Insertar como nuevo contrato (no modificar el anterior)
        $contratos->insert($data);

        return redirect()->to(base_url('Renovacion/ContratosVencidos'));
    }

}