<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Personas;
use App\Models\Departamentos;
use App\Models\Provincias;
use App\Models\Distritos;
use App\Models\Sucursal;
use App\Models\Contratos;
use App\Models\Areas;
use App\Models\Cargos;


class PersonasController extends BaseController {



  public function index(){
      $personas=new Personas();
      $datos['listarpersonas']=$personas->Vista_Empleados();
      $datos['header'] = view("Layouts/header");
      $datos['footer'] = view("Layouts/footer");
      return view("personas/index", $datos);
  }

  public function registrar(){
    $personas=new Personas();
    $data=[
      'apepaterno'=>$this->request->getPost('apepaterno'),
      'apematerno'=>$this->request->getPost('apematerno'),
      'nombres'=>$this->request->getPost('nombres'),
      'fechanac'=>$this->request->getPost('fechanac'),
      'genero'=>$this->request->getPost('genero'),
      'estadocivil'=>$this->request->getPost('estadocivil'),
      'tipodoc'=>$this->request->getPost('tipodoc'),
      'numdoc'=>$this->request->getPost('numdoc'),
      'direccion'=>$this->request->getPost('direccion'),
      'referencia'=>$this->request->getPost('referencia'),
      'telefono'=>$this->request->getPost('telefono'),
      'email'=>$this->request->getPost('email'),
      'iddistrito'=>$this->request->getPost('iddistrito'),
      'idsucursal'=>$this->request->getPost('idsucursal'),
      'idarea'=>$this->request->getPost('idarea'),
      'idcargo'=>$this->request->getPost('idcargo'),
      'fechainicio'=>$this->request->getPost('fechainicio'),
      'fechafin'=>$this->request->getPost('fechafin'),
      'sueldobase'=>$this->request->getPost('sueldobase'),
      'toleranciadiaria'=>$this->request->getPost('toleranciadiaria'),
      'toleranciamensual'=>$this->request->getPost('toleranciamensual')
    ];
    $personas->RegistrarEmpleado($data);
    return redirect()->to(base_url("personas"))->with( 'mensaje','Registrado');
        
  }

  public function select()
  {
    $departamentos = new Departamentos();
    $areas = new Areas();

    $datos['departamentos'] = $departamentos->orderBy('iddepartamento', "ASC")->findAll();
    $datos['areas'] = $areas->orderBy('idarea', "ASC")->findAll();

    $datos['header'] = view('Layouts/header');
    $datos['footer'] = view('Layouts/footer');
    //index es el nombre del archivo que está en al carpeta views
    return view('Personas/registrar',    $datos);
  }

  public function provincias(){
    $provincias=new Provincias();
    $json= $this->request->getJSON();
    log_message('debug', 'JSON recibido: '.json_encode($json));

    $iddepartamento=$json->iddepartamento ?? null;

    if(!$iddepartamento){return $this->response->setJSON([]);}

    $data=$provincias
      ->where('iddepartamento',$iddepartamento)
      ->orderBy('provincia','ASC')
      ->findAll();
      return $this->response->setJSON($data);
  }
    
  public function distritos(){
    $distritos=new Distritos();
    $json=$this->request->getJSON();
    $idprovincia=$json->idprovincia ?? null;

    if(!$idprovincia){
      return $this->response->setJSON([]);
    }

    $data=$distritos->where('idprovincia',$idprovincia)
    ->orderBy('distrito','ASC')
    ->findAll();

    return $this->response->setJSON($data);
  }
  public function sucursales()
  {
      $sucursales = new Sucursal();
      $json = $this->request->getJSON();
      $iddistrito = $json->iddistrito ?? null;

      if (!$iddistrito) {
          return $this->response->setJSON([]);
      }

      $data = $sucursales->where('iddistrito', $iddistrito)
                        ->orderBy('sucursal', 'ASC')
                        ->findAll();


      return $this->response->setJSON($data);
  }

  public function areas()
  {
      $areas = new Areas();
      $json = $this->request->getJSON();
      $idsucursal = $json->idsucursal ?? null;

      if (!$idsucursal) {
          return $this->response->setJSON([]);
      }

      $data = $areas->where('idsucursal', $idsucursal)
                    ->orderBy('area', 'ASC')
                    ->findAll();
      return $this->response->setJSON($data);
  }

  public function cargos()
  {
    $cargo = new Cargos();
    $json  = $this->request->getJSON();
    $idarea = $json->idarea ?? null;

    if (!$idarea) {
      return $this->response->setJSON([]);
    }

    $data = $cargo->where('idarea', $idarea)
            ->orderBy('cargo', 'ASC')
            ->findAll();
    return $this->response->setJSON($data);
  }   

