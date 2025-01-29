<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="index.php?c=AuthController&a=login" method="POST">
        <label for="email">Correo Electrónico:</label><br>
        <input type="email" id="email" name="email" required> <br> <br>
        <br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required> <br> <br>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Credenciales inválidas. Por favor, intente nuevamente.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

<?php if (isset($_GET['m']) && $_GET['m'] === 'sessionExpired'): ?>
    <script>
        Swal.fire({
            title: 'Sesión Expirada',
            text: 'Tu sesión ha expirado por inactividad. Por favor, inicia sesión nuevamente.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>


</body>
</html>
