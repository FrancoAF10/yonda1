<?= $header ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pc-container">
        

        <div class="content-wrapper p-4">
            <div class="container">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Registro de Sucursal</h5>
                    </div>
                    <div class="card-body">
                        <!-- Formulario -->
                        <form class="row g-3 needs-validation" novalidate>
                            <!-- RUC -->
                            <div class="col-md-6">
                                <label for="ruc" class="form-label">RUC</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="ruc" 
                                    name="ruc" 
                                    pattern="[0-9]{11}" 
                                    required
                                >
                                <div class="invalid-feedback">
                                    El RUC debe tener exactamente 11 dígitos numéricos.
                                </div>
                            </div>

                            <!-- Sucursal -->
                            <div class="col-md-6">
                                <label for="sucursal" class="form-label">Sucursal</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="sucursal" 
                                    name="sucursal" 
                                    required
                                >
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre de la sucursal.
                                </div>
                            </div>

                            <!-- Ubicación -->
                            <div class="col-md-6">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="ubicacion" 
                                    name="ubicacion" 
                                    required
                                >
                                <div class="invalid-feedback">
                                    La ubicación es obligatoria.
                                </div>
                            </div>

                            <!-- Actividad Económica -->
                            <div class="col-md-6">
                                <label for="actividad" class="form-label">Actividad Económica</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="actividad" 
                                    name="actividad" 
                                    required
                                >
                                <div class="invalid-feedback">
                                    Por favor indique la actividad económica.
                                </div>
                            </div>

                            <!-- Botón -->
                            <div class="col-12">
                                <button class="btn btn-success" type="submit">Guardar</button>
                                <button class="btn btn-secondary" type="reset">Limpiar</button>
                            </div>
                        </form>
                        <!-- /Formulario -->
                    </div>
                </div>
            </div>
        </div>

        <?= $footer ?>
    </div>
    

    <!-- Script de validación Bootstrap -->
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
