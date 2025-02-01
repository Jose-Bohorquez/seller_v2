<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imagen del Carrusel</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Editar Imagen del Carrusel</h1>
    <form action="index.php?c=CarouselImageController&a=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_img" value="<?= htmlspecialchars($image->getId()) ?>">
        
        <label for="nombre_img">Título de la Imagen:</label>
        <input type="text" id="nombre_img" name="nombre_img" value="<?= htmlspecialchars($image->getNombre()) ?>" required>
        <br><br>

        <label for="ruta_img">Actualizar Imagen (opcional):</label>
        <input type="file" id="ruta_img" name="ruta_img" accept="image/*">
        <br><br>

        <p>Imagen actual:</p>
        <img src="<?= htmlspecialchars($image->getRuta()) ?>" alt="<?= htmlspecialchars($image->getNombre()) ?>" style="max-width: 300px;">
        <br><br>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="1" <?= $image->getEstado() == 1 ? 'selected' : '' ?>>Activo</option>
            <option value="0" <?= $image->getEstado() == 0 ? 'selected' : '' ?>>Inactivo</option>
        </select>
        <br><br>

        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php?c=CarouselImageController&a=main">Cancelar</a>
</body>
</html>
