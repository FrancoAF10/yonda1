<?= $header ?>

<div class="pc-container">
  <div class="pcoded-content">
    <div class="row g-4">
      
      <!-- Columna izquierda: Áreas -->
      <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold text-primary mb-0">Áreas</h5>
              <div class="d-flex">
                <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#modalArea">
                  <i class="bi bi-plus-lg"></i> Nueva
                </button>
              </div>
            </div>

            <!-- Tablero -->
            <div class="row g-3" id="tablero-areas">
              <div class="col-12">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-light fw-bold text-dark">Administración</div>
                  <div class="card-body">
                    <p class="small mb-1"><strong>Colaboradores:</strong> 1</p>
                    <p class="small mb-0"><strong>Contratados:</strong> 5</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Columna derecha: Cargos -->
      <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold text-primary mb-0">Cargos</h5>
              <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCargo">
                <i class="bi bi-plus-lg"></i> Registrar
              </button>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="cargos-tab" data-bs-toggle="tab" data-bs-target="#cargos" type="button" role="tab">
                  Lista de Cargos
                </button>
              </li>
            </ul>

            <!-- Contenido Tabs -->
            <div class="tab-content">
              <div class="tab-pane fade show active" id="cargos" role="tabpanel">
                <div class="table-responsive">
                  <table id="colaboradoresTable" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                      <tr>
                        <th>#</th>
                        <th>Área</th>
                        <th>Cargo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Administración</td>
                        <td>Finanzas y Estafas</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div><!-- row -->
  </div><!-- pcoded-content -->
</div><!-- pc-container -->

<?= $footer ?>

<!-- Modal Área -->
<div class="modal fade" id="modalArea" tabindex="-1" aria-labelledby="modalAreaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAreaLabel">Crear Nueva Área</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="area" class="form-label">Nombre del Área</label>
            <input type="text" class="form-control" name="area" id="area"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cargo -->
<div class="modal fade" id="modalCargo" tabindex="-1" aria-labelledby="modalCargoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCargoLabel">Registrar Cargo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="areaCargo" class="form-label">Área</label>
            <select id="areaCargo" class="form-select">
              <option selected>Selecciona</option>
              <option value="1">Administración</option>
              <option value="2">Recursos Humanos</option>
              <option value="3">Marketing</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="cargo" class="form-label">Nuevo Cargo</label>
            <input type="text" class="form-control" name="cargo" id="cargo"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
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
