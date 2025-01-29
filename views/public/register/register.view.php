<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>
</head>
<body>

<h1>Registro de Usuario</h1>
<form action="index.php?c=UserController&a=register" method="POST">
    <label for="name">Nombre:</label> <br>
    <input type="text" id="name" name="name" required> <br> <br>

    <label for="lastname">Apellidos:</label> <br>
    <input type="text" id="lastname" name="lastname" required> <br> <br>

    <label for="id_number">Número de Identificación:</label> <br>
    <input type="text" id="id_number" name="id_number" required> <br> <br>

    <label for="cel">Teléfono:</label> <br>
    <input type="text" id="cel" name="cel"> <br> <br>

    <label for="email">Correo Electrónico:</label> <br>
    <input type="email" id="email" name="email" required> <br> <br>

    <label for="pass">Contraseña:</label> <br>
    <input type="password" id="pass" name="pass" required> <br> <br>

    <label for="image_profile">Imagen de Perfil (URL):</label> <br>
    <input type="text" id="image_profile" name="image_profile"> <br> <br>

    <button type="submit">Registrar</button>
</form>

</body>
</html>
