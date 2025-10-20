<?= $header ?>


<div class="pc-container my-2">
  <div class="pc-content">
    <h4>Contratos Vencidos</h4>
    <a href="<?= base_url('Renovacion/NuevoContrato') ?>">Nuevo Contrato</a>
  
    <hr>
  
    <?php //var_dump($clientes); ?>
  
    <table class="table table-sm table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Apellidos y Nombres</th>
          <th>Area</th>
          <th>Cargo</th>
          <th>T doc</th>
          <th>N° doc</th>
          <th>Motivo</th>
  
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($contratosvencidos as $vencidos): ?>
        <tr>
            <td><?= $vencidos['idpersona'] ?></td>
            <td><?= $vencidos['apepaterno'] ?> <?= $vencidos['apematerno'] ?> <?= $vencidos['nombres'] ?></td>
            <td><?= $vencidos['area'] ?></td>
            <td><?= $vencidos['cargo'] ?></td>
            <td><?= $vencidos['tipodoc'] ?></td>
            <td><?= $vencidos['numdoc'] ?></td>
            <td><?= $vencidos['motivo'] ?></td>
        <!--Cambiar por Motivo(falta cambios en tabla)-->

            <td>

            <a href="<?= base_url('Renovacion/infoVencido/' . $vencidos['idpersona'])?>" class="btn btn-sm btn-warning info"><i class="fa-solid fa-sheet-plastic"></i></a>
            
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->


<?= $footer ?>