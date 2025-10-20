<?= $header ?>

<div class="pc-container my-2">
  <div class="pc-content">
    <h4>Asistencia Diaria</h4>
    <a href="<?= base_url('asistencia/permiso') ?>" class="btn btn-outline-secondary btn-sm mb-3">Permiso</a>

    <!-- Filtros -->
    <form method="post" action="<?= base_url('asistencia') ?>" class="row g-2 mb-3" id="formFiltros">
      <div class="col-md-3">
        <label>Fecha Inicio</label>
        <input type="date" name="fechaInicio" value="<?= $fechaInicio ?? '' ?>" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Fecha Fin</label>
        <input type="date" name="fechaFin" value="<?= $fechaFin ?? '' ?>" class="form-control">
      </div>
      <div class="col-md-3">
        <label>DNI</label>
        <input type="text" name="dni" value="<?= $dni ?? '' ?>" placeholder="Ingrese DNI" class="form-control">
      </div>
      <div class="col-md-3 d-flex align-items-end gap-2">
        <button type="submit" class="btn btn-primary w-50">Filtrar</button>
        <button type="button" class="btn btn-secondary w-50" id="btnLimpiar">Limpiar</button>
      </div>
    </form>

    <!-- Tabla -->
    <table id="tablaAsistencia" class="table table-sm table-striped table-bordered">
      <thead>
        <tr>
          <th>Apellidos y Nombres</th>
          <th>DNI</th>
          <th>Área</th>
          <th>Cargo</th>
          <th>Día</th>
          <th>Fecha</th>
          <th>Entrada</th>
          <th>Inicio Refrigerio</th>
          <th>Fin Refrigerio</th>
          <th>Salida</th>
          <th>Tardanza (min)</th>
          <th>Salida Anticipada (min)</th>
          <th>Exceso Refrigerio (min)</th>
          <th>Minutos No Laborados</th>
          <th>Observación</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($listarasistencia as $asistencia): ?>
        <tr>
          <td><?= $asistencia['apepaterno'] . ' ' . $asistencia['apematerno'] . ' ' . $asistencia['nombres'] ?></td>
          <td><?= $asistencia['dni'] ?></td>
          <td><?= $asistencia['area'] ?></td>
          <td><?= $asistencia['cargo'] ?></td>
          <td><?= $asistencia['dia'] ?></td>
          <td><?= $asistencia['diamarcado'] ?></td>
          <td><?= $asistencia['entrada'] ?></td>
          <td><?= $asistencia['iniciorefrigerio'] ?></td>
          <td><?= $asistencia['finrefrigerio'] ?></td>
          <td><?= $asistencia['salida'] ?></td>
          <td><?= $asistencia['tardanza_minutos'] ?></td>
          <td><?= $asistencia['salida_anticipada_minutos'] ?></td>
          <td><?= $asistencia['exceso_refrigerio_minutos'] ?></td>
          <td><?= $asistencia['minnolaborados'] ?></td>
          <td><?= $asistencia['observacion'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Botones de exportación -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
$(document).ready(function() {
  $('#tablaAsistencia').DataTable({
    searching: false,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="bi bi-file-earmark-excel-fill"></i> Excel',
        className: 'btn btn-success btn-sm',
        title: 'ASISTENCIA DE LA EMPRESA YONDA & GRUPO HUARACA'
      },
      {
        extend: 'pdfHtml5',
        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF',
        className: 'btn btn-danger btn-sm',
        orientation: 'landscape',
        pageSize: 'A4',
        title: 'ASISTENCIA DE LA EMPRESA YONDA & GRUPO HUARACA',
        exportOptions: {
        columns: ':visible' // exporta todas las columnas visibles
    },
        customize: function (doc) {
          doc.styles.title = {
            alignment: 'center',
            fontSize: 14,
            bold: true
          };
        }
      }
    ],
    scrollX: true
  });

  // Botón limpiar filtros
  $('#btnLimpiar').click(function() {
    $('#formFiltros')[0].reset();
    $('#formFiltros').submit();
  });
});
</script>

<?= $footer ?>
