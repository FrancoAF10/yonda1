<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Interactivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>
    <!-- Contenedor de burbujas dinámicas -->
    <div id="bubbles-container"></div>

    <!-- Formulario de login -->
    <div class="container ">
        <div class="row justify-content-center p-5">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="login-container p-4 p-md-5 my-5">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/images/LogoYondaPeru.jpg') ?>" alt="Logo" class=" mb-3 w-75">
                        <h3 class="mb-3">Iniciar Sesión</h3>
                    </div>
                    <form action="panel.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" class="form-control" placeholder="Ingresa tu usuario">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            
                            <a href="#" class="text-decoration-none" style="color: var(--primary-orange);">¿Olvidé mi contraseña?</a>
                        </div>
                        <button type="submit" class="btn btn-orange w-100 py-2">INGRESAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para generar las burbujas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('bubbles-container');
            const colors = [
                'var(--primary-orange)', 
                'var(--neon-blue)',
                'var(--electric-yellow)',
                'var(--hot-pink)',
                'var(--acid-green)'
            ];

            // Crear 30 burbujas de diferentes tamaños
            for (let i = 0; i < 30; i++) {
                const bubble = document.createElement('div');
                bubble.className = 'bubble';
                
                // Tamaño aleatorio entre 30px y 200px
                const size = Math.random() * 170 + 30;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                
                // Posición inicial aleatoria
                bubble.style.left = `${Math.random() * 100}vw`;
                bubble.style.top = `${Math.random() * 100}vh`;
                
                // Color aleatorio
                bubble.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                
                // Configuración de animación única
                const duration = Math.random() * 30 + 20;
                const delay = Math.random() * 10;
                const floatDistance = Math.random() * 100 + 50;
                
                // Animación personalizada para cada burbuja
                bubble.style.animation = `
                    float ${duration}s ease-in-out ${delay}s infinite,
                    moveX ${duration*1.5}s ease-in-out ${delay}s infinite,
                    moveY ${duration*0.5}s ease-in-out ${delay}s infinite
                `;
                
                // Definir keyframes dinámicos para movimiento horizontal y vertical
                const style = document.createElement('style');
                style.innerHTML = `
                    @keyframes moveX {
                        0%, 100% { transform: translateX(0); }
                        50% { transform: translateX(${floatDistance}px); }
                    }
                    @keyframes moveY {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(${floatDistance}px); }
                    }
                `;
                document.head.appendChild(style);
                
                container.appendChild(bubble);
            }
        });
    </script>
</html>
