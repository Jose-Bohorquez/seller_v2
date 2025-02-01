<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Nuevo Usuario</title>
</head>
<body>

<h1>Crear Nuevo Usuario</h1>
<form action="index.php?c=UserController&a=create" method="POST" enctype="multipart/form-data">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>
    <br><br>

    <label for="lastname">Apellidos:</label>
    <input type="text" id="lastname" name="lastname" required>
    <br><br>

    <label for="id_number">Número de Identificación:</label>
    <input type="text" id="id_number" name="id_number" required>
    <br><br>

    <label for="cel">Teléfono:</label>
    <input type="text" id="cel" name="cel">
    <br><br>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br><br>

    <label for="pass">Contraseña:</label>
    <input type="password" id="pass" name="pass" required>
    <br><br>

    <label for="rol">Rol:</label>
    <select id="rol" name="rol" required>
        <option value="">Seleccione un rol</option>
        <?php foreach ($roles as $role): ?>
            <option value="<?= htmlspecialchars($role->getIdRol()) ?>">
                <?= htmlspecialchars($role->getNameRol()) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Subida de imagen -->
    <label for="image_profile">Seleccionar Imagen de Perfil:</label>
    <input type="file" id="image_profile" name="image_profile" accept="image/*">
    <br><br>

    <button type="submit">Guardar</button>
</form>


</body>
</html>
