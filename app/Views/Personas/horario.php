<?= $header ?>
<div class="pc-container my-2">
  <div class="pc-content">
    <h2>Horario</h2>
<br>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mt-3">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
<form action="<?=base_url('horario/registrar')?>" method="POST">
    <div class="row">
        <div class="col-md-6"> <!-- Ocupa la mitad -->
            <div class="mb-2">
                <div class="input-group form-floating">
                    <input type="text" name="dni" id="dni" class="form-control" autofocus>
                    <label for="id">Ingrese DNI del trabajador</label>
                    <button type="button" id="buscar-dni" class="btn btn-success">Buscar</button> 
                </div>
            </div>
        </div>
        <div class="col-md-6"> <!-- Ocupa la mitad -->
            <div class="mb-2">
                <div class="form-floating">
                    <input type="text" name="trabajador" id="trabajador" class="form-control" autofocus>
                    <label for="trabajador">Trabajador</label>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="idcontrato" id="idcontrato"><!--  mostrar id de la persona-->
<br>
    <table class="table table-sm table-striped table-bordered">
      <thead>
        <colgroup>
         <col style="width: 5%;">
         <col style="width: 15%;">
         <col style="width: 12%;">
         <col style="width: 13%;">
         <col style="width: 13%;">
         <col style="width: 12%;">
        </colgroup>
        <tr>
          <th class="text-center"> 
            <input type="checkbox" id="select-all" class="form-check-input">
          </th>
          <th>Dia</th>
          <th>Entrada</th>
          <th>inicio Refrigerio</th>
          <th>Fin de Refrigerio</th>
          <th>Salida</th>
        </tr>
        <tr>
            <th class="text-center position-relative">
                <input type="checkbox" id="chk-lunes" name="row[0][checked]" value="1" class="form-check-input position-absolute top-50 start-50 translate-middle">
                <label for="chk-lunes" class="stretched-link"></label>
            </th>
            <th><input type="text" name="row[0][dia]"  id="dia" value="lunes" class="form-control row-input"></th>
            <th><input type="time" name="row[0][entrada]"  id="entrada" value="08:00" class="form-control row-input"></th>
            <th><input type="time" name="row[0][iniciorefrigerio]"  id="iniciorefrigerio" value="13:00" class="form-control row-input"></th>
            <th><input type="time" name="row[0][finrefrigerio]"  id="finrefrigerio" value="14:30" class="form-control row-input"></th>
            <th><input type="time" name="row[0][salida]"  id="salida" value="18:00" class="form-control row-input"></th>
        </tr>
        <tr>
            <th class="text-center position-relative">
                <input type="checkbox" id="chk-martes" name="row[1][checked]" value="1" class="form-check-input position-absolute top-50 start-50 translate-middle">
                <label for="chk-martes" class="stretched-link"></label>
            </th>
            <th><input type="text" name="row[1][dia]"  id="dia" value="martes" class="form-control row-input"></th>
            <th><input type="time" name="row[1][entrada]"  id="entrada" value="08:00" class="form-control row-input"></th>
            <th><input type="time" name="row[1][iniciorefrigerio]"  id="iniciorefrigerio" value="13:00" class="form-control row-input"></th>
            <th><input type="time" name="row[1][finrefrigerio]"  id="finrefrigerio" value="14:30" class="form-control row-input"></th>
            <th><input type="time" name="row[1][salida]"  id="salida" value="18:00" class="form-control row-input"></th>
        </tr>
        <tr>
            <th class="text-center position-relative">
                <input type="checkbox" id="chk-miercoles" name="row[2][checked]" value="1" class="form-check-input position-absolute top-50 start-50 translate-middle">
                <label for="chk-miercoles" class="stretched-link"></label>
            </th>
            <th><input type="text" name="row[2][dia]"  id="dia" value="miercoles" class="form-control row-input"></th>
            <th><input type="time" name="row[2][entrada]"  id="entrada" value="08:00" class="form-control row-input"></th>
            <th><input type="time" name="row[2][iniciorefrigerio]"  id="iniciorefrigerio" value="13:00" class="form-control row-input"></th>
            <th><input type="time" name="row[2][finrefrigerio]"  id="finrefrigerio" value="14:30" class="form-control row-input"></th>
            <th><input type="time" name="row[2][salida]"  id="salida" value="18:00" class="form-control row-input"></th>
        </tr>
        <tr>
            <th class="text-center position-relative">
                <input type="checkbox" id="chk-jueves" name="row[3][checked]" value="1" class="form-check-input position-absolute top-50 start-50 translate-middle">
                <label for="chk-jueves" class="stretched-link"></label>
            </th>
            <th><input type="text" name="row[3][dia]"  id="dia" value="jueves" class="form-control row-input"></th>
            <th><input type="time" name="row[3][entrada]"  id="entrada" value="08:00" class="form-control row-input"></th>
            <th><input type="time" name="row[3][iniciorefrigerio]"  id="iniciorefrigerio" value="13:00" class="form-control row-input"></th>
            <th><input type="time" name="row[3][finrefrigerio]"  id="finrefrigerio" value="14:30" class="form-control row-input"></th>
            <th><input type="time" name="row[3][salida]"  id="salida" value="18:00" class="form-control row-input"></th>
        </tr>
        <tr>
            <th class="text-center position-relative">
                <input type="checkbox" id="chk-viernes" name="row[4][checked]" value="1" class="form-check-input position-absolute top-50 start-50 translate-middle">
                <label for="chk-viernes" class="stretched-link"></label>
            </th>
            <th><input type="text" name="row[4][dia]"  id="dia" value="viernes" class="form-control  row-input"></th>
            <th><input type="time" name="row[4][entrada]"  id="entrada" value="08:00" class="form-control row-input"></th>
            <th><input type="time" name="row[4][iniciorefrigerio]"  id="iniciorefrigerio" value="13:00" class="form-control row-input"></th>
            <th><input type="time" name="row[4][finrefrigerio]"  id="finrefrigerio" value="14:30" class="form-control row-input"></th>
            <th><input type="time" name="row[4][salida]"  id="salida" value="18:00" class="form-control row-input"></th>
        </tr>
        <tr>
            <th class="text-center position-relative">
                <input type="checkbox" id="chk-sabado" name="row[5][checked]" value="1" class="form-check-input position-absolute top-50 start-50 translate-middle">
                <label for="chk-sabado" class="stretched-link"></label>
            </th>
            <th><input type="text" name="row[5][dia]"  id="dia" value="sabado" class="form-control row-input"></th>
            <th><input type="time" name="row[5][entrada]"  id="entrada" value="08:00" class="form-control row-input"></th>
            <th><input type="time" name="row[5][iniciorefrigerio]"  id="iniciorefrigerio" value="00:00" class="form-control row-input"></th>
            <th><input type="time" name="row[5][finrefrigerio]"  id="finrefrigerio" value="00:00" class="form-control row-input"></th>
            <th><input type="time" name="row[5][salida]"  id="salida" value="13:30" class="form-control row-input"></th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    </form>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const dni = document.querySelector("#dni");
  const buscarBtn = document.querySelector("#buscar-dni");
  const trabajador = document.querySelector("#trabajador");
  const seleccionarTodo = document.querySelector('#select-all');
  const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="row"]');
  const idcontrato = document.querySelector('#idcontrato');

  seleccionarTodo.addEventListener('change', () => {
    const isChecked = seleccionarTodo.checked;
    checkboxes.forEach(chk => {
      chk.checked = isChecked;
      const row = chk.closest('tr');
      const inputs = row.querySelectorAll('.row-input');
      inputs.forEach(input => {
        input.disabled = !isChecked;
      });
    });
  });

  function buscarDNI(){
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
          idcontrato.value = data.persona.idcontrato;
        }
      })
      .catch(err => {
        console.error(err);
        alert("No se encontraron datos para este DNI");
      });
  }

  buscarBtn.addEventListener("click", buscarDNI);

  dni.addEventListener("keydown", (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
      buscarDNI();
    }
  });

  checkboxes.forEach(chk => {
    const row = chk.closest('tr');
    const inputs = row.querySelectorAll('.row-input');

    // Inicialmente deshabilita inputs si no está marcado
    inputs.forEach(input => {
      input.disabled = !chk.checked;
    });

    chk.addEventListener('change', () => {
      inputs.forEach(input => {
        input.disabled = !chk.checked;
      });

      // Si algún checkbox se desmarca, desmarca "select-all"
      if (!chk.checked) {
        seleccionarTodo.checked = false;
      } else {
        // Si todos están marcados, marca "select-all"
        const allChecked = Array.from(checkboxes).every(chk => chk.checked);
        seleccionarTodo.checked = allChecked;
      }
    });
  });
});

</script>

<?= $footer ?>