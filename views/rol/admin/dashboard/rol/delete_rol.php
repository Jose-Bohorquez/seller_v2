<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Rol</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Eliminar Rol</h1>
    <p>¿Estás seguro de eliminar el rol <strong><?= htmlspecialchars($rol->getNameRol()) ?></strong>?</p>
    <form action="index.php?c=RoleController&a=delete" method="POST">
        <input type="hidden" name="id_rol" value="<?= htmlspecialchars($rol->getIdRol()) ?>">
        <button type="submit">Eliminar</button>
        <a href="index.php?c=RoleController&a=main">Cancelar</a>
    </form>
</body>
</html>
