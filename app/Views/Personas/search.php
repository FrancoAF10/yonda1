<?= $header ?>
<div class="pc-container my-2">
    <div class="pc-content">
        <div class="row mb-3">
            <div class="col-12">
                <label for="dni" class="form-label">Buscar Por DNI</label>
                <small class="d-none" id="searching">Por favor espere ....</small>
            </div>

            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="numdoc" id="numdoc" class="form-control" maxlength="12">
                    <button type="button" class="btn btn-outline-success" id="buscar-numdoc">Buscar</button>
                    <button type="button" class="btn btn-outline-secondary" id="copiar-numdoc" title="Copiar DNI">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <input type="hidden" name="idpersona" id="idpersona">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="persona" name="persona" required>
                    <label for="persona">Persona</label>
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-end">
                <a href="<?= base_url('personas/crear') ?>" id="generarPersona" class="btn btn-primary me-2" >Registrar Persona</a>
                <a href="#" id="generarContrato" class="btn btn-primary disabled" aria-disabled="true">Generar Contrato</a>
            </div>
        </div>
        <small id="mensaje-info" class="text-danger fw-bold mt-2 d-block"></small>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const btnBuscar = document.querySelector("#buscar-numdoc");
    const btnCopiar = document.querySelector("#copiar-numdoc");
    const numDoc = document.querySelector("#numdoc");
    const persona = document.querySelector("#persona");
    const idpersona = document.querySelector("#idpersona");
    const buscando = document.querySelector("#searching");
    const btnContrato = document.querySelector("#generarContrato");
    const btnPersona = document.querySelector("#generarPersona");
    const mensajeInfo = document.querySelector("#mensaje-info");

    function limpiarMensaje() {
        mensajeInfo.textContent = "";
        mensajeInfo.classList.remove("text-danger", "text-success");
    }

    async function buscarAPI() {
        if (!numDoc.value) {
            alert('Escriba el Número de documento');
            return;
        }

        buscando.classList.remove("d-none");

        try {
            const response = await fetch(`http://yonda1.test/api/personas/buscarnumdocpersonas/${numDoc.value}`, {
                method: 'GET',
                headers: { 'Content-type': 'application/json' }
            });

            if (!response.ok) throw new Error('Error en la solicitud');

            const data = await response.json();
            buscando.classList.add("d-none");
            
            if (data.success) {
                persona.value = `${data.apepaterno} ${data.apematerno} ${data.nombres}`;
                idpersona.value = data.idpersona ?? '';
                btnContrato.href = `<?= base_url('contratos/nuevocontrato') ?>/${data.idpersona}`;
                btnPersona.classList.add('disabled');
                btnContrato.classList.remove('disabled');
                limpiarMensaje();
            } else {
                persona.value = '';
                idpersona.value = '';
                btnContrato.href = '#';
                btnContrato.classList.add('disabled');
                btnPersona.classList.remove('disabled');
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

    // Copiar en portapapeles (compatible con HTTP)
    btnCopiar.addEventListener("click", () => {
        if (!numDoc.value) {
            alert("No hay Número de documento para copiar.");
            return;
        }

        try {
            const tempInput = document.createElement("textarea");
            tempInput.value = numDoc.value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            limpiarMensaje();
            mensajeInfo.textContent = "Número de documento copiado al portapapeles.";
            mensajeInfo.classList.add("text-success");
            setTimeout(() => limpiarMensaje(), 2000);
        } catch (err) {
            limpiarMensaje();
            mensajeInfo.textContent = "No se pudo copiar el Número de documento.";
            mensajeInfo.classList.add("text-danger");
        }
    });
});
</script>
<?= $footer ?>