  public function editar($idpersona = null)
    {
    $personas = new Personas();
    $departamentos= new Departamentos();
    $provincias = new Provincias();
    $distritos = new Distritos();
    $sucursales = new Sucursal();
    $areas    = new Areas();
    $cargos= new Cargos();
    $contratos= new Contratos();
      
    $datos['personas'] = $personas->find($idpersona);

    $datos['contrato']=$contratos->where('idpersona',$idpersona)->first();
    //DATOS PERSONALES
    $datosDistrito=$distritos->find($datos['personas']['iddistrito']);
    $idprovinciaP=$datosDistrito['idprovincia'];

    $datosProvincia=$provincias->find($idprovinciaP);
    $iddepartamentoP=$datosProvincia['iddepartamento'];

    $datos['iddepartamentoP']=$iddepartamentoP;
    $datos['idprovinciaP']=$idprovinciaP;


    $datos['departamentosP'] = $departamentos->findAll();
    
    $datos['provinciasP']=$provincias
                          ->where('iddepartamento',$iddepartamentoP)
                          ->findAll();
    $datos['distritosP']=$distritos
                        ->where('idprovincia',$idprovinciaP)
                        ->findAll();

      if($datos['contrato']){
        $cargo=$cargos->find($datos['contrato']['idcargo']);
        $idarea=$cargo['idarea'];

        $area=$areas->find($idarea);
        $idsucursal=$area['idsucursal'];

        $sucursal=$sucursales->find($idsucursal);
        $iddistritoC=$sucursal['iddistrito'];

        $provinciaC=$provincias->find($distritos->find($iddistritoC)['idprovincia']);
        $iddepartamentoC=$provinciaC['iddepartamento'];

        $datos['idcargoC']=$cargo['idcargo'];
        $datos['idareaC']=$idarea;
        $datos['idsucursalC']=$idsucursal;
        $datos['iddistritoC']=$iddistritoC;
        $datos['idprovinciaC']=$provinciaC['idprovincia'];
        $datos['iddepartamentoC']=$iddepartamentoC;
        
        $datos['areasC']=$areas->where('idsucursal',$idsucursal)->findAll();
        $datos['cargosC']=$cargos->where('idarea',$idarea)->findAll();
        $datos['sucursalesC']=$sucursales->where('iddistrito',$iddistritoC)->findAll();
        $datos['provinciasC']=$provincias->where('iddepartamento',$iddepartamentoC)->findAll();
        $datos['distritosC']=$distritos->where('idprovincia',$provinciaC['idprovincia'])->findAll();
        $datos['departamentosC']=$departamentos->findAll();

      }


    $datos['header'] = view("Layouts/header");
    $datos['footer'] = view("Layouts/footer");
    return view("personas/editar", $datos);
  }
  public function actualizar()
  {
      $personas = new Personas();
      $contratos = new Contratos();

      // Recibir datos personales
      $idpersona = $this->request->getPost('idpersona');
      $datosPersona = [
          'apepaterno'   => $this->request->getPost('apepaterno'),
          'apematerno'   => $this->request->getPost('apematerno'),
          'nombres'      => $this->request->getPost('nombres'),
          'fechanac'     => $this->request->getPost('fechanac'),
          'genero'       => $this->request->getPost('genero'),
          'estadocivil'  => $this->request->getPost('estadocivil'),
          'tipodoc'      => $this->request->getPost('tipodoc'),
          'numdoc'       => $this->request->getPost('numdoc'),
          'direccion'    => $this->request->getPost('direccion'),
          'referencia'   => $this->request->getPost('referencia'),
          'telefono'     => $this->request->getPost('telefono'),
          'email'        => $this->request->getPost('email'),
          'iddistrito'   => $this->request->getPost('iddistrito')
      ];

      // Actualizar persona
      $personas->update($idpersona, $datosPersona);

      // Recibir datos de contrato
      $datosContrato = [
          'idsucursal'        => $this->request->getPost('idsucursal'),
          'idarea'            => $this->request->getPost('idarea'),
          'idcargo'           => $this->request->getPost('idcargo'),
          'fechainicio'       => $this->request->getPost('fechainicio'),
          'fechafin'          => $this->request->getPost('fechafin'),
          'sueldobase'        => $this->request->getPost('sueldobase'),
          'toleranciadiaria'  => $this->request->getPost('toleranciadiaria'),
          'toleranciamensual' => $this->request->getPost('toleranciamensual')
      ];

      // Actualizar contrato (suponiendo que siempre existe un contrato)
      $contratoExistente = $contratos->where('idpersona', $idpersona)->first();

      if ($contratoExistente) {
          $contratos->update($contratoExistente['idcontrato'], $datosContrato);
      } else {
          // Si no existiera contrato, se podría crear uno nuevo
          $datosContrato['idpersona'] = $idpersona;
          $contratos->insert($datosContrato);
      }

      return redirect()->to(base_url('personas'))->with('mensaje', 'Datos actualizados correctamente');
  }

  public function info($idpersona)
  {
      $personas = new Personas();
      $datos['trabajador'] = $personas->Vista_Info($idpersona);

      $datos['header'] = view("Layouts/header");
      $datos['footer'] = view("Layouts/footer");
      return view("personas/info", $datos);
  }

}   