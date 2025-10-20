<?= $header ?>
<div class="pc-container my-2">
    <div class="pc-content">

    <h2 class="mb-3">Tareo Mensual</h2>

    <form method="get" action="<?= base_url('tareo/tareo') ?>" class="row g-2 mb-4">
        <div class="col-md-3">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" value="<?= esc($anio) ?>">
        </div>
        <div class="col-md-3">
            <label>Mes</label>
            <input type="number" name="mes" min="1" max="12" class="form-control" value="<?= esc($mes) ?>">
        </div>
        <div class="col-md-3">
            <label>DNI (opcional)</label>
            <input type="text" name="dni" class="form-control" value="<?= esc($dni) ?>">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filtrar</button>
            <a href="<?= base_url('tareo/tareo') ?>" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <?php if (!empty($tareo)) : ?>
        <div class="mb-3">
            <a href="<?= base_url('tareo/exportarExcel?anio='.$anio.'&mes='.$mes.'&dni='.$dni) ?>" class="btn btn-success">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar Excel
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <?php foreach(array_keys($tareo[0]) as $col): ?>
                            <th><?= esc($col) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tareo as $fila): ?>
                        <tr>
                            <?php foreach($fila as $valor): ?>
                                <td><?= esc($valor) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay registros para el filtro aplicado.</div>
    <?php endif; ?>
    </div>
</div>
<?= $footer ?>
