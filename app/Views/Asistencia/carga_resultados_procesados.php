 <?= $header ?>
<div class="pc-container mt-4">
  <div class="pc-content">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h4 class="mb-3 text-primary">Resultado del procesamiento</h4>

        <!-- Mensaje de éxito -->
        <div class="alert alert-success">
          <i class="bi bi-check-circle-fill"></i>
          <strong><?= esc($insertados) ?></strong> registros insertados correctamente.
        </div>

        <?php
        // Agrupamos los errores con títulos claros
        $gruposErrores = [
          'Trabajadores no encontrados en la base de datos' => $erroresNoExiste ?? [],
          'Contrato inexistente o no vigente' => array_merge($erroresContrato ?? [], $erroresFechaContrato ?? []),
          'Registros con fecha futura' => $erroresFechaFutura ?? [],
          'Registros duplicados' => $erroresDuplicado ?? [],
        ];
        ?>

        <?php 
        $hayErrores = false;
        foreach ($gruposErrores as $lista) {
          if (!empty($lista)) { $hayErrores = true; break; }
        }
        ?>

        <?php if ($hayErrores): ?>
          <?php foreach ($gruposErrores as $titulo => $lista): ?>
            <?php if (!empty($lista)): ?>
              <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <strong><?= count($lista) ?></strong> registros con error: <?= esc($titulo) ?>
              </div>

              <div class="table-responsive mb-4">
                <table class="table table-sm table-bordered align-middle">
                  <thead class="table-warning text-center">
                    <tr>
                      <th>DNI</th>
                      <th>Nombre</th>
                      <th>Fecha Asistencia</th>
                      <th>Motivo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($lista as $e): ?>
                      <tr>
                        <td><?= esc($e['dni']) ?></td>
                        <td><?= esc($e['nombre']) ?></td>
                        <td><?= esc($e['fecha_asistencia'] ?? '') ?></td>
                        <td><?= esc($e['motivo']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>

          <!-- Botón para descargar los errores -->
          <form method="post" action="<?= base_url('carga-asistencia-procesada/descargar-errores') ?>">
  <button type="submit" class="btn btn-warning mt-3">
    <i class="bi bi-file-earmark-excel-fill"></i> Descargar errores en Excel
  </button>
</form>

        <?php else: ?>
          <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i> No se encontraron errores en el procesamiento.
          </div>
        <?php endif; ?>

        <div class="mt-4">
          <a href="<?= base_url('carga-asistencia-procesada') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
<?= $footer ?>