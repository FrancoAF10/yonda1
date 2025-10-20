<?= $header ?>
<div class="pc-container my-2">
    <div class="pc-content">
        <!-- Mostrar mensajes flash -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?=base_url('contratos/nuevopersonal')?>" method="POST">
            <h4 class="text-center mt-4 mb-4">DATOS LABORALES</h4>
            <input type="text" name="idpersona" id="idpersona" value="<?= $idpersona ?>">

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="sucursalContrato" name="idsucursal" required>
                            <option value="">Seleccionar Sucursal</option>
                            <?php foreach($sucursal as $suc): ?>
                                <option value="<?= $suc['idsucursal'] ?>">
                                    <?= $suc['direccion'] ?> <?= $suc['sucursal'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="sucursalContrato">Sucursal</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="areaContrato" name="idarea" required>
                            <option value="">Seleccionar Área</option>
                        </select>
                        <label for="areaContrato">Área</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="cargoContrato" name="idcargo" required>
                            <option value="">Seleccionar Cargo</option>
                        </select>
                        <label for="cargoContrato">Cargo</label>
                    </div>
                </div>
            </div>
                
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
                        <label for="fechainicio">Fecha de Inicio del Contrato</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="fechafin" name="fechafin" required>
                        <label for="fechafin">Fecha de Fin del Contrato</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="sueldobase" name="sueldobase" required>
                        <label for="sueldobase">Sueldo Base del Trabajador</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="toleranciadiaria" name="toleranciadiaria" value="0" required>
                        <label for="toleranciadiaria">Tolerancia Diaria (min)</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="toleranciamensual" name="toleranciamensual" value="0" required>
                        <label for="toleranciamensual">Tolerancia Mensual (min)</label>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</div>
<?= $footer ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const sucursal = document.querySelector("#sucursalContrato");
    const areaSucursal = document.querySelector("#areaContrato");
    const cargoSucursal = document.querySelector("#cargoContrato");

    // Cargar áreas según sucursal
    sucursal.addEventListener('change', async () => {
        const idsucursal = sucursal.value;

        if (!idsucursal) {
            areaSucursal.innerHTML = `<option value=''>Seleccione</option>`;
            return;
        }

        try {
            const response = await fetch(`<?= base_url() ?>areas/${idsucursal}`, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });

            if (!response.ok) throw new Error('Error en la solicitud al servidor');

            const data = await response.json();
            areaSucursal.innerHTML = `<option value=''>Seleccionar Área</option>`;
            data.forEach(area => {
                areaSucursal.innerHTML += `<option value='${area.idarea}'>${area.area}</option>`;
            });
        } catch (error) {
            console.error(error);
        }
    });

    // Cargar cargos según área
    areaSucursal.addEventListener('change', async () => {
        const idarea = areaSucursal.value;

        if (!idarea) {
            cargoSucursal.innerHTML = `<option value=''>Seleccione</option>`;
            return;
        }

        try {
            const response = await fetch(`<?= base_url() ?>cargos/${idarea}`, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });

            if (!response.ok) throw new Error('Error en la solicitud al servidor');

            const data = await response.json();
            cargoSucursal.innerHTML = `<option value=''>Seleccionar Cargo</option>`;
            data.forEach(cargo => {
                cargoSucursal.innerHTML += `<option value='${cargo.idcargo}'>${cargo.cargo}</option>`;
            });
        } catch (error) {
            console.error(error);
        }
    });
});
</script>

        
        

        