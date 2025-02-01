<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Imagen al Carrusel</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Agregar Imagen al Carrusel</h1>
    <form action="index.php?c=CarouselImageController&a=create" method="POST" enctype="multipart/form-data">
        <label for="nombre_img">Título de la Imagen:</label>
        <input type="text" id="nombre_img" name="nombre_img" required>
        <br><br>
        <label for="ruta_img">Seleccionar Imagen:</label>
        <input type="file" id="ruta_img" name="ruta_img" accept="image/*" required>
        <br><br>
        <button type="submit">Guardar</button>
    </form>
    <a href="index.php?c=CarouselImageController&a=main">Volver al listado</a>
</body>
</html>
