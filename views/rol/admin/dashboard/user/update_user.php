<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
</head>
<body>

<h1>Editar Usuario</h1>
<form action="index.php?c=UserController&a=update" method="POST">
    <!-- Campo oculto para el ID del usuario -->
    <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser()) ?>">  

    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->getName()) ?>" required>
    <br>

    <label for="lastname">Apellidos:</label>
    <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($user->getLastname()) ?>" required>
    <br>

    <label for="id_number">Número de Identificación:</label>
    <input type="text" id="id_number" name="id_number" value="<?= htmlspecialchars($user->getIdNumber()) ?>" required>
    <br>

    <label for="cel">Teléfono:</label>
    <input type="text" id="cel" name="cel" value="<?= htmlspecialchars($user->getCel()) ?>">
    <br>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
    <br>

    <label for="pass">Nueva Contraseña:</label>
    <input type="password" id="pass" name="pass" placeholder="Dejar en blanco para mantener la actual">
    <br>
<pre>si se cambia el rol, se debe actualizar la contraseña</pre>

<label for="rol">Rol Actual:</label>
<select id="rol" name="rol" required>
    <option value="">Seleccione un rol</option>
    <?php foreach ($roles as $role): ?>
        <option value="<?= htmlspecialchars($role->getIdRol()) ?>" <?= $user->getRol() == $role->getIdRol() ? 'selected' : '' ?>>
            <?= htmlspecialchars($role->getNameRol()) ?>
        </option>
    <?php endforeach; ?>
</select>


    <br>

    <label for="image_profile">Imagen de Perfil (URL):</label>
    <input type="text" id="image_profile" name="image_profile" value="<?= htmlspecialchars($user->getImageProfile()) ?>">
    <br>

    <button type="submit">Actualizar</button>
</form>

</body>
</html>
