<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rol</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Crear Nuevo Rol</h1>
    <form action="?c=RoleController&a=create" method="POST">
        <label for="name">Nombre del Rol:</label>
        <input type="text" id="name" name="name_rol" required>
        <button type="submit">Guardar</button>
    </form>
    <a href="read_roles.php">Volver al listado</a>
</body>
</html>
