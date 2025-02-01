<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
</head>
<body>

<h1>Editar Usuario</h1>
<form action="index.php?c=UserController&a=update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser()) ?>">  
    <br><br>

    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->getName()) ?>" required>
    <br><br>
    
    <label for="lastname">Apellidos:</label>
    <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($user->getLastname()) ?>" required>
    <br><br>

    <label for="id_number">Número de Identificación:</label>
    <input type="text" id="id_number" name="id_number" value="<?= htmlspecialchars($user->getIdNumber()) ?>" required>
    <br><br>

    <label for="cel">Teléfono:</label>
    <input type="text" id="cel" name="cel" value="<?= htmlspecialchars($user->getCel()) ?>">
    <br><br>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
    <br><br>

    <label for="pass">Nueva Contraseña:</label>
    <input type="password" id="pass" name="pass" placeholder="Dejar en blanco para mantener la actual">
    <br><br>




    <label for="rol">Rol:</label>
<select id="rol" name="rol" required>
    <option value="">Seleccione un rol</option>
    <?php foreach ($roles as $role): ?>
        <option value="<?= htmlspecialchars($role->getIdRol()) ?>" 
            <?= $user->getRol() == $role->getIdRol() ? 'selected' : '' ?>>
            <?= htmlspecialchars($role->getNameRol()) ?>
        </option>
    <?php endforeach; ?>
</select>





    <!-- Imagen actual -->
    <label>Imagen Actual:</label><br>
    <?php if ($user->getImageProfile()): ?>
        <img src="<?= htmlspecialchars($user->getImageProfile()) ?>" alt="Imagen de Perfil" width="150"><br>
    <?php else: ?>
        <p>Sin imagen</p>
    <?php endif; ?>
    <br>

    <!-- Nueva imagen -->
    <label for="image_profile">Seleccionar Nueva Imagen:</label>
    <input type="file" id="image_profile" name="image_profile" accept="image/*">
    <br><br>

    <button type="submit">Actualizar</button>
</form>


</body>
</html>
