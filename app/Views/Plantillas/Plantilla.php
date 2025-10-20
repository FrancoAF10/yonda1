<?= $header ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="pc-container">


    <!-- Contenedor principal -->
    <div class="content-wrapper">
      <div class="container-fluid py-4">
        <div class="row">

          <!-- Columna izquierda: Exportadores -->
          <div class="col-md-8">
            <div class="card shadow-sm">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph me-2"></i>Exportadores</h5>
                <div class="input-group input-group-sm" style="width: 200px;">
                  <input type="text" class="form-control" placeholder="Buscar...">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Nombre</th>
                      <th>Tipo de Reporte</th>
                      <th>Usuario</th>
                      <th>Fecha de Creación</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Reporte variado</td>
                      <td><span class="badge bg-secondary">Desempeño</span></td>
                      <td>Laura Mendoza</td>
                      <td>28/08/2023 16:54</td>
                      <td class="text-center">
                        <i class="bi bi-download me-2 text-primary" role="button"></i>
                        <i class="bi bi-share-fill me-2 text-info" role="button"></i>
                        <i class="bi bi-three-dots" role="button"></i>
                      </td>
                    </tr>
                    <tr>
                      <td>Nuevo reporte de Nómina - Orex</td>
                      <td><span class="badge bg-primary">Nómina</span></td>
                      <td>Edwin Solano Rodríguez</td>
                      <td>24/08/2023 17:39</td>
                      <td class="text-center">
                        <i class="bi bi-download me-2 text-primary" role="button"></i>
                        <i class="bi bi-share-fill me-2 text-info" role="button"></i>
                        <i class="bi bi-three-dots" role="button"></i>
                      </td>
                    </tr>
                    <tr>
                      <td>Provisiones Call South</td>
                      <td><span class="badge bg-primary">Nómina</span></td>
                      <td>Rosario Marv Salas Chimbo</td>
                      <td>24/08/2023 13:13</td>
                      <td class="text-center">
                        <i class="bi bi-download me-2 text-primary" role="button"></i>
                        <i class="bi bi-share-fill me-2 text-info" role="button"></i>
                        <i class="bi bi-three-dots" role="button"></i>
                      </td>
                    </tr>
                    <tr>
                      <td>Nuevo reporte de Nómina - Gildemeister</td>
                      <td><span class="badge bg-primary">Nómina</span></td>
                      <td>Edwin Solano Rodríguez</td>
                      <td>24/08/2023 10:31</td>
                      <td class="text-center">
                        <i class="bi bi-download me-2 text-primary" role="button"></i>
                        <i class="bi bi-share-fill me-2 text-info" role="button"></i>
                        <i class="bi bi-three-dots" role="button"></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Columna derecha: Plantillas -->
          <div class="col-md-4">
            <div class="card shadow-sm">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-layout-text-sidebar-reverse me-2"></i>Plantillas</h5>
              </div>
              <div class="card-body d-grid gap-2">
                <button class="btn btn-outline-primary w-100">Nómina</button>
                <button class="btn btn-outline-primary w-100">Nóminas de Pagos Parciales</button>
                <button class="btn btn-outline-primary w-100">Ausencia</button>
                <button class="btn btn-outline-primary w-100">Vacaciones</button>
                <button class="btn btn-outline-primary w-100">Amonestaciones</button>
                <button class="btn btn-outline-primary w-100">Liquidaciones</button>
                <button class="btn btn-outline-primary w-100">Firma Documentos</button>
                <button class="btn btn-outline-primary w-100">Desempeño</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

   <?= $footer ?>
  </div>

</body>
</html>
