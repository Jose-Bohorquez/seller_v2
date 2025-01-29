<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rol</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Editar Rol</h1>
    <form action="index.php?c=RoleController&a=update" method="POST">
        <input type="hidden" name="id_rol" value="<?= htmlspecialchars($rol->getIdRol()) ?>">
        <label for="name_rol">Nombre del Rol:</label>
        <input type="text" id="name_rol" name="name_rol" value="<?= htmlspecialchars($rol->getNameRol()) ?>" required>
        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php?c=RoleController&a=main">Cancelar</a>
</body>
</html>
