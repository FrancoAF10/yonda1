<?= $header ?>

<div class="pc-container my-2">
    <div class="pc-content">
      <h3>LICENCIAS</h3>
      <form action="/otros/licencias/registrar" method="POST" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <div class="row">
                <div class="col-md-6"> 
                    <div class="mb-2">
                        <div class="input-group form-floating">
                            <input type="text" name="numdoc" id="numdoc" class="form-control" autofocus>
                            <label for="numdoc">Ingrese DNI del trabajador</label>
                            <button type="button" id="buscar-numdoc" class="btn btn-success">Buscar</button> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <div class="form-floating">
                            <input type="text" name="trabajador" id="trabajador" class="form-control" autofocus>
                            <label for="trabajador">Trabajador</label>
                        </div>
                    </div>
                </div>
            </div>
        <input type="text" name="idcontrato" id="idcontrato">
            <div class="row mt-3"><!--LICENCIAS-->
              <div class="col-md-9">
                <div class="form-floating">
                  <select name="idmotivolic" id="idmotivolic" class="form-select">
                    <?php foreach ($motivos as $ml) : ?>
                      <option value="<?=$ml['idmotivolic']?>"><?=$ml['motivo']?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="idmotivolic">Motivo</label>
                </div>
              </div>
                <div class="col-md-3">
                  <div class="form-floating">
                    <select name="conGoce" id="conGoce" class="form-select">
                      <option value="0">Con Goce</option>
                      <option value="1">Sin Goce</option>
                    </select>
                  </div>
                </div>
            </div><!--LICENCIAS-->
            <div class="row mt-3"> <!--FECHA INICIO / FECHA FIN-->
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="date" name="fechainicio" id="fechainicio" class="form-control">
                  <label for="fechainicio">Fecha Inicio</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="date" name="fechafin" id="fechafin" class="form-control">
                  <label for="fechafin">Fecha Inicio</label>
                </div>
              </div>
            </div> <!--FECHA INICIO / FECHA FIN-->
            <div class="row mt-3">
              <div class="col-md-4">
                <div class="form-floating">
                  <input type="file" name="evidencia" id="evidencia" class="form-control">
                  <label for="evidencia">Evidencia</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating">
                  <select name="estado" id="estado" class="form-select">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobado">Aprobado</option>
                    <option value="Rechazado">Rechazado</option>
                  </select>
                  <label for="estado">Estado</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating">
                  <input type="date" name="fechasolicitud" id="fechasolicitud" class="form-control">
                  <label for="fechasolicitud">Fecha Solicitud</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="input" class="btn btn-primary">Registrar</button>
          </div>
        </div>
      </form>
      <table class="table table-bordered">
        <colgroup>
           <col style="width:20%">
           <col style="width:12%">
           <col style="width:8%">
           <col style="width:10%">
           <col style="width:10%">
           <col style="width:15%">
           <col style="width:10%">
           <col style="width:15%">
        </colgroup>
        <thead>
          <tr>
            <th>Trabajador</th> 
            <th>Motivo</th> 
            <th>Con Goce</th> 
            <th>Fecha Inicio</th> 
            <th>Fecha Fin</th> 
            <th>Evidencia</th> 
            <th>Estado</th> 
            <th>FechaSolicitud</th> 
          </tr>
        </thead>
        <tbody>
          <?php foreach($licencias as $licencia) : ?>
          <tr>
            <td><?=$licencia['nombres']?> <?=$licencia['apepaterno']?> <?=$licencia['apematerno']?></td>
            <td><?=$licencia['motivo']?></td>
            <td><?=$licencia['conGoce']?></td>
            <td><?=$licencia['fecha_inicio_lic']?></td>
            <td><?=$licencia['fecha_fin_lic']?></td>
            <td><?=$licencia['evidencia']?></td>
            <td><?=$licencia['estado_lic']?></td>
            <td><?=$licencia['fechasolicitud']?></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const numDoc = document.querySelector("#numdoc");
  const buscarBtn = document.querySelector("#buscar-numdoc");
  const trabajador = document.querySelector("#trabajador");
  const idcontrato=document.querySelector('#idcontrato');

  function buscarnumDoc(){
    if (!numDoc.value) {
      alert("Ingrese DNI");
      return;
    }

    fetch("<?= base_url('licencias/buscar/') ?>" + numDoc.value)
      .then(response => {
        if (!response.ok) throw new Error("No encontrado");
        return response.json();
      })
      .then(data => {
        if (data.success) {
          trabajador.value = data.persona.nombres + " " + data.persona.apepaterno + " " + data.persona.apematerno;
          idcontrato.value=data.persona.idcontrato;
        }
      })
      .catch(err => {
        console.error(err);
        alert("No se encontraron datos para este DNI");
      });
  }

  buscarBtn.addEventListener("click", buscarnumDoc);

  numDoc.addEventListener("keydown", (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
      buscarnumDoc();
    }
  });

});
</script>
  <?= $footer ?>