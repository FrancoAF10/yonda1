<?= $header ?>

    <title>Control de Pagos Mensuales</title>
    

<div class="pc-container my-2">
<div class="pc-content">
<body>
    <div class="container">
        <div class="header">
            <h1>Control de Pagos Mensuales</h1>
            <p>Octubre 2023 - Estado actual de pagos</p>
        </div>

        <div class="filters">
            <div class="search-box">
                <input type="text" placeholder="Buscar persona..." id="searchInput">
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="paid">Pagados</button>
                <button class="filter-btn" data-filter="pending">Pendientes</button>
            </div>
        </div>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">8</div>
                <div class="stat-label">Total Personas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">3</div>
                <div class="stat-label">Pagados</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">5</div>
                <div class="stat-label">Pendientes</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">$12,500</div>
                <div class="stat-label">Total Pagado</div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Persona</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Fecha de Pago</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Hombre adulto profesional con sonrisa amable&id=avatar1" alt="Retrato de Juan Pérez" class="avatar">
                                <div>
                                    <div class="person-name">Juan Pérez</div>
                                    <div class="person-id">ID: 001</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-paid">Pagado</span></td>
                        <td class="amount">$1,500.00</td>
                        <td class="date">15/10/2023</td>
                        <td>Pago completado</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Mujer profesional con cabello castaño&id=avatar2" alt="Retrato de María López" class="avatar">
                                <div>
                                    <div class="person-name">María López</div>
                                    <div class="person-id">ID: 002</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-pending">Pendiente</span></td>
                        <td class="amount">$2,000.00</td>
                        <td class="date">-</td>
                        <td>Esperando confirmación</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Hombre joven con camisa formal&id=avatar3" alt="Retrato de Carlos García" class="avatar">
                                <div>
                                    <div class="person-name">Carlos García</div>
                                    <div class="person-id">ID: 003</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-pending">Pendiente</span></td>
                        <td class="amount">$1,800.00</td>
                        <td class="date">-</td>
                        <td>En proceso</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Mujer adulta con lentes y sonrisa&id=avatar4" alt="Retrato de Ana Rodríguez" class="avatar">
                                <div>
                                    <div class="person-name">Ana Rodríguez</div>
                                    <div class="person-id">ID: 004</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-paid">Pagado</span></td>
                        <td class="amount">$2,200.00</td>
                        <td class="date">12/10/2023</td>
                        <td>Pago completado</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Hombre maduro con barba&id=avatar5" alt="Retrato de Pedro Martínez" class="avatar">
                                <div>
                                    <div class="person-name">Pedro Martínez</div>
                                    <div class="person-id">ID: 005</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-paid">Pagado</span></td>
                        <td class="amount">$1,900.00</td>
                        <td class="date">18/10/2023</td>
                        <td>Pago completado</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Mujer joven con pelo negro&id=avatar6" alt="Retrato de Laura Sánchez" class="avatar">
                                <div>
                                    <div class="person-name">Laura Sánchez</div>
                                    <div class="person-id">ID: 006</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-pending">Pendiente</span></td>
                        <td class="amount">$2,100.00</td>
                        <td class="date">-</td>
                        <td>Por verificar</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Hombre con sombrero y sonrisa&id=avatar7" alt="Retrato de Miguel Torres" class="avatar">
                                <div>
                                    <div class="person-name">Miguel Torres</div>
                                    <div class="person-id">ID: 007</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-pending">Pendiente</span></td>
                        <td class="amount">$1,700.00</td>
                        <td class="date">-</td>
                        <td>Esperando fondos</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="person-info">
                                <img src="https://placeholder-image-service.onrender.com/image/45x45?prompt=Mujer con pelo rubio y profesional&id=avatar8" alt="Retrato de Elena Gómez" class="avatar">
                                <div>
                                    <div class="person-name">Elena Gómez</div>
                                    <div class="person-id">ID: 008</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status status-pending">Pendiente</span></td>
                        <td class="amount">$2,300.00</td>
                        <td class="date">-</td>
                        <td>Programado para mañana</td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
    </div>
    </div>

    <script>
        // Funcionalidad básica de filtrado y búsqueda
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const tableRows = document.querySelectorAll('tbody tr');
            
            // Filtrado por botones
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    // Actualizar botones activos
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Aplicar filtro
                    tableRows.forEach(row => {
                        const status = row.querySelector('.status').classList.contains('status-paid') ? 'paid' : 'pending';
                        
                        if (filter === 'all' || filter === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
            
            // Búsqueda en tiempo real
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const name = row.querySelector('.person-name').textContent.toLowerCase();
                    const id = row.querySelector('.person-id').textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || id.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
<?= $footer ?>