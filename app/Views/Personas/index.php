<?= $header ?>


<div class="pc-container my-2">
  <div class="pc-content">
    <h4>Trabajadores</h4>
    <a href="<?= base_url('personas/registrar') ?>">Registrar</a>
  
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

          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($listarpersonas as $personas): ?>
        <tr>
            <td><?= $personas['idpersona'] ?></td>
            <td><?= $personas['apepaterno'] ?> <?= $personas['apematerno'] ?> <?= $personas['nombres'] ?></td>
            <td><?= $personas['area'] ?></td>
            <td><?= $personas['cargo'] ?></td>
            <td><?= $personas['tipodoc'] ?></td>
            <td><?= $personas['numdoc'] ?></td>

            <td>
            <a href="<?= base_url('personas/borrar/' . $personas['idpersona']) ?>" class="btn btn-sm btn-danger delete"><i class="fa-solid fa-trash"></i></a>
            <a href="<?= base_url('personas/editar/' . $personas['idpersona']) ?>" class="btn btn-sm btn-info edit"><i class="fa-solid fa-pen-to-square"></i></a>
            <a href="<?= base_url( 'personas/info/' . $personas['idpersona']) ?>" class="btn btn-sm btn-warning info"><i class="fa-solid fa-sheet-plastic"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->


<?= $footer ?>
