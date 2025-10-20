<?= $header ?>


<body class="hold-transition sidebar-mini layout-fixed">
  <div class="pc-container">


    <div class="container my-4">
      <div class="content-wrapper">
        <form action="">
          <div class="row g-4">
            <!-- IZQUIERDA: parámetros y tablas -->
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="card-title mb-0">Parámetros - Planilla</h5>
                  <small class="text-muted">Editar parámetros básicos</small>
                </div>

                <div class="card-body">

                  <!-- Sueldo básico -->
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-4 col-form-label">Sueldo Básico (S/.)</label>
                    <div class="col-sm-6">
                      <div class="input-group">
                        <input id="sueldobase" name="sueldobase" type="number" step="0.01" class="form-control" disabled>
                        <button type="button" class="btn btn-outline-primary edit-btn" data-target="#sueldobase" title="Editar">
                          <i class="fas fa-pen"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-sm-2 text-end">
                      <small class="text-muted">valor actual</small>
                    </div>
                  </div>

                  <hr>

                  <!-- Tasa de impuesto: tabla editable -->
                  <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Tasas impuesto (Quinta categoría)</h6>
                    <div>
                      <button type="button" class="btn btn-sm btn-outline-primary edit-table-btn" data-target="#taxTable"><i class="fas fa-pen"></i> Editar tabla</button>
                      <button type="button" class="btn btn-sm btn-outline-success ms-2" id="addTaxRowBtn"><i class="fas fa-plus"></i> Agregar fila</button>
                    </div>
                  </div>

                  <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered" id="taxTable">
                      <thead class="table-light">
                        <tr>
                          <th>Tramo</th>
                          <th>Límite Bajo (UIT)</th>
                          <th>Límite Alto (UIT)</th>
                          <th>Tasa (%)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- filas generadas por JS -->
                      </tbody>
                    </table>
                  </div>

                  <hr>

                  <!-- EPS / EsSalud -->
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-4 col-form-label">EPS / EsSalud (%)</label>
                    <div class="col-sm-6">
                      <div class="input-group">
                        <input id="eps" name="eps" type="number" class="form-control" step="0.01" disabled>
                        <button type="button" class="btn btn-outline-primary edit-btn" data-target="#eps"><i class="fas fa-pen"></i></button>
                      </div>
                    </div>
                    <div class="col-sm-2"><small class="text-muted">porcentaje</small></div>
                  </div>

                  <hr>

                  <!-- Tasas AFP / ONP -->
                  <h6>Tasas AFP / ONP</h6>
                  <div class="row g-2 mb-3">
                    <div class="col-md-6">
                      <label class="form-label">AFP (%)</label>
                      <div class="input-group">
                        <input id="t_afp" name="t_afp" type="number" class="form-control" step="0.01" disabled>
                        <button type="button" class="btn btn-outline-primary edit-btn" data-target="#t_afp"><i class="fas fa-pen"></i></button>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">ONP (%)</label>
                      <div class="input-group">
                        <input id="t_onp" name="t_onp" type="number" class="form-control" step="0.01" disabled>
                        <button type="button" class="btn btn-outline-primary edit-btn" data-target="#t_onp"><i class="fas fa-pen"></i></button>
                      </div>
                    </div>
                  </div>

                  <hr>

                  <!-- Cotización previsional (SPP) con 4 columnas -->
                  <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Cotización previsional (SPP)</h6>
                    <button type="button" class="btn btn-sm btn-outline-primary edit-table-btn" data-target="#cotTable"><i class="fas fa-pen"></i> Editar</button>
                  </div>

                  <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered" id="cotTable">
                      <thead class="table-light">
                        <tr>
                          <th>SPP / AFP</th>
                          <th>Aporte Obligatorio (%)</th>
                          <th>Prima de Seguro (%)</th>
                          <th>Comisión Sobre Flujo (%)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- filas generadas por JS -->
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>

            <!-- DERECHA: resumen y otros parámetros -->
            <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header">
                  <h6 class="mb-0">Resumen / Otros parámetros</h6>
                </div>
                <div class="card-body">

                  <div class="mb-3">
                    <label class="form-label">Asignación familiar (%)</label>
                    <div class="input-group">
                      <input id="asig_familiar" type="number" class="form-control" step="0.01" disabled>
                      <button type="button" class="btn btn-outline-primary edit-btn" data-target="#asig_familiar"><i class="fas fa-pen"></i></button>
                    </div>
                  </div>

                  <!-- Horas extras -->
                  <div class="mb-3">
                    <label class="form-label">Horas extras 25% (%)</label>
                    <div class="input-group">
                      <input id="horas_extra_25" type="number" class="form-control" step="0.01" disabled>
                      <button type="button" class="btn btn-outline-primary edit-btn" data-target="#horas_extra_25"><i class="fas fa-pen"></i></button>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Horas extras 35% (%)</label>
                    <div class="input-group">
                      <input id="horas_extra_35" type="number" class="form-control" step="0.01" disabled>
                      <button type="button" class="btn btn-outline-primary edit-btn" data-target="#horas_extra_35"><i class="fas fa-pen"></i></button>
                    </div>
                  </div>

                  <h6 class="mt-3">Aportes del empleador</h6>
                  <div class="mb-2">
                    <label class="form-label">EsSalud (%)</label>
                    <div class="input-group">
                      <input id="aport_essalud" type="number" class="form-control" step="0.01" disabled>
                      <button type="button" class="btn btn-outline-primary edit-btn" data-target="#aport_essalud"><i class="fas fa-pen"></i></button>
                    </div>
                  </div>

                  <div class="mb-2">
                    <label class="form-label">EPS (%)</label>
                    <div class="input-group">
                      <input id="aport_eps" type="number" class="form-control" step="0.01" disabled>
                      <button type="button" class="btn btn-outline-primary edit-btn" data-target="#aport_eps"><i class="fas fa-pen"></i></button>
                    </div>
                  </div>

                  <div class="mb-2">
                    <label class="form-label">SENATI (%)</label>
                    <div class="input-group">
                      <input id="aport_senati" type="number" class="form-control" step="0.01" disabled>
                      <button type="button" class="btn btn-outline-primary edit-btn" data-target="#aport_senati"><i class="fas fa-pen"></i></button>
                    </div>
                  </div>

                  <hr>
                  <div class="d-grid">
                    <button id="resetBtn" type="button" class="btn btn-outline-danger">Restablecer valores por defecto</button>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- FIN PANEL -->
        </form>
      </div>
    </div>

    
