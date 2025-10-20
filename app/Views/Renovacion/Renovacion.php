<?= $header ?>


<div class="pc-container my-2">
  <div class="pc-content">
    <h4>Renovacion</h4>  
    <hr>
  
    <?php //var_dump($clientes); ?>
  
    <table class="table table-sm table-striped table-bordered">
      <thead>
        <tr>
          <!-- <th>ID</th> -->
          <th>Apellidos y Nombres</th>
          <th>Area</th>
          <th>Cargo</th>
          <th>T doc</th>
          <th>N° doc</th>
          <th>Inicio   de Contrato</th>
          <th>FIn de Contrato</th>

          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($contratosvencidos as $vencidos): ?>
        <tr>
            <!-- <td><?= $vencidos['idpersona'] ?></td> -->
            <td><?= $vencidos['apepaterno'] ?> <?= $vencidos['apematerno'] ?> <?= $vencidos['nombres'] ?></td>
            <td><?= $vencidos['area'] ?></td>
            <td><?= $vencidos['cargo'] ?></td>
            <td><?= $vencidos['tipodoc'] ?></td>
            <td><?= $vencidos['numdoc'] ?></td>
            <td><?= $vencidos['fechainicio'] ?></td>
            <td><?= $vencidos['fechafin'] ?></td>
        <!--Cambiar por Motivo(falta cambios en tabla)-->
          
            <td>

            <a href="<?= base_url('Renovacion/NuevoContrato/').$vencidos['idpersona'] ?>" class="btn btn-sm btn-danger delete"><i class="fa-solid fa-trash"></i></a>
            <a href="<?= base_url('Renovacion/NuevoContrato/').$vencidos['idpersona'] ?>" class="btn btn-sm btn-info edit"><i class="fa-solid fa-pen-to-square"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->


<?= $footer ?>