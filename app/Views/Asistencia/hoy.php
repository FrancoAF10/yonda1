<?= $header ?>


<div class="pc-container my-2">
  <div class="pc-content">
    <h4>Asistencia Diaria</h4>
    <a href="<?= base_url('asistencia/permiso') ?>">permiso</a>
  
    <hr>
  
    <?php //var_dump($clientes); ?>
  
    <table class="table table-sm table-striped table-bordered">
      <thead>
        <tr>
          <!-- <th>ID</th> -->
          <th>Apellidos y Nombres</th>
          <th>Area</th>
          <th>Cargo</th>
          <th>Dia</th>
          <th>Fecha</th>
          <th>Entrada</th>
          <th>Inicio Refrigerio</th>
          <th>Fin Refrigerio</th>
          <th>Salida</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($listarasistencia as $asistencia): ?>
        <tr>
          <!-- <td><?= $asistencia['idpersona'] ?></td> -->
          <td><?= $asistencia['Apellidos y Nombres'] ?></td>
          <td><?= $asistencia['area'] ?></td>
          <td><?= $asistencia['cargo'] ?></td>
          <td><?= $asistencia['dia'] ?></td>
          <td><?= $asistencia['diamarcado'] ?></td>
          <td><?= $asistencia['entrada'] ?></td>
          <td><?= $asistencia['iniciorefrigerio'] ?></td>
          <td><?= $asistencia['finrefrigerio'] ?></td>
          <td><?= $asistencia['salida'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->


<?= $footer ?>