<?= $footer ?>
  </div>


  <!-- Script: lógica edición / persistencia local -->
  <script>
    (function () {
      // Defaults (actualizados; PROFUTURO 1.69%)
      const defaults = {
        sueldobase: 1130,
        eps: 9.0,
        t_afp: 10.0,
        t_onp: 13.0,
        asig_familiar: 9.0,
        horas_extra_25: 25.0,
        horas_extra_35: 35.0,
        aport_essalud: 9.0,
        aport_eps: 2.25,
        aport_senati: 0.2,
        taxTable: [
          { tramo: 1, low: 0, high: 5, tasa: 8.0 },
          { tramo: 2, low: 5, high: 20, tasa: 14.0 },
          { tramo: 3, low: 20, high: 35, tasa: 17.0 },
          { tramo: 4, low: 35, high: 45, tasa: 20.0 }
        ],
        cotTable: [
          { afp: 'HABITAT', aporte: 10.00, prima: 1.35, comision: 1.47 },
          { afp: 'INTEGRA', aporte: 10.00, prima: 1.35, comision: 1.55 },
          { afp: 'PRIMA', aporte: 10.00, prima: 1.35, comision: 1.60 },
          { afp: 'PROFUTURO', aporte: 10.00, prima: 1.35, comision: 1.69 }
        ]
      };

      // helpers
      const $ = (s, ctx = document) => ctx.querySelector(s);
      const $$ = (s, ctx = document) => Array.from(ctx.querySelectorAll(s));

      function deepClone(o) { return JSON.parse(JSON.stringify(o)); }
      function fmt(n, d = 2) { return Number(n).toFixed(d); }

      // load and sanitize state
      function loadState() {
        const raw = localStorage.getItem('payroll_params');
        if (!raw) return deepClone(defaults);
        try {
          const parsed = JSON.parse(raw);

          // normalize cotTable: ensure length 4 with default values where missing
          if (!Array.isArray(parsed.cotTable) || parsed.cotTable.length < 4) {
            parsed.cotTable = deepClone(defaults.cotTable);
          } else {
            parsed.cotTable = parsed.cotTable.map((r, i) => ({
              afp: r.afp ?? defaults.cotTable[i].afp,
              aporte: (typeof r.aporte !== 'undefined') ? Number(r.aporte) : defaults.cotTable[i].aporte,
              prima: (typeof r.prima !== 'undefined') ? Number(r.prima) : defaults.cotTable[i].prima,
              comision: (typeof r.comision !== 'undefined') ? Number(r.comision) : defaults.cotTable[i].comision
            }));
          }

          // normalize taxTable
          if (!Array.isArray(parsed.taxTable) || parsed.taxTable.length === 0) {
            parsed.taxTable = deepClone(defaults.taxTable);
          } else {
            parsed.taxTable = parsed.taxTable.map((r, i) => ({
              tramo: r.tramo ?? (i + 1),
              low: (typeof r.low !== 'undefined') ? Number(r.low) : (defaults.taxTable[i]?.low ?? 0),
              high: (typeof r.high !== 'undefined') ? Number(r.high) : (defaults.taxTable[i]?.high ?? 0),
              tasa: (typeof r.tasa !== 'undefined') ? Number(r.tasa) : (defaults.taxTable[i]?.tasa ?? 0)
            }));
          }

          // other scalars
          parsed.sueldobase = (typeof parsed.sueldobase !== 'undefined') ? Number(parsed.sueldobase) : defaults.sueldobase;
          parsed.eps = (typeof parsed.eps !== 'undefined') ? Number(parsed.eps) : defaults.eps;
          parsed.t_afp = (typeof parsed.t_afp !== 'undefined') ? Number(parsed.t_afp) : defaults.t_afp;
          parsed.t_onp = (typeof parsed.t_onp !== 'undefined') ? Number(parsed.t_onp) : defaults.t_onp;
          parsed.asig_familiar = (typeof parsed.asig_familiar !== 'undefined') ? Number(parsed.asig_familiar) : defaults.asig_familiar;
          parsed.horas_extra_25 = (typeof parsed.horas_extra_25 !== 'undefined') ? Number(parsed.horas_extra_25) : defaults.horas_extra_25;
          parsed.horas_extra_35 = (typeof parsed.horas_extra_35 !== 'undefined') ? Number(parsed.horas_extra_35) : defaults.horas_extra_35;
          parsed.aport_essalud = (typeof parsed.aport_essalud !== 'undefined') ? Number(parsed.aport_essalud) : defaults.aport_essalud;
          parsed.aport_eps = (typeof parsed.aport_eps !== 'undefined') ? Number(parsed.aport_eps) : defaults.aport_eps;
          parsed.aport_senati = (typeof parsed.aport_senati !== 'undefined') ? Number(parsed.aport_senati) : defaults.aport_senati;

          return parsed;
        } catch (e) {
          console.warn('Error parsing payroll_params, using defaults', e);
          return deepClone(defaults);
        }
      }

      function saveState(state) {
        localStorage.setItem('payroll_params', JSON.stringify(state));
      }

      // --- Rendering functions ---
      function render(state) {
        // single inputs
        $('#sueldobase').value = state.sueldobase ?? defaults.sueldobase;
        $('#eps').value = state.eps ?? defaults.eps;
        $('#t_afp').value = state.t_afp ?? defaults.t_afp;
        $('#t_onp').value = state.t_onp ?? defaults.t_onp;
        $('#asig_familiar').value = state.asig_familiar ?? defaults.asig_familiar;
        $('#horas_extra_25').value = state.horas_extra_25 ?? defaults.horas_extra_25;
        $('#horas_extra_35').value = state.horas_extra_35 ?? defaults.horas_extra_35;
        $('#aport_essalud').value = state.aport_essalud ?? defaults.aport_essalud;
        $('#aport_eps').value = state.aport_eps ?? defaults.aport_eps;
        $('#aport_senati').value = state.aport_senati ?? defaults.aport_senati;

        // tax table
        const taxTbody = $('#taxTable tbody');
        taxTbody.innerHTML = '';
        (state.taxTable || defaults.taxTable).forEach(row => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td><input class="form-control form-control-sm tax-tramo" data-name="tramo" value="${row.tramo ?? 0}" disabled></td>
            <td><input class="form-control form-control-sm tax-low" data-name="low" value="${row.low ?? 0}" disabled></td>
            <td><input class="form-control form-control-sm tax-high" data-name="high" value="${row.high ?? 0}" disabled></td>
            <td><input class="form-control form-control-sm tax-tasa" data-name="tasa" value="${row.tasa ?? 0}" disabled></td>
          `;
          taxTbody.appendChild(tr);
        });

        // cot table (with % suffix group)
        const cotTbody = $('#cotTable tbody');
        cotTbody.innerHTML = '';
        (state.cotTable || defaults.cotTable).forEach((row, idx) => {
          const aporteVal = (typeof row.aporte !== 'undefined') ? row.aporte : defaults.cotTable[idx].aporte;
          const primaVal = (typeof row.prima !== 'undefined') ? row.prima : defaults.cotTable[idx].prima;
          const comisionVal = (typeof row.comision !== 'undefined') ? row.comision : defaults.cotTable[idx].comision;
          const afpVal = row.afp ?? defaults.cotTable[idx].afp;

          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td><input class="form-control form-control-sm cot-afp" data-name="afp" value="${afpVal}" disabled></td>

            <td>
              <div class="input-group input-group-sm">
                <input class="form-control form-control-sm cot-aporte" data-name="aporte" value="${fmt(aporteVal)}" disabled>
                <span class="input-group-text">%</span>
              </div>
            </td>

            <td>
              <div class="input-group input-group-sm">
                <input class="form-control form-control-sm cot-prima" data-name="prima" value="${fmt(primaVal)}" disabled>
                <span class="input-group-text">%</span>
              </div>
            </td>

            <td>
              <div class="input-group input-group-sm">
                <input class="form-control form-control-sm cot-comision" data-name="comision" value="${fmt(comisionVal)}" disabled>
                <span class="input-group-text">%</span>
              </div>
            </td>
          `;
          cotTbody.appendChild(tr);
        });
      }

      // --- UI behaviors ---
      function setupEditButtons() {
        $$('.edit-btn').forEach(btn => {
          btn.addEventListener('click', function () {
            const targetSel = this.dataset.target;
            const input = document.querySelector(targetSel);
            if (!input) return;

            if (input.disabled) {
              input.disabled = false;
              input.focus();
              this.classList.remove('btn-outline-primary');
              this.classList.add('btn-success');
              this.innerHTML = '<i class="fas fa-save"></i>';
            } else {
              input.disabled = true;
              this.classList.remove('btn-success');
              this.classList.add('btn-outline-primary');
              this.innerHTML = '<i class="fas fa-pen"></i>';

              // persist change
              const st = loadState();
              st[input.id] = (input.value === '' ? '' : Number(input.value));
              saveState(st);
            }
          });
        });
      }

      function setupEditTableButtons() {
        $$('.edit-table-btn').forEach(btn => {
          btn.addEventListener('click', function () {
            const tbl = document.querySelector(this.dataset.target);
            if (!tbl) return;
            const inputs = tbl.querySelectorAll('input.form-control');
            const anyDisabled = Array.from(inputs).some(i => i.disabled);

            if (anyDisabled) {
              inputs.forEach(i => i.disabled = false);
              this.classList.remove('btn-outline-primary');
              this.classList.add('btn-success');
              this.innerHTML = '<i class="fas fa-save"></i> Guardar';
            } else {
              // save table back to state
              const st = loadState();
              if (tbl.id === 'taxTable') {
                const rows = Array.from(tbl.querySelectorAll('tbody tr'));
                st.taxTable = rows.map(r => ({
                  tramo: Number(r.querySelector('.tax-tramo').value) || 0,
                  low: Number(r.querySelector('.tax-low').value) || 0,
                  high: Number(r.querySelector('.tax-high').value) || 0,
                  tasa: Number(r.querySelector('.tax-tasa').value) || 0
                }));
              } else if (tbl.id === 'cotTable') {
                const rows = Array.from(tbl.querySelectorAll('tbody tr'));
                st.cotTable = rows.map(r => {
                  const afp = r.querySelector('.cot-afp').value || '';
                  const aporte = Number(r.querySelector('.cot-aporte').value) || 0;
                  const prima = Number(r.querySelector('.cot-prima').value) || 0;
                  const comision = Number(r.querySelector('.cot-comision').value) || 0;
                  return { afp, aporte, prima, comision };
                });
              }

              saveState(st);
              inputs.forEach(i => i.disabled = true);
              this.classList.remove('btn-success');
              this.classList.add('btn-outline-primary');
              this.innerHTML = '<i class="fas fa-pen"></i> Editar';

              // re-render normalized values
              render(loadState());
            }
          });
        });
      }

      function setupAddRow() {
        const btn = $('#addTaxRowBtn');
        if (!btn) return;
        btn.addEventListener('click', function () {
          const tbody = $('#taxTable tbody');
          const idx = tbody.querySelectorAll('tr').length + 1;
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td><input class="form-control form-control-sm tax-tramo" data-name="tramo" value="${idx}" disabled></td>
            <td><input class="form-control form-control-sm tax-low" data-name="low" value="0" disabled></td>
            <td><input class="form-control form-control-sm tax-high" data-name="high" value="0" disabled></td>
            <td><input class="form-control form-control-sm tax-tasa" data-name="tasa" value="0" disabled></td>
          `;
          tbody.appendChild(tr);
        });
      }

      function setupReset() {
        const btn = $('#resetBtn');
        if (!btn) return;
        btn.addEventListener('click', function () {
          if (!confirm('Restablecer valores por defecto?')) return;
          localStorage.removeItem('payroll_params');
          render(loadState());
        });
      }

      // Init
      const state = loadState();
      render(state);
      setupEditButtons();
      setupEditTableButtons();
      setupAddRow();
      setupReset();

      // Tip: si ves datos antiguos incompletos en localStorage:
      // abre consola y ejecuta: localStorage.removeItem('payroll_params'); location.reload();
    })();
  </script>
</body>
</html>
