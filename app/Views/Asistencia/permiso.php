<?= $header ?>


<div class="pc-container my-2">
  <div class="pc-content">
    <h4>PERMISO</h4>
    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>
  <form action="<?=base_url("permiso/registrar")?>" method="POST" enctype="multipart/form-data">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="form-floating">
                <input type="text" name="dni" id="dni" class="form-control">
                <label for="dni">DNI DEL TRABJADOR</label>
              </div>
              <button id="search" type="button" class="btn btn-success">Buscar</button>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-floating">
              <input type="text" name="trabajador" id="trabajador" class="form-control" readonly>
              <label for="trabajador">Nombres y Apellidos</label>
            </div>
          </div>
        </div>
        <br>
        <br><br>  
        <div class="row mt-2">
          <div class="col-md-4">
            <div class="form-floating">
              <input type="time" name="horainicio" id="horainicio" class="form-control">
              <label for="horainicio">Hora inicio</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-floating">
              <input type="time" name="horafin" id="horafin" class="form-control">
              <label for="horafin">Hora fin</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-floating">
              <input type="date" name="fechasolicitud" id="fechasolicitud" class="form-control" value="<?= date('Y-m-d') ?>"
>
              <label for="fechasolicitud">Fecha Solicitud</label>
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-8">
            <div class="form-floating">
              <input type="text" name="motivo" id="motivo" class="form-control">
              <label for="motivo">Motivo</label>
            </div>
          </div>
        <div class="col-md-4">
            <div class="form-floating">
              <input type="text" name="duracionminutos" id="duracionminutos" class="form-control" readonly>
              <label for="duracionminutos">Duración Permiso(MIN)</label>
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-12">
            <div class="form-floating">
              <input type="file" name="evidencia" id="evidencia" class="form-control">
              <label for="evidencia">Evidencia</label>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Guardar Permiso</button>
      </div>
    </div>
  </form>
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->

<script>
  document.addEventListener('DOMContentLoaded',function(){
    const horainicio=document.getElementById('horainicio');
    const horafin=document.getElementById('horafin');
    const duracion=document.getElementById('duracionminutos');

    function calcularDuracion(){
      if(horainicio.value && horafin.value){
        const inicio= new Date("1970-01-01T"+horainicio.value+":00");
        const fin= new Date("1970-01-01T"+horafin.value+":00");

        const minutos=(fin-inicio)/60000;
        if(minutos>0){
          duracion.value=minutos;
        } else{
          duracion.value="";
          alert("La hora fin debe ser mayor a la hora de inicio");
        }
      }
    }
    horainicio.addEventListener("change",calcularDuracion);
    horafin.addEventListener("change",calcularDuracion);

    const dni=document.querySelector("#dni")
    const buscarBtn=document.querySelector("#search");
    const trabajador = document.querySelector("#trabajador");


    buscarBtn.addEventListener("click", () => {
    if (!dni.value) {
      alert("Ingrese DNI");
      return;
    }

    fetch("<?= base_url('horario/buscar/') ?>" + dni.value)
      .then(response => {
        if (!response.ok) throw new Error("No encontrado");
        return response.json();
      })
      .then(data => {
        if (data.success) {
          trabajador.value = data.persona.nombres + " " + data.persona.apepaterno + " " + data.persona.apematerno;
        }
      })
      .catch(err => {
        console.error(err);
        alert("No se encontraron datos para este DNI");
      });
  });
  })
</script>


<?= $footer ?>
