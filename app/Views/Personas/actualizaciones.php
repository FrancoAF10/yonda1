    <?= $header ?>
    <div class="pc-container my-2">
        <div class="pc-content">

            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="persona-tab" data-bs-toggle="tab" data-bs-target="#persona"
                        type="button" role="tab" aria-controls="persona" aria-selected="true">DATOS PERSONA</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bancario-tab" data-bs-toggle="tab" data-bs-target="#bancario" type="button"
                        role="tab" aria-controls="bancario" aria-selected="false">DATOS BANCARIOS</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pensiones-tab" data-bs-toggle="tab" data-bs-target="#pensiones"
                        type="button" role="tab" aria-controls="pensiones" aria-selected="false">SISTEMA PENSIONES</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="asignacion-tab" data-bs-toggle="tab" data-bs-target="#asignacion"
                        type="button" role="tab" aria-controls="asignacion" aria-selected="false">ASIGNACIÓN
                        FAMILIAR</button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="contrato-tab" data-bs-toggle="tab" data-bs-target="#contrato" type="button" role="tab" aria-controls="contrato" aria-selected="false">CONTRATO</button>
            </li> -->
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- DATOS PERSONALES -->
            <div class="tab-pane fade show active" id="persona" role="tabpanel" aria-labelledby="persona-tab">
                <div class="container py-4">
                    <form method="POST" action="<?= base_url('personas/actualizar') ?>" class="card shadow-sm p-4 border-0 rounded-3">
                        <input type="hidden" name="idpersona" id="idpersona" value="<?= $persona['idpersona'] ?>">

                        <h4 class="text-center mb-4 text-primary">DATOS PERSONALES</h4>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="apepaterno" name="apepaterno"
                                        value="<?= $persona['apepaterno'] ?>" required>
                                    <label for="apepaterno">Apellido Paterno</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="apematerno" name="apematerno"
                                        value="<?= $persona['apematerno'] ?>" required>
                                    <label for="apematerno">Apellido Materno</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                        value="<?= $persona['nombres'] ?>" required>
                                    <label for="nombres">Nombres</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="fechanac" name="fechanac"
                                        value="<?= $persona['fechanac'] ?>" required>
                                    <label for="fechanac">Fecha de Nacimiento</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="M" <?= ($persona['genero'] == 'M') ? 'selected' : '' ?>>Masculino</option>
                                        <option value="F" <?= ($persona['genero'] == 'F') ? 'selected' : '' ?>>Femenino</option>
                                    </select>
                                    <label for="genero">Género</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="estadocivil" name="estadocivil" required>
                                        <option value="Soltero" <?= ($persona['estadocivil'] == 'Soltero') ? 'selected' : '' ?>>Soltero</option>
                                        <option value="Casado" <?= ($persona['estadocivil'] == 'Casado') ? 'selected' : '' ?>>Casado</option>
                                        <option value="Divorciado" <?= ($persona['estadocivil'] == 'Divorciado') ? 'selected' : '' ?>>Divorciado</option>
                                        <option value="Viudo" <?= ($persona['estadocivil'] == 'Viudo') ? 'selected' : '' ?>>Viudo</option>
                                        <option value="Separado" <?= ($persona['estadocivil'] == 'Separado') ? 'selected' : '' ?>>Separado</option>
                                        <option value="Conviviente" <?= ($persona['estadocivil'] == 'Conviviente') ? 'selected' : '' ?>>Conviviente</option>
                                    </select>
                                    <label for="estadocivil">Estado Civil</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="tipodoc" name="tipodoc" required>
                                        <option value="DNI" <?= ($persona['tipodoc'] == 'DNI') ? 'selected' : '' ?>>DNI</option>
                                        <option value="CEX" <?= ($persona['tipodoc'] == 'CEX') ? 'selected' : '' ?>>Carnet de Extranjería</option>
                                        <option value="PASS" <?= ($persona['tipodoc'] == 'PASS') ? 'selected' : '' ?>>Pasaporte</option>
                                    </select>
                                    <label for="tipodoc">Tipo de Documento</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="numdoc" name="numdoc"
                                        value="<?= $persona['numdoc'] ?>" required>
                                    <label for="numdoc">Número de Documento</label>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-center mt-4 mb-4 text-primary">DATOS DE CONTACTO</h4>

                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        value="<?= $persona['direccion'] ?>" required>
                                    <label for="direccion">Dirección</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="referencia" name="referencia"
                                        value="<?= $persona['referencia'] ?>" required>
                                    <label for="referencia">Referencia</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="telefono" name="telefono" minlength="9"
                                        maxlength="9" pattern="[0-9]{9}" value="<?= $persona['telefono'] ?>" required>
                                    <label for="telefono">Teléfono</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?= $persona['email'] ?>" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="<?= base_url('personas') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>

                <!-- DATOS BANCARIOS -->
                <div class="tab-pane fade" id="bancario" role="tabpanel" aria-labelledby="bancario-tab">
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-primary text-white text-center py-3 rounded-top">
                            <h4 class="mb-0"><i class="bi bi-bank"></i> DATOS BANCARIOS</h4>
                        </div>
                        <div class="card-body">
                            <form id="form-numcuenta">
                                <input type="hidden" name="idpersona" id="idpersona" value="<?= $persona['idpersona'] ?>">
                                <div class="mb-3">
                                    <h5>COLABORADOR: <?= $persona['nombres'] ?> <?= $persona['apepaterno'] ?> <?= $persona['apematerno'] ?></h5>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="tipomoneda" id="tipomoneda" class="form-select">
                                                <option value="">Seleccione Moneda</option>
                                                <option value="soles">Soles</option>
                                            </select>
                                            <label for="tipomoneda">Tipo de Moneda</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="tipoinstitucion" id="tipoinstitucion" class="form-select">
                                                <option value="">Seleccione Institución</option>
                                                <option value="financiera">Financiera</option>
                                            </select>
                                            <label for="tipoinstitucion">Tipo de Institución</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="nombre" id="nombre" class="form-select">
                                                <option value="">Seleccione Nombre</option>
                                                <option value="BCP">BCP</option>
                                                <option value="BBVA">BBVA</option>
                                            </select>
                                            <label for="nombre">Nombre</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" name="numcuenta" id="numcuenta" class="form-control" pattern="[0-9-]+" required>
                                            <label for="numcuenta">Número de Cuenta</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" name="cci" id="cci" class="form-control" pattern="[0-9-]+" maxlength="25" required>
                                            <label for="cci">Número de Cuenta Interbancario</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="date" name="fechainicio" id="fechainicio" class="form-control">
                                            <label for="fechainicio">Fecha de Inicio</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Registrar</button>
                            </form>

                            <div class="table-responsive mt-4">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Institución</th>
                                            <th>Nombre</th>
                                            <th>N° Cuenta</th>
                                            <th>CCI</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin / Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-numcuenta">
                                        <?php foreach ($numcuenta as $cuenta): ?>
                                        <tr>
                                            <td><?= $cuenta['tipoinstitucion'] ?></td>
                                            <td><?= $cuenta['nombre'] ?></td>
                                            <td><?= $cuenta['numcuenta'] ?></td>
                                            <td><?= $cuenta['cci'] ?></td>
                                            <td><?= date("d/m/Y", strtotime($cuenta['fechainicio'])) ?></td>
                                            <td>
                                                <?= $cuenta['fechafin'] 
                                                    ? date("d/m/Y", strtotime($cuenta['fechafin'])) . ' <span class="badge bg-danger ms-2">Cerrada</span>' 
                                                    : '<span class="badge bg-success">Activa</span>' ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SISTEMA DE PENSIONES -->
                <div class="tab-pane fade" id="pensiones" role="tabpanel" aria-labelledby="pensiones-tab">
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-primary text-white text-center py-3 rounded-top">
                            <h4 class="mb-0">
                                <i class="bi bi-shield-lock"></i> SISTEMA DE PENSIONES
                            </h4>
                        </div>

                        <div class="card-body">
                            <form id="form-sistemapensiones" class="needs-validation" novalidate>
                                <input type="hidden" name="idpersona" id="idpersona" value="<?= $persona['idpersona'] ?>">

                                <div class="alert alert-info mb-4">
                                    <strong>Colaborador:</strong>
                                    <?= $persona['nombres'] ?> <?= $persona['apepaterno'] ?> <?= $persona['apematerno'] ?>
                                </div>

                                <div class="row g-3">
                                    <!-- Tipo de sistema -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="tiposistema" id="tiposistema" class="form-select" required>
                                                <option value="">Seleccione</option>
                                                <option value="AFP">AFP</option>
                                                <option value="ONP">ONP</option>
                                            </select>
                                            <label for="tiposistema">Tipo de Sistema</label>
                                            <div class="invalid-feedback">Seleccione un tipo de sistema.</div>
                                        </div>
                                    </div>

                                    <!-- Nombre del sistema (solo si es AFP) -->
                                    <div class="col-md-4" id="nombresistema-container">
                                        <div class="form-floating">
                                            <select name="nombresistema" id="nombresistema" class="form-select">
                                                <option value="">Seleccione</option>
                                                <option value="PROFUTURO">PROFUTURO</option>
                                                <option value="INTEGRA">INTEGRA</option>
                                                <option value="PRIMA">PRIMA</option>
                                                <option value="HABITAT">HABITAT</option>
                                            </select>
                                            <label for="nombresistema">Nombre del Sistema</label>
                                        </div>
                                    </div>

                                    <!-- CUSPP (solo si es AFP) -->
                                    <div class="col-md-4" id="cuspp-container">
                                        <div class="form-floating">
                                            <input type="text" name="cuspp" id="cuspp" maxlength="12" class="form-control" placeholder="CUSPP">
                                            <label for="cuspp">Código CUSPP</label>
                                            <div class="form-text">Código único del sistema privado de pensiones.</div>
                                        </div>
                                    </div>

                                    <!-- Fecha de afiliación -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="date" name="fechaafiliacion" id="fechaafiliacion" class="form-control" required>
                                            <label for="fechaafiliacion">Fecha de Afiliación</label>
                                            <div class="invalid-feedback">Ingrese una fecha válida.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="bi bi-save"></i> Guardar Registro
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de registros -->
                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-header bg-secondary text-white text-center py-2 rounded-top">
                            <h5 class="mb-0"><i class="bi bi-journal-text"></i> Registros de Sistema de Pensiones</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0 align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo Sistema</th>
                                            <th>Nombre</th>
                                            <th>Fecha Afiliación</th>
                                            <th>Fecha Fin/Estado</th>
                                            <th>CUSPP</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-sistemapensiones">
                                        <?php if (!empty($sispensiones)): ?>
                                            <?php foreach ($sispensiones as $i => $sp): ?>
                                                <tr>
                                                    <td><?= $i + 1 ?></td>
                                                    <td><?= esc($sp['tiposistema']) ?></td>
                                                    <td><?= esc($sp['nombresistema']) ?: '--' ?></td>
                                                    <td><?= date("d/m/Y", strtotime($sp['fechaafiliacion'])) ?></td>
                                                    <td>
                                                        <?php if ($sp['fechatermino']): ?>
                                                            <?= date("d/m/Y", strtotime($sp['fechatermino'])) ?>
                                                            <span class="badge bg-danger ms-2">Finalizado</span>
                                                        <?php else: ?>
                                                            <span class="text-muted">————</span>
                                                            <span class="badge bg-success ms-2">Vigente</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= esc($sp['cuspp']) ?: '--' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center text-muted py-3">No hay registros aún.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ASIGNACIÓN FAMILIAR -->
                <div class="tab-pane fade" id="asignacion" role="tabpanel" aria-labelledby="asignacion-tab">
                    <div class="container py-4">
                        <h4 class="text-center mb-4">CARGA FAMILIAR</h4>
                        <h5>COLABORADOR: <?=$persona['nombres']?> <?=$persona['apepaterno']?> <?=$persona['apematerno']?></h5>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="dni" class="form-label">Buscar Por DNI</label>
                                <small class="d-none" id="searching">Por favor espere ....</small>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="numdoc_buscar" id="numdoc_buscar" class="form-control" maxlength="12">
                                    <button type="button" class="btn btn-outline-success" id="buscar-numdoc">Buscar</button>
                                    <button type="button" class="btn btn-outline-secondary" id="copiar-numdoc" title="Copiar DNI">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </div>                    
                    <form id="form-cargafamiliar">
                            <input type="hidden" name="idpersona" id="idpersona" value="<?=$persona['idpersona']?>">
                            <br> 
                            <div class="row mb-3 ">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="hidden" name="idhijo" id="idhijo">
                                        <input type="text" name="idpersona_hijo" id="idpersona_hijo" class="form-control">
                                        <label for="hijo"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="parentesco" id="parentesco" class="form-select">
                                            <option value="">Seleccione</option>
                                            <option value="Hijo">Hijo</option>
                                            <option value="Cónyuge">Cónyuge</option>
                                        </select>
                                        <label for="parentesco">Parentesco</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating"> 
                                        <input type="file" name="evidencia" id="evidencia" class="form-control">
                                        <label for="evidencia">Evidencia</label>
                                    </div>
                                </div>
                            </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>

                        <table class="table table-bordered mt-5">
                            <thead>
                                <tr>
                                    <th>PARENTESCO</th>
                                    <th>EVIDENCIA</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-cargafamiliar">
                            <?php foreach($cargafamiliar as $cf): ?>
                                <tr class="text-center">
                                    <td><?= esc($cf['parentesco']) ?></td>
                                    <td>
                                        <?php if (!empty($cf['evidencia'])): ?>
                                            <a href="<?= base_url('uploads/' . $cf['evidencia']) ?>" 
                                            target="_blank" 
                                            class="btn btn-sm btn-outline-secondary">
                                            Ver archivo
                                            </a>
                                        <?php else: ?>
                                            --
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
    <!-- fin -->
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnBuscar = document.querySelector("#buscar-numdoc");
            const numDoc = document.querySelector("#numdoc_buscar");
            const persona = document.querySelector("#idpersona_hijo");
            const idpersona = document.querySelector("#idpersona");
            const buscando = document.querySelector("#searching");

            const tipoSelect = document.getElementById('tiposistema');
            const nombreSistema = document.getElementById('nombresistema-container');
            const cuspp = document.getElementById('cuspp-container');
            //para numero de cuenta
            const formnumcuenta = document.getElementById("form-numcuenta");
            const tbodync = document.getElementById("tbody-numcuenta");
            //para sistema de pensiones
            const formsispensiones = document.getElementById("form-sistemapensiones");
            const tbodysp = document.getElementById("tbody-sistemapensiones");
            //para carga/asignación familiar
            const formcargafamiliar = document.getElementById("form-cargafamiliar")
            const tbodycf = document.getElementById("tbody-cargafamiliar")
            formnumcuenta.addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(formnumcuenta);

                try {
                    const response = await fetch("<?= base_url('numcuenta/guardar') ?>", {
                        method: "POST",
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error("Error en la petición");
                    }

                    const data = await response.json();

                    if (data.status === "ok") {
                        formnumcuenta.reset();

                        tbodync.innerHTML = '';
                        data.cuentas.forEach(cuenta => {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                            <td>${cuenta.tipoinstitucion}</td>
                            <td>${cuenta.nombre}</td>
                            <td>${cuenta.numcuenta}</td>
                            <td>${cuenta.cci}</td>
                            <td>${cuenta.fechainicio}</td>
                            <td>${cuenta.fechafin ?? '--'}</td>
                        `;
                            tbodync.appendChild(tr);
                        });
                    } else {
                        alert("Error: " + (data.message || "No se pudo agregar"));
                    }
                } catch (error) {
                    console.error(error);
                    alert("Error de conexión");
                }
            });

            formsispensiones.addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(formsispensiones);
                try {
                    const response = await fetch("<?= base_url('sispensiones/guardar') ?>", {
                        method: "POST",
                        body: formData
                    });
                    if (!response.ok) {
                        throw new Error("Error en la petición")
                    }
                    const data = await response.json();
                    if (data.status === "ok") {
                        formsispensiones.reset();

                        tbodysp.innerHTML = '';
                        data.sispensiones.forEach(pensiones => {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                            <td>${pensiones.tiposistema}</td>
                            <td>${pensiones.nombresistema ?? '--'}</td>
                            <td>${pensiones.fechaafiliacion}</td>
                            <td>${pensiones.fechatermino ?? '--'}</td>
                            <td>${pensiones.cuspp ?? '--'}</td>
                        `;
                            tbodysp.appendChild(tr);
                        });
                    } else {
                        alert("Error: " + (data.message || "No se pudo agregar"));
                    }
                } catch (error) {
                    console.error(error);
                    alert("Error de conexión")
                }
            })

            formcargafamiliar.addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(formcargafamiliar);
                try {
                    const response = await fetch("<?= base_url('cargafamiliar/guardar') ?>", {
                        method: "POST",
                        body: formData
                    });
                    if (!response.ok) {
                        throw new Error("Error en la petición")
                    }
                    const data = await response.json();
                    if (data.status === "ok") {
                        formcargafamiliar.reset();

                        tbodycf.innerHTML = '';
                        data.cargafamiliar.forEach(familia => {
                        const tr = document.createElement("tr");
                            tr.classList.add("text-center");
                            tr.innerHTML = `
                                <td>${familia.parentesco}</td>
                                <td>${familia.evidencia ? `<a href='<?= base_url('./uploads/') ?>${familia.evidencia}' target='_blank' class='btn btn-sm btn-outline-secondary'>Ver archivo</a>` : '--'}</td>
                            `;

                            tbodycf.appendChild(tr);
                        });
                    } else {
                        alert("Error: " + (data.message || "No se pudo agregar"));
                    }
                } catch (error) {
                    console.error(error);
                    alert("Error de Conexión")
                }
            })
            
            async function buscarAPI() {
                if (!numDoc.value) {
                    alert('Escriba el Número de documento');
                    return;
                }

                buscando.classList.remove("d-none");

                try {
                    const response = await fetch(`http://yonda1.test/api/personas/buscarhijos/${numDoc.value}`, {
                        method: 'GET',
                        headers: { 'Content-type': 'application/json' }
                    });

                    if (!response.ok) throw new Error('Error en la solicitud');

                    const data = await response.json();
                    buscando.classList.add("d-none");
                    
                    if (data.success) {
                        persona.value = `${data.apepaterno} ${data.apematerno} ${data.nombres}`;
                        document.querySelector("#idhijo").value = data.idpersona; 
                        
                    } else {
                        persona.value = '';
                        document.querySelector("#idhijo").value = '';
                        mensajeInfo.textContent = "La persona no ha laborado anteriormente en la empresa. Por favor, regístrela.";
                        mensajeInfo.classList.add("text-danger");
                    }
                } catch (error) {
                    console.error(error);
                    buscando.classList.add("d-none");
                }
            }

            btnBuscar.addEventListener("click", buscarAPI);
            numDoc.addEventListener("keypress", e => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    buscarAPI();
                }
            });

            function actualizarSP() {
                const tipo = tipoSelect.value;

                if (tipo === 'ONP') {
                    nombreSistema.style.display = 'none';
                    cuspp.style.display = 'none';
                } else if (tipo === 'AFP') {
                    nombreSistema.style.display = 'block';
                    cuspp.style.display = 'block';
                } else {
                    nombreSistema.style.display = 'none';
                    cuspp.style.display = 'none';
                }
            }

            tipoSelect.addEventListener('change', actualizarSP);
            actualizarSP(); // al cargar la página
        });
    </script>

    <?= $footer ?>