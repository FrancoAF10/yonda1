 <?= $header ?>

    <div class="pc-container my-2">
    <div class="pc-content">
        <h2>Registro de Trabajador</h2>
        <a href="<?= base_url('personas') ?>">Volver a la lista</a>
        
        <!-- Mostrar mensajes flash -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- 
        PARA GUARDAR:
        1. Construye la interfaz VISTA
        2. Definir un nueva RUTA utilizando "POST" (envía desde un formulario)
        3. Crear un método en el controlador para recibir los datos y enviarlos a la BD
        -->
<form method="POST" action="<?=base_url("personas/registrar")?>">
            <!-- Información Personal -->
    <h4 class="text-center">DATOS PERSONALES</h4>
        <div class="row mb-3">
            <div class="col-12 ">
                <label for="dni" class="form-label">Buscar Por DNI</label>
                <small class="d-none" id="searching"> Por favor espere ....</small>
            </div>

            <div class="col-md-4">
                <div class="input-group">
                <input type="text" name="dni" id="dni" class="form-control" maxlength="8">
                <button type="button" class="btn btn-outline-success" id="buscar-dni">Buscar</button>
                </div>
            </div>
        </div>


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
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="date" class="form-control" id="fechanac" name="fechanac" required>
                    <label for="fechanac">Fecha de Nacimiento</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="genero" name="genero" required>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                    <label for="genero">Género</label>
                </div>
            </div>
            <div class="col-md-4">
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
    <h4 class="text-center mt-4 mb-4">DATOS DE CONTACTO</h4>
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
                        <input type="tel" class="form-control" id="telefono" name="telefono" minlength="9" maxlength="9" pattern="[0-9]{9}" required>
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

        const tipodoc=document.querySelector("#tipodoc")
        const numdoc=document.querySelector("#numdoc")

        departamentos.addEventListener('change',async()=>{
        const iddepartamento=departamentos.value

        if(!iddepartamento){
            provincias.innerHTML=`<option value=''>Seleccione</option>`
            distritos.innerHTML=`<option value=''>Seleccione</option>`
            return
        }

        try{
            const response=await fetch(`<?= base_url()?>provincias/${iddepartamento}`,{
            method:'GET',
            headers:{'Content-Type': 'application/json'}
            })

            if(!response.ok){
            throw new Error('Error en la solicitud al servidor')
            }
            const data = await response.json()
            if(data.length){
                provincias.innerHTML=`<option value=''>Seleccionar Provincia</option>`
                data.forEach(provincia => {
                    provincias.innerHTML+=`<option value='${provincia.idprovincia}'>${provincia.provincia}</option>`
                });
            }
        }catch(error){
            console.error(error)
        }
        })

        provincias.addEventListener('change', async()=>{
        const idprovincia=provincias.value

        if(!idprovincia){
            distritos.innerHTML=`<option value=''>Seleccione</option>`
            return
        }

        try{
            const response=await fetch(`<?= base_url()?>distritos/${idprovincia}`,{
            method:'GET',
            headers:{'Content-Type': 'application/json'}
            })

            if(!response.ok){
            throw new Error('Error en la solicitud al servidor')
            }
            const data = await response.json()
            if(data.length){
                distritos.innerHTML=`<option value=''>Seleccionar Distrito</option>`
                data.forEach(distrito => {
                    distritos.innerHTML+=`<option value='${distrito.iddistrito}'>${distrito.distrito}</option>`
                });
            }
        }catch(error){
            console.error(error)
        }
        })

            tipodoc.addEventListener("change",()=>{
                const tipo=tipodoc.value;
                    switch(tipo){
                        case 'DNI':
                            numdoc.maxLength=8;
                            numdoc.minLength=8;
                            numdoc.pattern='\\d{8}';
                            numdoc.placeholder='Ingrese 8 dígitos';
                            break;
                        case 'CEX':
                            numdoc.maxLength=12;
                            numdoc.minLength=9;
                            numdoc.pattern='[A-Za-z0-9]{9,12}';
                            numdoc.placeholder='Ingrese de 9 a 12 caracteres alfanuméricos';
                            break;
                        case 'PASS':
                            numdoc.maxLength=12;
                            numdoc.minLength=6;
                            numdoc.pattern='[A-Za-z0-9]{6,12}';
                            numdoc.placeholder='Ingrese de 6 a 12 caracteres alfanuméricos';
                            break;
                    }
                    numdoc.value="";
            
            })
            tipodoc.dispatchEvent(new Event('change'));

        const btnBuscar = document.querySelector("#buscar-dni");
        const apepaterno = document.querySelector("#apepaterno");
        const apematerno = document.querySelector("#apematerno");
        const nombres = document.querySelector("#nombres");
        const dni = document.querySelector("#dni");
        const buscando = document.querySelector("#searching");
        const numerodoc=document.querySelector("#numdoc")

        async function buscarAPI() {
                if (!dni.value) {
                alert('Escriba DNI');
                return;
                }

                try {
                buscando.classList.remove("d-none");

                const response = await fetch(`http://yonda1.test/api/personas/buscardni/${dni.value}`, {
                    method: 'GET',
                    headers: { 'Content-type': 'application/json' }
                });

                if (!response.ok) {
                    throw new Error('Error en la solicitud');
                }

                const data = await response.json();
                buscando.classList.add("d-none");

                if (data.success) {
                    apepaterno.value = data.apepaterno;
                    apematerno.value = data.apematerno;
                    nombres.value = data.nombres;
                    numerodoc.value=data.numerodoc;
                } else {
                    apepaterno.value = '';
                    apematerno.value = '';
                    nombres.value = '';
                    numerodoc.value='';

                }

                } catch (error) {
                console.error(error);
                buscando.classList.add("d-none"); // para asegurarte de ocultar el loader también en caso de error
                }
            }

                //buscaria los datos de la persona al dar solamente ENTER
            dni.addEventListener('keydown',(event)=>{
            if(event.key==='Enter'){
                event.preventDefault();
                buscarAPI();
            }
            })

            //buscaria los datos de la persona con presionar el boton de BUSCAR
            btnBuscar.addEventListener("click",buscarAPI)

    })
    </script>

    <?= $footer ?>