<?= $header ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pc-container">
        

        <div class="container-fluid my-4">
            <div class="content-wrapper">

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="colaboradores-tab" data-bs-toggle="tab"
                            data-bs-target="#colaboradores" type="button" role="tab" aria-controls="colaboradores"
                            aria-selected="true">
                            Colaboradores
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista"
                            type="button" role="tab" aria-controls="lista" aria-selected="false">
                            Documentos
                        </button>
                    </li>
                </ul>

                <div class="tab-content p-3 bg-white shadow-sm rounded-bottom" id="myTabContent">
                    <!-- Pestaña 1 -->
                    <div class="tab-pane fade show active" id="colaboradores" role="tabpanel"
                        aria-labelledby="colaboradores-tab">

                        <!-- Tabla con DataTables -->
                        <div class="table-responsive">
                            <table id="colaboradoresTable" class="table table-bordered table-hover align-middle"
                                style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Número de Documento</th>
                                        <th>Área</th>
                                        <th>Cargo</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="<?= base_url('resumen') ?>">Kelvin Pipa</a></td>
                                        <td>19078530</td>
                                        <td>Administración</td>
                                        <td>Finanzas y Estafas</td>
                                        <td>29-11-2022</td>
                                        <td><span class="badge bg-danger">cesado</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pestaña 2 -->
                    <div class="tab-pane fade" id="lista" role="tabpanel" aria-labelledby="lista-tab">
                        <div class="mt-3">
                            <div class="card shadow-sm">
                                <h5 class="card-header bg-primary text-white">
                                    <i class="bi bi-calendar-event me-2"></i> Septiembre 2025
                                </h5>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <!-- Boleta de Pago -->
                                        <div class="col-md-3 col-6">
                                            <button
                                                class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-file-earmark-text me-2"></i> Boleta de Pago
                                            </button>
                                        </div>

                                        <!-- Plame -->
                                        <div class="col-md-3 col-6">
                                            <button
                                                class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-file-earmark-excel me-2"></i> Plame
                                            </button>
                                        </div>

                                        <!-- T-Registro -->
                                        <div class="col-md-3 col-6">
                                            <button
                                                class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people me-2"></i> T-Registro
                                            </button>
                                        </div>

                                        <!-- AFPnet -->
                                        <div class="col-md-3 col-6">
                                            <button
                                                class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-bank me-2"></i> AFPnet
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

       

            <?= $footer ?>
    </div>

    



    <script>
        $(document).ready(function () {
            $('#colaboradoresTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
            });
        });
    </script>
</body>

</html>