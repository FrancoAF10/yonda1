 <?= $header ?>

<div class="pc-container my-2">
    <div class="pc-content">
        <h2>Término de Contrato</h2>
        <a href="<?= base_url('personas') ?>">Volver a la lista</a>
        
        <!-- Mostrar mensajes flash -->

        <!-- 
        PARA GUARDAR:
        1. Construye la interfaz VISTA
        2. Definir un nueva RUTA utilizando "POST" (envía desde un formulario)
        3. Crear un método en el controlador para recibir los datos y enviarlos a la BD
        -->
        <div class="container mt-5">
        <!-- Card con los datos de la persona -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
            <h5 class="card-title text-primary">
            </h5>
            <p class="card-text mb-1"><strong>DNI:</strong> <?= $trabajador['numdoc'] ?></p>
            <p class="card-text mb-1"><strong>Email:</strong> <?= $trabajador['email'] ?></p>
            <p class="card-text mb-1"><strong>Apellidos y Nombres:</strong> <?= $trabajador['apepaterno'] . ' ' . $trabajador['apematerno'] . ' ' . $trabajador['nombres'] ?></p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="card shadow p-4">
            <form action="<?=base_url("/fincontrato/finalizacion")?>" method="POST" enctype="multipart/form-data">
            
            <!-- ID Contrato oculto -->
            <input type="text" name="idcontrato" value="<?= $contrato['idcontrato'] ?>">

            <!-- Motivo -->
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <input type="text" class="form-control" id="motivo" name="motivo" maxlength="150" required>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="255" ></textarea>
            </div>

            <!-- Gravedad -->
            <div class="mb-3">
                <label for="severidad" class="form-label">Gravedad</label>
                <select class="form-select" id="severidad" name="severidad" required>
                <option value="">Seleccione...</option>
                <option value="Ninguna">Ninguna</option>
                <option value="Leve">Leve</option>
                <option value="Moderado">Moderado</option>
                <option value="Grave">Grave</option>
                </select>
            </div>

            <!-- Evidencia -->
            <div class="mb-3">
                <label for="evidencia" class="form-label">Evidencia (opcional)</label>
                <input type="file" class="form-control" id="evidencia" name="evidencia">
            </div>

            <!-- Botón -->
            <div class="d-grid">
                <button type="submit" class="btn btn-danger">Termimar contrato</button>
            </div>

            </form>
        </div>  
        </div>

    </div>
</div>

<?= $footer ?>