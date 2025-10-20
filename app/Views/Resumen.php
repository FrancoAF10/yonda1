<?= $header ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="pc-container">

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <!-- Tarjeta del colaborador -->
            <div class="col-md-3">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                      src="https://randomuser.me/api/portraits/women/44.jpg" alt="Foto del perfil de usuario">
                  </div>
                  <h3 class="profile-username text-center">Elsa Marisol Albuquerque Reyes</h3>
                  <p class="text-muted text-center">Auxiliar de cajas</p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Identificación</b> <a class="float-end">45450226</a></li>
                    <li class="list-group-item"><b>Correo Corporativo</b> <a
                        class="float-end text-truncate">carla.sebastiani@gmail.com</a></li>
                    <li class="list-group-item"><b>Cumpleaños</b> <a class="float-end">04-05-2021 (2 años)</a></li>
                    <li class="list-group-item"><b>Sexo</b> <a class="float-end">Femenino</a></li>
                    <li class="list-group-item"><b>Tipo de Contrato</b> <a class="float-end">Contrato a plazo indeterminado</a></li>
                    <li class="list-group-item"><b>Jornada Laboral</b> <a class="float-end">Mensual (48h) L-M-J-S</a></li>
                    <li class="list-group-item"><b>Saldo de Vacaciones</b> <a class="float-end">28 días</a></li>
                  </ul>

                  <a href="#" class="btn btn-primary btn-block"><b>Ficha: F1</b> <i class="bi bi-pencil"></i></a>
                </div>
              </div>
            </div>

            <!-- Contenido de pestañas -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="resumen-tab" data-bs-toggle="pill" href="#resumen">Resumen</a></li>
                    <li class="nav-item"><a class="nav-link" id="boletas-tab" data-bs-toggle="pill" href="#boletas">Boletas de Pago</a></li>
                    <li class="nav-item"><a class="nav-link" id="documentos-tab" data-bs-toggle="pill" href="#documentos">Documentos</a></li>
                    <li class="nav-item"><a class="nav-link" id="historia-tab" data-bs-toggle="pill" href="#historia">Historia</a></li>
                    <li class="nav-item"><a class="nav-link" id="asistencia-tab" data-bs-toggle="pill" href="#asistencia">Asistencia</a></li>
                    <li class="nav-item"><a class="nav-link" id="vacaciones-tab" data-bs-toggle="pill" href="#vacaciones">Vacaciones</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <div class="tab-content" id="myTabContent">

                    <!-- RESUMEN -->
                    <div class="tab-pane fade show active" id="resumen">
                      <div class="row">
                        <div class="col-md-7">
                          <p><strong>Cargo:</strong> Auxiliar de cajas</p>
                          <p><strong>Área:</strong> Ventas (Sucursal)</p>
                          <p><strong>Empresa:</strong> Yonda Perú</p>
                          <p><strong>Sueldo Base:</strong> S/. 3000.0</p>
                          <p><strong>Tipo Contrato:</strong> Contrato a Plazo</p>
                          <p><strong>Inicio Contrato Vigente:</strong> 04/09/2025</p>
                          <p><strong>Fin de Contrato Vigente:</strong> 12/12/2025</p>
                          <p><strong>Vigencia restante:</strong> 8 días</p>
                        </div>
                        <div class="col-md-5 text-end">
                          <div class="mb-3">
                            <button class="btn btn-danger">Terminar trabajo</button>
                            <button class="btn btn-primary">Nuevo Trabajo</button>
                          </div>
                          <p>Días no trabajados (gráfico aquí)</p>
                          <p>Horas extras (gráfico aquí)</p>
                        </div>
                      </div>
                    </div>

                    <!-- BOLETAS DE PAGO -->
                    <div class="tab-pane fade" id="boletas">
                      <div class="table-responsive">
                        <table id="tablaBoletas" class="table table-striped table-bordered w-100">
                          <thead class="table-dark">
                            <tr>
                              <th>Mes</th>
                              <th>Sueldo Bruto</th>
                              <th>Sueldo Neto</th>
                              <th>Aporte Empleador</th>
                              <th>Horas Extras</th>
                              <th>Recargos</th>
                              <th>Horas no Trabajadas</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr><td><a href="#">09-2023</a></td><td>S/ 3,000.00</td><td>S/ 2,561.68</td><td>S/ 270.00</td><td>0.0 hrs</td><td>0.0 hrs</td><td>0.0 hrs</td></tr>
                            <tr><td><a href="#">08-2023</a></td><td>S/ 3,000.00</td><td>S/ 2,561.68</td><td>S/ 270.00</td><td>3.0 hrs</td><td>0.0 hrs</td><td>0.0 hrs</td></tr>
                            <tr><td><a href="#">07-2023</a></td><td>S/ 6,068.35</td><td>S/ 5,630.03</td><td>S/ 270.00</td><td>0.0 hrs</td><td>0.0 hrs</td><td>0.0 hrs</td></tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- DOCUMENTOS -->
                    <div class="tab-pane fade" id="documentos">
                      <div class="row g-3">
                        <div class="col-md-3 col-6"><button class="btn btn-outline-primary w-100"><i class="bi bi-file-earmark-text me-2"></i> Boleta</button></div>
                        <div class="col-md-3 col-6"><button class="btn btn-outline-success w-100"><i class="bi bi-file-earmark-excel me-2"></i> Plame</button></div>
                        <div class="col-md-3 col-6"><button class="btn btn-outline-warning w-100"><i class="bi bi-people me-2"></i> T-Registro</button></div>
                        <div class="col-md-3 col-6"><button class="btn btn-outline-danger w-100"><i class="bi bi-bank me-2"></i> AFPnet</button></div>
                      </div>
                    </div>

                    <!-- HISTORIA (Línea de tiempo) -->
                    <div class="tab-pane fade" id="historia">
                      <div class="timeline position-relative">
                        <div class="timeline-item mb-4">
                          <span class="timeline-icon bg-success"><i class="bi bi-person-check-fill"></i></span>
                          <div class="timeline-content card border-success">
                            <div class="card-body">
                              <h5 class="text-success">Ingreso <small class="text-muted float-end">4 de mayo de 2022</small></h5>
                              <p class="mb-1"><strong>Cargo:</strong> Auxiliar de cajas</p>
                              <p class="mb-1"><strong>Sub-área:</strong> Comercial - Ventas - Sucursal</p>
                              <p class="mb-1"><strong>Empresa:</strong> Buk SAC</p>
                            </div>
                          </div>
                        </div>
                        <div class="timeline-item mb-4">
                          <span class="timeline-icon bg-danger"><i class="bi bi-box-arrow-right"></i></span>
                          <div class="timeline-content card border-danger">
                            <div class="card-body">
                              <h5 class="text-danger">Salida <small class="text-muted float-end">28 de febrero de 2022</small></h5>
                              <p class="mb-0"><strong>Causal:</strong> Despido Arbitrario</p>
                            </div>
                          </div>
                        </div>
                        <div class="timeline-item mb-4">
                          <span class="timeline-icon bg-primary"><i class="bi bi-pencil-square"></i></span>
                          <div class="timeline-content card border-primary">
                            <div class="card-body">
                              <h5 class="text-primary">Modificación <small class="text-muted float-end">1 de septiembre de 2020</small></h5>
                              <p class="mb-1">Registro sin modificaciones</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- ASISTENCIA -->
                    <div class="tab-pane fade" id="asistencia">
                      <h5 class="mt-4">Detalle Diario</h5>
                      <div class="table-responsive">
                        <table id="tablaAsistencia" class="table table-striped table-bordered w-100">
                          <thead class="table-dark">
                            <tr><th>Fecha</th><th>Estado</th><th>Tipo</th><th>Comentario</th><th>Horas</th><th>Documento</th></tr>
                          </thead>
                          <tbody>
                            <tr><td>01/08/2025</td><td><span class="badge bg-success">Asistencia</span></td><td>Normal</td><td>-</td><td>8 hrs</td><td>-</td></tr>
                            <tr><td>04/08/2025</td><td><span class="badge bg-warning text-dark">Tardanza</span></td><td>15 min</td><td>Tráfico</td><td>7.75 hrs</td><td>-</td></tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- VACACIONES -->
                    <div class="tab-pane fade" id="vacaciones">
                      <h4 class="mb-3">Historial de Vacaciones</h4>
                      <div class="table-responsive">
                        <table id="tablaVacaciones" class="table table-striped table-bordered w-100">
                          <thead class="table-dark">
                            <tr><th>Periodo</th><th>Días Asignados</th><th>Días Tomados</th><th>Días Disponibles</th><th>Último Uso</th></tr>
                          </thead>
                          <tbody>
                            <tr><td>2023 - 2024</td><td>30</td><td>12</td><td>18</td><td>15/06/2024</td></tr>
                            <tr><td>2022 - 2023</td><td>30</td><td>30</td><td>0</td><td>10/11/2023</td></tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div><!-- /.col-md-9 -->
          </div>
        </div>
      </div>
    </div>

    <?= $footer ?>
  </div>

  <!-- Script para inicializar DataTables -->
  <script>
    $(document).ready(function () {
      $('#tablaBoletas, #tablaAsistencia, #tablaVacaciones').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        }
      });
    });
  </script>

  <!-- Estilos para la línea de tiempo -->
  <style>
    .timeline {
      position: relative;
      margin-left: 40px;
      padding-left: 20px;
      border-left: 3px solid #dee2e6;
    }
    .timeline-item {
      position: relative;
    }
    .timeline-icon {
      position: absolute;
      left: -32px;
      top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      color: #fff;
    }
    .timeline-content {
      margin-left: 10px;
    }
  </style>
</body>
</html>
