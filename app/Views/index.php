<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Yonda & Grupo Huaraca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?= base_url('css/login.css') ?>" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('login/validar') ?>" method="post" autocomplete="off">
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="clave" class="form-label">Contraseña</label>
                            <input type="password" name="clave" id="clave" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center small">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalSolicitar">¿Olvidó su contraseña?</a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal 1: Solicitar código -->
<div class="modal fade" id="modalSolicitar" tabindex="-1">
  <div class="modal-dialog">
    <form id="formSolicitar" action="<?= base_url('login/reset') ?>" method="post">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header bg-secondary text-white">
          <h5 class="modal-title">Recuperar contraseña</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label class="form-label">Usuario</label>
          <input type="text" name="usuario" class="form-control" required>
          <small class="text-muted">Se enviará un código a tu correo y celular registrados.</small>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enviar código</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal 2: Verificar código y cambiar clave -->
<div class="modal fade" id="modalVerificar" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?= base_url('login/cambiarClave') ?>" method="post">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Verificar código</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Código recibido</label>
            <input type="text" name="codigo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="nueva_clave" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Actualizar contraseña</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- SweetAlert2 mensajes flash -->
<?php if (session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: '<?= session()->getFlashdata('error') ?>',
    showConfirmButton: false,
    timer: 2000
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '<?= session()->getFlashdata('success') ?>',
    showConfirmButton: false,
    timer: 2000
});
</script>
<?php endif; ?>

<!-- Script AJAX -->
<script>
document.querySelector('#formSolicitar').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const res = await fetch(this.action, {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.status === 'success') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 2000
            });

            // Cerrar modal 1
            const modal1 = bootstrap.Modal.getInstance(document.getElementById('modalSolicitar'));
            modal1.hide();

            // Abrir modal 2
            setTimeout(() => {
                new bootstrap.Modal(document.getElementById('modalVerificar')).show();
            }, 500);

        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: data.message,
                showConfirmButton: false,
                timer: 2000
            });
        }
    } catch (err) {
        Swal.fire('Error', 'Hubo un problema en el servidor', 'error');
    }
});
</script>

</body>
</html>
