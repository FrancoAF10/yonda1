<?= $header ?>
<div class="pc-container my-3">
  <div class="pc-content">
    <h2 class="DataPerson text-center mb-4"><i class="fa-solid fa-user"></i> Ficha del Trabajador</h2>
    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        <h4 class="mb-0">Datos Personales</h4>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-md-4">
            <p><b>NOMBRE:</b>
              <?= $trabajador['apepaterno'] . ' ' . $trabajador['apematerno'] . ' ' . $trabajador['nombres'] ?></p>
            <p><b>FECHA DE NACIMIENTO:</b> <?= $trabajador['fechanac'] ?></p>
            <p><b>GÉNERO:</b> <?= $trabajador['genero'] ?></p>
          </div>
          <div class="col-md-4">
            <p><b>TIPO DE DOCUMENTO:</b> <?= $trabajador['tipodoc'] ?></p>
            <p><b>N° DE DOCUMENTO:</b> <?= $trabajador['numdoc'] ?></p>
            <p><b>ESTADO CIVIL:</b> <?= $trabajador['estadocivil'] ?></p>
          </div>
          <div class="col-md-4">
            <p><b>DEPARTAMENTO:</b> <?= $trabajador['DepartamentoP'] ?></p>
            <p><b>PROVINCIA:</b> <?= $trabajador['ProvinciaP'] ?></p>
            <p><b>DISTRITO:</b> <?= $trabajador['DistritoP'] ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        <h4 class="mb-0">Datos de Contacto</h4>
      </div>
      <div class="card-body">
        <div class="DataContact" id="extra">
          <p><b>DIRECCIÓN:</b> <?= $trabajador['direccion'] ?></p>
          <p><b>REFERENCIA:</b> <?= $trabajador['referencia'] ?></p>
          <p><b>TELÉFONO:</b> <?= $trabajador['telefono'] ?></p>
          <p><b>EMAIL:</b> <?= $trabajador['email'] ?></p>
        </div>
      </div>
    </div>

    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        <h4 class="mb-0">Datos Laborales</h4>
      </div>
      <div class="card-body">
        <div class="DataLabor">
          <div class="row mb-2">
            <div class="col-md-4">
              <p><b>DEPARTAMENTO:</b> <?= $trabajador['DepartamentoS'] ?></p>
              <p><b>PROVINCIA:</b> <?= $trabajador['ProvinciaS'] ?></p>
              <p><b>DISTRITO:</b> <?= $trabajador['DistritoS'] ?></p>
            </div>
            <div class="col-md-4">
              <p><b>SUCURSAL:</b> <?= $trabajador['sucursal'] ?></p>
              <p><b>ÁREA:</b> <?= $trabajador['area'] ?? '---' ?></p>
              <p><b>CARGO:</b> <?= $trabajador['cargo'] ?? '---' ?></p>
              <p><b>SUELDO BASE:</b> <?= $trabajador['sueldobase'] ?? '---' ?></p>
            </div>
            <div class="col-md-4">
              <p><b>FECHA DE INICIO:</b> <?= $trabajador['fechainicio'] ?? '---' ?></p>
              <p><b>FECHA DE INICIO:</b> <?= $trabajador['fechafin'] ?? '---' ?></p>
              <p><b>TOLERANCIA DIARIA:</b> <?= $trabajador['toleranciadiaria'] ?? '---' ?></p>
              <p><b>TOLERANCIA MENSUAL:</b> <?= $trabajador['toleranciamensual'] ?? '---' ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $footer ?>