<?= $header ?>
<body>
  <div class="container my-4">

    
<div class="pc-container my-2">
  <div class="pc-content">
  
      <h1 class="mb-4 text-center">Dashboard RR.HH.</h1>

  

    <!-- graficos de informacion de la empresa  -->


    <!-- Main content -->
    <main class="pt-5 mt-4">
      <!-- KPI Cards -->
      <section class="row g-4 mb-5" aria-label="Indicadores clave de desempeño">
        <article class="col-12 col-md-6 col-xl-3">
          <div class="kpi-card p-4 text-center">
            <div class="kpi-value" id="totalEmployees">125</div>
            <div class="kpi-label">Total de empleados</div>
          </div>
        </article>
        <article class="col-12 col-md-6 col-xl-3">
          <div class="kpi-card p-4 text-center">
            <div class="kpi-value" id="activeContracts">98</div>
            <div class="kpi-label">Contratos activos</div>
          </div>
        </article>
        <article class="col-12 col-md-6 col-xl-3">
          <div class="kpi-card p-4 text-center">
            <div class="kpi-value" id="contractsExpiring">12</div>
            <div class="kpi-label">Contratos próximos a vencer</div>
          </div>
        </article>
        <article class="col-12 col-md-6 col-xl-3">
          <div class="kpi-card p-4 text-center">
            <div class="kpi-value" id="monthlyTurnover">4.5<span class="fs-5">%</span></div>
            <div class="kpi-label">Rotación mensual</div>
          </div>
        </article>
      </section>
      <!-- Charts -->
      <section aria-label="Gráficos interactivos">
        <div class="row g-4">
          <div class="col-12 col-lg-6">
            <div class="chart-container">
              <h5 class="mb-3 fw-semibold text-primary">Personas por área</h5>

              <div class="row">
                      <canvas id="personasAreaChart"></canvas>
              </div>


            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="chart-container">
              <h5 class="mb-3 fw-semibold text-rose-600" style="color:#d6336c;">Personas por cargo</h5>

              <div class="row">
                <canvas id="personasCargoChart"></canvas>
              </div>

            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="chart-container">
              <h5 class="mb-3 fw-semibold text-success">Estado de contratos</h5>
              <canvas id="doughnutChartContracts" aria-label="Gráfico circular del estado de contratos" role="img"></canvas>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="chart-container">
              <h5 class="mb-3 fw-semibold text-info">Rotación mensual (altas y bajas)</h5>
              <canvas id="lineChartTurnover" aria-label="Gráfico de líneas de rotación mensual" role="img"></canvas>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- Bootstrap 5 JS Bundle (Popper + Bootstrap) -->


    <!-- fin graficos de informacion de la empresa  -->

    
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->



    <!-- <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Personas por Área</div>
          <div class="card-body chart-container">
            <canvas id="personasAreaChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Personas por Cargo</div>
          <div class="card-body chart-container">
            <canvas id="personasCargoChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Estado de Contratos</div>
          <div class="card-body chart-container">
            <canvas id="estadoContratosChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Rotación Mensual (Altas y Bajas)</div>
          <div class="card-body chart-container">
            <canvas id="rotacionChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Asistencias y Ausentismos Mensuales</div>
          <div class="card-body chart-container">
            <canvas id="asistenciasChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Antigüedad Promedio por Área (años)</div>
          <div class="card-body chart-container">
            <canvas id="antiguedadChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card">
          <div class="card-header">Permisos y Licencias</div>
          <div class="card-body chart-container">
            <canvas id="permisosChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div> -->

      <script>
    // Datos de ejemplo, reemplaza con datos reales desde tu backend

    // 1. Personas por área





  // Asegúrate de que listaareas tenga los datos correctos
  let listaareas = <?= json_encode($listarareas) ?>;
  console.log('listaareas:', listaareas); // Verifica el contenido en la consola

  // Arrays para los gráficos
  let areas = [];
  let personasPorArea = [];

  // Extraer los datos de cada área
  listaareas.forEach(area => {
    areas.push(area.area); // Nombre del área
    personasPorArea.push(area['Numero de personas']); // Número de personas
  });


  // Crear el gráfico para "Personas por Área"
  var personasAreaChart = new Chart(document.getElementById('personasAreaChart'), {
    type: 'bar',
    data: {
      labels: areas, // Nombres de las áreas
      datasets: [{
        label: 'Número de personas',
        data: personasPorArea, // Datos de personas
        backgroundColor: 'rgba(54, 162, 235, 0.7)'
      }]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true, precision: 0 } }
    }
  });

  // Agregar más gráficos de manera similar, como el de "Personas por Cargo" y otros


    // 2. Personas por cargo
  let listarcargos = <?= json_encode($listarcargos) ?>;

  console.log('listarcargos:', listarcargos); // Verifica el contenido en la consola
  let cargos = [];
  let personasPorCargo = [];

  // Extrae los datos de la base de datos para "Cargos"
  listarcargos.forEach(cargo => {  
    cargos.push(cargo.cargo);
    personasPorCargo.push(cargo['Numero de personas cargos']);
  });

  // Crear el gráfico para "Personas por Cargo"
  new Chart(document.getElementById('personasCargoChart'), {
    type: 'bar',
    data: {
      labels: cargos,
      datasets: [{
        label: 'Número de personas cargos',
        data: personasPorCargo,
        backgroundColor: 'rgba(255, 99, 132, 0.7)'
      }]
    },
    options: {
      indexAxis: 'y', // Tipo de gráfico horizontal
      responsive: true,
      scales: { x: { beginAtZero: true, precision: 0 } }
    }
  });


    // 3. Estado de contratos
    var estadosContratos = ['Activo', 'Próximo a vencer', 'Vencido'];
    var cantidadContratos = [40, 5, 11];

    // 4. Rotación mensual (altas y bajas)
    var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
    var altas = [3, 5, 2, 4, 3, 6];
    var bajas = [1, 2, 3, 1, 2, 1];

    // 5. Asistencias y ausentismos mensuales
    var tiposAsistencia = ['Con goce', 'Sin goce', 'Permiso', 'Inasistencia'];
    var asistencias = [120, 5, 10, 3];

    // 6. Antigüedad promedio por área (años)
    var antiguedadAreas = [4.5, 3.2, 5.1, 2.8, 4.0];

    // 7. Permisos y licencias
    var tiposPermisos = ['Permisos', 'Licencias'];
    var cantidadPermisos = [15, 8];

    // Crear gráficos con Chart.js


    

    // Personas por cargo

    // Estado de contratos
    new Chart(document.getElementById('estadoContratosChart'), {
      type: 'doughnut',
      data: {
        labels: estadosContratos,
        datasets: [{
          data: cantidadContratos,
          backgroundColor: [
            'rgba(75, 192, 192, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(255, 99, 132, 0.7)'
          ]
        }]
      },
      options: { responsive: true }
    });

    // Rotación mensual
    new Chart(document.getElementById('rotacionChart'), {
      type: 'line',
      data: {
        labels: meses,
        datasets: [
          {
            label: 'Altas',
            data: altas,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.3)',
            fill: true,
            tension: 0.3
          },
          {
            label: 'Bajas',
            data: bajas,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.3)',
            fill: true,
            tension: 0.3
          }
        ]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true, precision: 0 } }
      }
    });

    // Asistencias y ausentismos
    new Chart(document.getElementById('asistenciasChart'), {
      type: 'bar',
      data: {
        labels: tiposAsistencia,
        datasets: [{
          label: 'Cantidad',
          data: asistencias,
          backgroundColor: [
            'rgba(75, 192, 192, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 205, 86, 0.7)',
            'rgba(255, 99, 132, 0.7)'
          ]
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true, precision: 0 } }
      }
    });

    // Antigüedad promedio por área
    new Chart(document.getElementById('antiguedadChart'), {
      type: 'bar',
      data: {
        labels: areas,
        datasets: [{
          label: 'Antigüedad promedio (años)',
          data: antiguedadAreas,
          backgroundColor: 'rgba(153, 102, 255, 0.7)'
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });

    // Permisos y licencias
    new Chart(document.getElementById('permisosChart'), {
      type: 'pie',
      data: {
        labels: tiposPermisos,
        datasets: [{
          data: cantidadPermisos,
          backgroundColor: [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)'
          ]
        }]
      },
      options: { responsive: true }
    });
  </script>


<?= $footer ?>