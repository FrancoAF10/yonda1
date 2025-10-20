<?= $header ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="pc-container">


    <!-- Contenedor principal -->
    <div class="content-body">
      <div class="container my-4">
        <h4 class="fw-bold mb-3">SOLICITUDES DE VACACIONES</h4>

        <!-- Datos de solicitud -->
        <div class="card shadow-sm mb-3">
          <div class="card-header bg-light fw-semibold">
            Datos de solicitud
          </div>
          <div class="card-body">
            <!-- Alerta -->
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong>¡Importante!</strong> Tomar en cuenta la nueva ley de
              vacaciones.
              <a href="#" class="fw-semibold" data-bs-toggle="modal" data-bs-target="#modalLeyVacaciones">Ver
                detalle</a>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <label for="fechaInicial" class="form-label">Fecha inicial</label>
                <input type="date" class="form-control" id="fechaInicial" value="2025-08-18" />
              </div>
              <div class="col-md-4">
                <label for="fechaFinal" class="form-label">Fecha final</label>
                <input type="date" class="form-control" id="fechaFinal" value="2025-08-25" />
              </div>
              <div class="col-md-4">
                <label for="diasDisponibles" class="form-label">Días disponibles</label>
                <input type="text" class="form-control text-center" id="diasDisponibles" value="73" readonly />
                <small><a href="#" data-bs-toggle="modal" data-bs-target="#modalDetalleDias">Detalle Aquí</a></small>
              </div>
            </div>

            <!-- Bloques -->
            <div class="mt-4">
              <label class="form-label d-block">Elegir bloque a consumir</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bloque" id="bloque1" checked />
                <label class="form-check-label" for="bloque1">
                  Bloque I
                  <small class="text-muted">(solicitud de 15, 8 o 7 días)</small>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bloque" id="bloque2" />
                <label class="form-check-label" for="bloque2">
                  Bloque II
                  <small class="text-muted">(solicitud mínima de 1 día)</small>
                </label>
              </div>
            </div>

            <!-- Número de días -->
            <div class="mt-3">
              <label class="form-label">Número de días:</label>
              <input type="text" class="form-control" id="numDias" readonly />
            </div>
          </div>
        </div>

        <!-- Modal para Detalle de Días -->
        <div class="modal fade" id="modalDetalleDias" tabindex="-1" aria-labelledby="modalDetalleDiasLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetalleDiasLabel">
                  Detalle de Días Disponibles
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                  aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h2>Detalle completo de tus días de vacaciones</h2>
                <table class="table table-striped">
                  <thead class="table-dark">
                    <tr>
                      <th>Periodo</th>
                      <th>Días disponibles</th>
                      <th>Días utilizados</th>
                      <th>Bloque I</th>
                      <th>Bloque II</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>08/2023 - 12/2023</td>
                      <td>12</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>
                    <tr>
                      <td>01/2024 - 12/2024</td>
                      <td>30</td>
                      <td>5</td>
                      <td>5</td>
                      <td>0</td>
                    </tr>
                    <tr>
                      <td>01/2025 - 12/2025</td>
                      <td>30</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Cerrar
                </button>
                <button type="button" class="btn btn-primary">Aceptar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal para Ley de Vacaciones -->
        <div class="modal fade" id="modalLeyVacaciones" tabindex="-1" aria-labelledby="modalLeyVacacionesLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLeyVacacionesLabel">
                  Reglamento del Decreto Legislativo N° 1405
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                  aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h1>Cambios en la ley de vacaciones</h4>
                  <p>
                    <strong>Artículo 8.- Fraccionamiento del descanso vacacional</strong> El
                    descanso vacacional de treinta (30) días calendario se puede
                    fraccionar de la siguiente manera:
                  <ul class="list-unstyled">
                    <li class="mb-2">
                      <strong>Primer bloque:</strong> Mínimo 15 días calendario que pueden disfrutarse:
                      <ul class="mt-1">
                        <li>De forma continua (15 días seguidos), o</li>
                        <li>Divididos en dos períodos:
                          <ul>
                            <li>Un período de al menos 7 días continuos</li>
                            <li>Un período de al menos 8 días continuos</li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li class="mb-2">
                      <strong>Segundo bloque:</strong> Los días restantes pueden disfrutarse en períodos mínimos de 1
                      día calendario.
                    </li>
                    <li>
                      <strong>Acuerdo entre partes:</strong> El orden de disfrute de los bloques puede ser acordado
                      entre empleador y trabajador.
                    </li>
                  </ul>
                  </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Entendido
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Motivo -->
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <label for="motivo" class="form-label">Motivo de solicitud:</label>
            <textarea class="form-control" id="motivo" rows="3" maxlength="200"
              placeholder="Cantidad máxima de caracteres: 200"></textarea>
            <div class="mt-3 d-flex gap-2">
              <button class="btn btn-primary">Guardar</button>
              <button class="btn btn-secondary">Nuevo</button>
            </div>
          </div>
        </div>

        <!-- Sección de solicitudes -->
        <div class="card shadow-sm">
          <div class="card-header bg-light fw-semibold">Solicitudes</div>
          <div class="card-body">
            <p class="text-muted">
              Aquí se mostrarán las solicitudes realizadas.
            </p>
          </div>
        </div>
      </div>
    </div>

    <?= $footer ?>

</body>

</html>