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
                  <h3 class="profile-username text-center"><?= $trabajador['apepaterno'] . ' ' . $trabajador['apematerno'] . ' ' . $trabajador['nombres'] ?></p></h3>
                  <p class="text-muted text-center"><?= $trabajador['cargo'] ?? '---' ?></p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Tipo Identificación</b> <a class="float-end"><?= $trabajador['tipodoc'] ?></a></li>
                    <li class="list-group-item"><b>N° Identificación</b> <a class="float-end"><?= $trabajador['numdoc'] ?></a></li>
                    <li class="list-group-item"><b>Telefono</b> <a class="float-end"><?= $trabajador['telefono'] ?></a></li>

                    <li class="list-group-item"><b>Correo Corporativo</b> <a class="float-end text-truncate"> <?= $trabajador['email'] ?></a></li>
                    <li class="list-group-item"><b>Cumpleaños</b> <a class="float-end"> <?= $trabajador['fechanac'] ?></a></li>
                    <li class="list-group-item"><b>Sexo</b> <a class="float-end"><?= $trabajador['genero'] ?></a></li>
                    <li class="list-group-item"><b>Estado Civil</b> <a class="float-end"><?= $trabajador['estadocivil'] ?></a></li>


                    <li class="list-group-item"><b>Departamento</b> <a class="float-end"><?= $trabajador['DepartamentoP'] ?></a></li>
                    <li class="list-group-item"><b>Provincia</b> <a class="float-end"><?= $trabajador['ProvinciaP'] ?></a></li>
                    <li class="list-group-item"><b>Distrito</b> <a class="float-end"><?= $trabajador['DistritoP'] ?></a></li>

                    <li class="list-group-item"><b>Dirección</b> <a class="float-end"><?= $trabajador['direccion'] ?></a></li>
                    <li class="list-group-item"><b>Referencia</b> <a class="float-end"><?= $trabajador['referencia'] ?></a></li>
                    
                    <!-- <li class="list-group-item"><b>Sexo</b> <a class="float-end"><?= $trabajador['genero'] ?></a></li> -->

                  </ul>

                  <a href="<?= base_url('personas/r1/' . $trabajador['idpersona']) ?>" class="btn btn-primary btn-block"><b>Ficha: F1</b> <i class="bi bi-pencil"></i></a>
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
                          <p><strong>Cargo:</strong> <?= $trabajador['cargo'] ?? '---' ?></p>
                          <p><strong>Área:</strong> <?= $trabajador['area'] ?? '---' ?></p>
                          <p><strong>Empresa:</strong> <?= $trabajador['sucursal'] ?></p>
                          <p><strong>Sueldo Base:</strong> <?= $trabajador['sueldobase'] ?? '---' ?></p>
                          <p><strong>Tipo Contrato:</strong> Contrato a Plazo (FALTA)</p>
                          <p><strong>Inicio Contrato Vigente:</strong> <?= $trabajador['fechainicio'] ?? '---' ?></p>
                          <p><strong>Fin de Contrato Vigente:</strong> <?= $trabajador['fechafin'] ?? '---' ?></p>
                          <p><strong>Vigencia restante:</strong> <?= $tiemporestante['dias_diferencia']?> </p>

                          <p><strong>Tipo de Contrato:</strong> Contrato a plazo indeterminado(FALTA) </p>
                          <p><strong>Jornada Laboral:</strong> Mensual (48h) L-M-J-S(FALTA) </p>
                          <p><strong>Saldo de Vacaciones:</strong> 28 días(FALTA) </p>

                        </div>
                        <div class="col-md-5 text-end">
                          <div class="mb-3">
                            <!-- <a href="<?= base_url('personas/borrar/' . $trabajador['idcontrato']) ?>" class="btn btn-danger">Terminar Trabajo   <i class="fa-solid fa-trash"></i></a> -->
                            <a href="<?= base_url('Renovacion/NuevoContrato/').$trabajador['idpersona'] ?>" class="btn btn-primary">Renovar Contrato    <i class="fa-solid fa-pen-to-square"></i></a>
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
                              <th>Mes(FALTA)</th>
                              <th>Sueldo Bruto(FALTA)</th>
                              <th>Sueldo Neto(FALTA)</th>
                              <th>Aporte Empleador(FALTA)</th>
                              <th>Horas Extras(FALTA)</th>
                              <th>Recargos(FALTA)</th>
                              <th>Horas no Trabajadas(FALTA)</th>
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
                      <b><p>Lista de contratos</p></b>

                    <div class="tab-pane fade" id="historia">
                      <div class="position-relative">
                        <div class="mb-4">
                          <span class="bg-success"></span>
                          <div class="card border-success">
                            <div class="card-body">
                              <h5 class="text-success"><?= $trabajador['estado'] ?? '---' ?> <small class="text-muted float-end"> <?= $trabajador['fechainicio'] ?? '---' ?></small></h5>
                              <p class="mb-1"><strong>Cargo:</strong> <?= $trabajador['cargo'] ?? '---' ?></p>
                              <p class="mb-1"><strong>Área:</strong> <?= $trabajador['area'] ?? '---' ?></p>
                              <p class="mb-1"><strong>Empresa:</strong> <?= $trabajador['sucursal'] ?></p>
                            </div>
                          </div>  
                        </div>

                        <div class="mb-4">
                          <span class="bg-danger"></span>
                          <div class="card border-danger">

                          <?php foreach($contratosVencido as $contratosVencidos): ?>

                            <div class="card-body">
                              <h5 class="text-success"><?= $contratosVencidos['estado'] ?? '---' ?> <small class="text-muted float-end"> <?= $contratosVencidos['fechainicio'] ?? '---' ?></small></h5>
                              <p class="mb-1"><strong>Cargo:</strong> <?= $contratosVencidos['cargo'] ?? '---' ?></p>
                              <p class="mb-1"><strong>Área:</strong> <?= $contratosVencidos['area'] ?? '---' ?></p>
                              <p class="mb-1"><strong>Empresa:</strong> <?= $contratosVencidos['sucursal'] ?></p>
                            </div>

                          <?php endforeach; ?>

                          </div>
                        </div>
                        <!-- <div class="timeline-item mb-4">
                          <span class="timeline-icon bg-primary"><i class="bi bi-pencil-square"></i></span>
                          <div class="timeline-content card border-primary">
                            <div class="card-body">
                              <h5 class="text-primary">Modificación <small class="text-muted float-end">1 de septiembre de 2020</small></h5>
                              <p class="mb-1">Registro sin modificaciones</p>
                            </div>
                          </div>
                        </div> -->
                      </div>
                    </div>


                    <!-- ASISTENCIA -->
                    <div class="tab-pane fade" id="asistencia">
                      <h5 class="mt-4">Detalle Diario</h5>
                      <div class="table-responsive">
                        <table id="tablaAsistencia" class="table table-striped table-bordered w-100">
                          <thead class="table-dark text-center">
                            <tr>
                              <th>Fecha</th>
                              <th>Entrada</th>
                              <th>Refrigerio</th>
                              <th>Fin de Refrigerio</th>
                              <th>Salida</th>
                            </tr>
                          </thead>
                          <tbody class="text-center">
                            <?php foreach($asistenciapersona as $asistencia): ?>
                            <tr>
                              <td><?= $asistencia['diamarcado'] ?></td>
                              <td><?= $asistencia['entrada'] ?></td>
                              <td><?= $asistencia['iniciorefrigerio'] ?></td>
                              <td><?= $asistencia['finrefrigerio'] ?></td>
                              <td><?= $asistencia['salida'] ?></td>
                            </tr>
                            <?php endforeach; ?>
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
  $(document).ready(function() {
    $('#tablaAsistencia').DataTable({
      order: [[0, 'desc']],
      language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
      createdRow: function(row, data) {

        function convertirMinutos(horaStr) {
          if (!horaStr) return null;
          const [h, m] = horaStr.split(':').map(Number);
          return h * 60 + m;
        }

        // Obtener valores de las columnas
        const entrada = convertirMinutos(data[1]);
        const inicioRef = convertirMinutos(data[2]);
        const finRef = convertirMinutos(data[3]);
        const salida = convertirMinutos(data[4]);

        const celdaEntrada = $('td', row).eq(1);
        const celdaInicioRef = $('td', row).eq(2);
        const celdaFinRef = $('td', row).eq(3);
        const celdaSalida = $('td', row).eq(4);

        // Límites de tiempo
        const limiteEntrada = 8 * 60;           // 08:00
        const minInicioRef = 12 * 60;           // 12:00
        const maxFinRef = 15 * 60;              // 15:00 (no después de las 3pm)
        const duracionEsperada = 90;            // 1h30min
        const limiteSalida = 18 * 60;           // 18:00

        // -------- ENTRADA --------
        if (entrada != null) {
          if (entrada > limiteEntrada) {
            celdaEntrada.css({"background-color": "#ffb3b3", "color": "#a80000", "font-weight": "bold"})
                        .text(data[1] + " (Tarde)");
          } else if (entrada < limiteEntrada) {
            celdaEntrada.css({"background-color": "#b3d9ff", "color": "#003366", "font-weight": "bold"})
                        .text(data[1] + " (Temprano)");
          } else {
            celdaEntrada.css({"background-color": "#b3ffb3", "color": "#006600", "font-weight": "bold"})
                        .text(data[1] + " (Puntual)");
          }
        }

        // -------- REFRIGERIO --------
        if (inicioRef != null && finRef != null) {
          const duracionRef = finRef - inicioRef;

          // Validar hora de inicio
          if (inicioRef < minInicioRef) {
            celdaInicioRef.css({"background-color": "#ffe6b3", "color": "#b36b00", "font-weight": "bold"})
                          .text(data[2] + " (Antes de hora)");
          }

          // Validar hora de fin y duración
          if (finRef > maxFinRef) {
            celdaFinRef.css({"background-color": "#ffcccc", "color": "#990000", "font-weight": "bold"})
                       .text(data[3] + " (Fuera de horario)");
          } else if (duracionRef > duracionEsperada) {
            celdaFinRef.css({"background-color": "#e6b3ff", "color": "#660066", "font-weight": "bold"})
                       .text(data[3] + " (Excedió tiempo)");
          } else if (duracionRef < duracionEsperada) {
            celdaFinRef.css({"background-color": "#fff2b3", "color": "#996600", "font-weight": "bold"})
                       .text(data[3] + " (Regresó antes)");
          } else {
            celdaFinRef.css({"background-color": "#b3ffb3", "color": "#006600", "font-weight": "bold"})
                       .text(data[3] + " (Correcto)");
          }
        }

        // -------- SALIDA --------
        if (salida != null) {
          if (salida < limiteSalida) {
            celdaSalida.css({"background-color": "#ffb3b3", "color": "#a80000", "font-weight": "bold"})
                       .text(data[4] + " (Salió antes)");
          } else {
            celdaSalida.css({"background-color": "#b3ffb3", "color": "#006600", "font-weight": "bold"})
                       .text(data[4] + " (Correcto)");
          }
        }
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
