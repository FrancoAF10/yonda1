 <?= $header ?>

    <div class="pc-container my-2">
    <div class="pc-content">
        <h2>Registro de Trabajador</h2>
        <a href="<?= base_url('personas') ?>">Volver a la lista</a>
    
        <!-- 
        PARA GUARDAR:
        1. Construye la interfaz VISTA
        2. Definir un nueva RUTA utilizando "POST" (envía desde un formulario)
        3. Crear un método en el controlador para recibir los datos y enviarlos a la BD
        -->
        <form  method="POST" action="<?=base_url("personas/registrar")?>">
            <!-- Información Personal -->
            <h4>DATOS PERSONALES</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="apepaterno" name="apepaterno" required>
                        <label for="apepaterno">Apellido Paterno</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="apematerno" name="apematerno" required>
                        <label for="apematerno">Apellido Materno</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                        <label for="nombres">Nombres</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="fechanac" name="fechanac" required>
                        <label for="fechanac">Fecha de Nacimiento</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="genero" name="genero" required>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                        <label for="genero">Género</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="estadocivil" name="estadocivil" required>
                            <option value="Soltero">Soltero</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viudo">Viudo</option>
                            <option value="Separado">Separado</option>
                            <option value="Conviviente">Conviviente</option>
                        </select>
                        <label for="estadocivil">Estado Civil</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="tipodoc" name="tipodoc" required>
                            <option value="DNI">DNI</option>
                            <option value="CEX">Carnet de extranjeria</option>
                            <option value="PASS">Pasaporte</option>
                        </select>
                        <label for="tipodoc">Tipo de Documento</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="numdoc" name="numdoc" required>
                        <label for="numdoc">Número de Documento</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                    <select name="departamentos" id="departamentos" class="form-select">
                        <option value="">Seleccionar Departamento</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value="<?=$departamento['iddepartamento']?>"><?=$departamento['departamento']?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="departamento">Departamento</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="provincias" id="provincias" class="form-select">
                            <option value="">Seleccionar Provincia</option>
                        </select>
                        <label for="">Provincias</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="iddistrito" id="distritos" class="form-select">
                            <option value="">Seleccionar Distrito</option>
                        </select>
                        <label for="">Distritos</label>
                    </div>
                </div>
            </div>
            <h4>DATOS DE CONTACTO</h4>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                        <label for="direccion">Dirección</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="referencia" name="referencia" required>
                        <label for="referencia">Referencia</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                            <label for="telefono">Telefono</label>
                        </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="email" name="email" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
            </div>

            <h4>DATOS LABORALES</h4>
            <!-- Datos Laborales -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="departamentoContrato" name="departamentoContrato" required>
                            <option value="">Seleccionar Departamento</option>
                            <?php foreach($departamentos as $departamento): ?>
                                <option value="<?=$departamento['iddepartamento']?>"><?=$departamento['departamento']?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="departamentoContrato">Departamento</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="provinciaContrato" name="provinciaContrato" required>
                            <option value="">Seleccionar Provincia</option>
                        </select>
                        <label for="provinciaContrato">Provincia</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="distritoContrato" name="distritoContrato" required>
                            <option value="">Seleccionar Distrito</option>
                        </select>
                        <label for="distritoContrato">Distrito</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="sucursalContrato" name="idsucursal" required>
                            <option value="">Seleccionar Sucursal</option>
                        </select>
                        <label for="sucursalContrato">Sucursal</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="areaContrato" name="idarea" required>
                            <option value="">Seleccionar Área</option>
                        </select>
                        <label for="areaContrato">Área</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
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
                        <input type="number" class="form-control" id="toleranciadiaria" name="toleranciadiaria" required>
                        <label for="toleranciadiaria">Tolerancia Diaria</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="toleranciamensual" name="toleranciamensual" required>
                        <label for="toleranciamensual">Tolerancia Mensual</label>
                    </div>
                </div>
            </div>

            <!-- Botón de Envío -->
            <a href="<?=base_url('personas')?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

    </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const departamentos = document.querySelector("#departamentos")
        const provincias = document.querySelector("#provincias")
        const distritos = document.querySelector("#distritos")
        const sucursales = document.querySelector("#sucursales")
        const areas = document.querySelector("#area")
        const cargos = document.querySelector("#cargo")

        departamentos.addEventListener("change", async () => {
        const iddepartamento = departamentos.value
        
        if (!iddepartamento){ return }

        const response = await fetch(`http://yonda1.test/personas/provincias`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({iddepartamento: iddepartamento})
        })

        const data= await response.json()
        provincias.innerHTML="<option value=''>Seleccionar Provincia</option>"
        distritos.innerHTML="<option value=''>Seleccionar Distrito</option>"
        data.forEach(provincia => {
            provincias.innerHTML+=`<option value="${provincia.idprovincia}">${provincia.provincia}</option>`
        })
        })

        //para obtener cargar provincias
        provincias.addEventListener("change",async()=>{
            const idprovincia=provincias.value;
            if(!idprovincia){return}

            const response=await fetch(`http://yonda1.test/personas/distritos`,{
                method:'POST',
                headers:{'Content-Type':'application/json'},
                body: JSON.stringify({idprovincia})
            })

            const data=await response.json();
            //traer los distritos dentro del select
            distritos.innerHTML="<option value=''>Seleccionar Distrito</option>";
            data.forEach(distrito => {
                distritos.innerHTML+=`<option value="${distrito.iddistrito}">${distrito.distrito}</option>`;
            });
        })

                //DATOS DE CONTRATO
            const departamentoC   = document.querySelector("#departamentoContrato")
            const provinciaC  = document.querySelector("#provinciaContrato")
            const distritoC  = document.querySelector("#distritoContrato")
            const sucursalC   = document.querySelector("#sucursalContrato")
            const areaC  = document.querySelector("#areaContrato")
            const cargoC = document.querySelector("#cargoContrato")

            departamentoC.addEventListener("change", async () => {
                const iddepartamento = departamentoC.value
                if (!iddepartamento) return

                const response = await fetch(`http://yonda1.test/personas/provincias`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({iddepartamento})
                })
                const data = await response.json()

                provinciaC.innerHTML = "<option value=''>Seleccionar Provincia</option>"
                distritoC.innerHTML = "<option value=''>Seleccionar Distrito</option>"
                sucursalC.innerHTML  = "<option value=''>Seleccionar Sucursal</option>"
                areaC.innerHTML = "<option value=''>Seleccionar Área</option>"
                cargoC.innerHTML = "<option value=''>Seleccionar Cargo</option>"

                data.forEach(prov => {
                    provinciaC.innerHTML += `<option value="${prov.idprovincia}">${prov.provincia}</option>`
                })
            })

            provinciaC.addEventListener("change", async () => {
                const idprovincia = provinciaC.value
                if (!idprovincia) return

                const response = await fetch(`http://yonda1.test/personas/distritos`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({idprovincia})
                })
                const data = await response.json()

                distritoC.innerHTML = "<option value=''>Seleccionar Distrito</option>"
                sucursalC.innerHTML  = "<option value=''>Seleccionar Sucursal</option>"
                areaC.innerHTML = "<option value=''>Seleccionar Área</option>"
                cargoC.innerHTML = "<option value=''>Seleccionar Cargo</option>"

                data.forEach(dist => {
                    distritoC.innerHTML += `<option value="${dist.iddistrito}">${dist.distrito}</option>`
                })
            })

            distritoC.addEventListener("change", async () => {
                const iddistrito = distritoC.value
                if (!iddistrito) return

                const response = await fetch(`http://yonda1.test/personas/sucursales`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({iddistrito})
                })
                const data = await response.json()

                sucursalC.innerHTML  = "<option value=''>Seleccionar Sucursal</option>"
                areaC.innerHTML = "<option value=''>Seleccionar Área</option>"
                cargoC.innerHTML = "<option value=''>Seleccionar Cargo</option>"

                data.forEach(suc => {
                    sucursalC.innerHTML += `<option value="${suc.idsucursal}">${suc.sucursal}</option>`
                })
            })

            sucursalC.addEventListener("change", async () => {
                const idsucursal = sucursalC.value
                if (!idsucursal) return

                const response = await fetch(`http://yonda1.test/personas/areas`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({idsucursal})
                })
                const data = await response.json()

                areaC.innerHTML = "<option value=''>Seleccionar Área</option>"
                cargoC.innerHTML = "<option value=''>Seleccionar Cargo</option>"

                data.forEach(area => {
                    areaC.innerHTML += `<option value="${area.idarea}">${area.area}</option>`
                })
            })

            areaC.addEventListener("change", async () => {
                const idarea = areaC.value
                if (!idarea) return

                const response = await fetch(`http://yonda1.test/personas/cargos`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({idarea})
                })
                const data = await response.json()

                cargoC.innerHTML = "<option value=''>Seleccionar Cargo</option>"
                data.forEach(cargo => {
                    cargoC.innerHTML += `<option value="${cargo.idcargo}">${cargo.cargo}</option>`
                })
            })


    })
    </script>

    <?= $footer ?>