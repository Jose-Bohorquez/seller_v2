<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro de Usuario</title>
    <!-- Cargar SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php 
// Detectar mensajes en la URL, ej: ?m=dupEmail
if (isset($_GET['m'])): 
?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let msg = "<?php echo $_GET['m']; ?>";

        switch (msg) {
            case 'dupEmail':
                Swal.fire({
                    icon: 'warning',
                    title: 'Correo duplicado',
                    text: 'Este correo ya está registrado. Usa uno diferente.',
                    confirmButtonText: 'OK'
                });
                break;
            case 'dupId':
                Swal.fire({
                    icon: 'warning',
                    title: 'Identificación duplicada',
                    text: 'El número de documento ya está registrado.',
                    confirmButtonText: 'OK'
                });
                break;
            case 'dupCel':
                Swal.fire({
                    icon: 'warning',
                    title: 'Teléfono duplicado',
                    text: 'Este número de teléfono ya existe en nuestra base de datos.',
                    confirmButtonText: 'OK'
                });
                break;
            case 'dupOther':
                Swal.fire({
                    icon: 'warning',
                    title: 'Registro duplicado',
                    text: 'Alguno de los datos ingresados ya existe en el sistema.',
                    confirmButtonText: 'OK'
                });
                break;
            case 'error':
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al registrar el usuario. Intenta nuevamente.',
                    confirmButtonText: 'OK'
                });
                break;
        }
    });
    </script>
<?php 
endif;
?>

<h1>Registro de Usuario</h1>
<form action="index.php?c=UserController&a=register" method="POST">
    <!-- Campos del formulario -->
    <label for="name">Nombre:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="lastname">Apellidos:</label><br>
    <input type="text" id="lastname" name="lastname" required><br><br>

    <label for="id_number">Número de Identificación:</label><br>
    <input type="text" id="id_number" name="id_number" required><br><br>

    <label for="cel">Teléfono:</label><br>
    <input type="text" id="cel" name="cel"><br><br>

    <label for="email">Correo Electrónico:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="pass">Contraseña:</label><br>
    <input type="password" id="pass" name="pass" required><br><br>

    <label for="image_profile">Imagen de Perfil (URL):</label><br>
    <input type="text" id="image_profile" name="image_profile"><br><br>

    <button type="submit">Registrar</button>
</form>

</body>
</html>
