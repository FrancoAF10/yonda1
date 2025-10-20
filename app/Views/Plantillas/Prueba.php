<?= $header ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pc-container">
      

        <!-- Contenido principal -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Constructor de Contratos</h5>
                            <div>
                                <button class="btn btn-sm btn-primary" id="btn-subir-doc">Subir Plantilla</button>
                                <button class="btn btn-sm btn-success" id="btn-guardar">Guardar Plantilla</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Zona de variables -->
                                <div class="col-md-4 border-end">
                                    <h6>Variables del Contrato</h6>

                                    <div class="input-group mb-3">
                                        <input type="text" id="nueva-variable" class="form-control" placeholder="Ej: NOMBRE">
                                        <button class="btn btn-outline-secondary" id="agregar-variable">Agregar</button>
                                    </div>

                                    <div id="variables-creadas" class="mb-4">
                                        <!-- Variables arrastrables aparecerán aquí -->
                                    </div>

                                    <form id="form-valores">
                                        <!-- Inputs para los valores de las variables -->
                                    </form>
                                </div>

                                <!-- Vista del contrato -->
                                <div class="col-md-8">
                                    <h6>Vista previa del contrato</h6>
                                    <div id="editor-contrato"
                                         class="border bg-light p-3"
                                         contenteditable="true"
                                         style="min-height: 400px;"
                                         aria-label="Editor de Contrato">
                                        <p>Contrato laboral entre EMPRESA y el trabajador [aquí irá el contenido].</p>
                                    </div>
                                    <small class="text-muted">Arrastra las variables al área del contrato donde corresponde.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?= $footer ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("form-valores");
            const editor = document.getElementById("editor-contrato");
            const contenedorVariables = document.getElementById("variables-creadas");

            let plantillaOriginal = editor.innerHTML;

            // Función para actualizar el contrato con los valores de inputs
            function updateContratoVariable() {
                let nuevoHTML = plantillaOriginal;

                const inputs = form.querySelectorAll("input");
                inputs.forEach(input => {
                    const re = new RegExp(`{{${input.name}}}`, "g");
                    nuevoHTML = nuevoHTML.replace(re, input.value || `{{${input.name}}}`);
                });

                editor.innerHTML = nuevoHTML;
            }

            // Agregar nueva variable al sistema
            document.getElementById("agregar-variable").addEventListener("click", () => {
                const nombreVar = document.getElementById("nueva-variable").value.trim().toUpperCase().replace(/\s+/g, "_");
                if (!nombreVar) return alert("Debes ingresar un nombre de variable.");

                if (form.querySelector(`[name="${nombreVar}"]`)) {
                    return alert("Esta variable ya existe.");
                }

                // Crear badge arrastrable
                const variable = document.createElement("div");
                variable.className = "badge bg-secondary me-1 mb-2 draggable-variable";
                variable.textContent = `{{${nombreVar}}}`;
                variable.setAttribute("draggable", "true");
                variable.dataset.nombre = nombreVar;
                contenedorVariables.appendChild(variable);

                // Crear input correspondiente
                const div = document.createElement("div");
                div.classList.add("mb-3");
                div.innerHTML = `
                    <label class="form-label">${nombreVar}</label>
                    <input type="text" class="form-control" name="${nombreVar}" placeholder="Ingresa ${nombreVar}">
                `;
                form.appendChild(div);

                div.querySelector("input").addEventListener("input", function () {
                    updateContratoVariable();
                });

                // Limpiar input para nueva variable
                document.getElementById("nueva-variable").value = "";
            });

            // Drag & drop para las variables
            document.addEventListener("dragstart", e => {
                if (e.target.classList.contains("draggable-variable")) {
                    e.dataTransfer.setData("text/plain", e.target.textContent);
                }
            });

            editor.addEventListener("dragover", e => e.preventDefault());

            editor.addEventListener("drop", e => {
                e.preventDefault();
                const variable = e.dataTransfer.getData("text/plain");

                let range;
                if (document.caretPositionFromPoint) {
                    const pos = document.caretPositionFromPoint(e.clientX, e.clientY);
                    range = document.createRange();
                    range.setStart(pos.offsetNode, pos.offset);
                    range.collapse(true);
                } else if (document.caretRangeFromPoint) {
                    range = document.caretRangeFromPoint(e.clientX, e.clientY);
                }

                if (range) {
                    const textNode = document.createTextNode(variable);
                    range.insertNode(textNode);
                    range.setStartAfter(textNode);
                    range.collapse(true);

                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                }

                // Actualizar plantilla original y reemplazo inmediato
                plantillaOriginal = editor.innerHTML;
                updateContratoVariable();
            });

            // Guardar plantilla (simulación)
            document.getElementById("btn-guardar").addEventListener("click", () => {
                const contenido = editor.innerHTML;
                const campos = Array.from(form.querySelectorAll("input")).map(input => ({
                    name: input.name,
                    value: input.value
                }));

                console.log("Contenido contrato:", contenido);
                console.log("Variables:", campos);

                alert("Plantilla guardada (falta integración backend)");
            });

            // Subir plantilla (solo alert para backend)
            document.getElementById("btn-subir-doc").addEventListener("click", () => {
                alert("Aquí deberías integrar la conversión de PDF o DOCX a HTML (usa phpword/pdfparser).");
            });
        });
    </script>
    
</body>
</html>
