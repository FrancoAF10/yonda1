
<?= $header ?>
<div class="pc-container mt-4">
  <div class="pc-content">
    <h4>Carga de Asistencia Procesada</h4>
    <form id="formCarga" enctype="multipart/form-data" method="post" action="<?= base_url('carga-asistencia-procesada/procesar') ?>">
      <div class="mb-3">
        <label for="archivo" class="form-label">Selecciona archivo Excel (.xlsx)</label>
        <input type="file" name="archivo" id="archivo" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Procesar</button>
    </form>
  </div>
</div>
<?= $footer ?>