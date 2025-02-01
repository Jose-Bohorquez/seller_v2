<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Nuevo Producto</title>
    <style>
        form {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1 style="text-align: center;">Crear Nuevo Producto</h1>

<form action="index.php?c=ProductController&a=create" method="POST" enctype="multipart/form-data">

    <!-- Nombre del producto -->
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>

    <!-- Descripción -->
    <label for="description">Descripción:</label>
    <input type="text" id="description" name="description">

    <!-- Descripción técnica -->
    <label for="technical_description">Descripción Técnica:</label>
    <textarea id="technical_description" name="technical_description" rows="4"></textarea>

    <!-- Precio -->
    <label for="price">Precio Base (COP):</label>
    <input type="number" id="price" name="price" step="1" min="0" required>

    <!-- Cantidad -->
    <label for="amount">Cantidad:</label>
    <input type="number" id="amount" name="amount" step="1" min="0" required>

    <!-- Categoría -->
    <label for="category">Categoría:</label>
    <select id="category" name="category" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category->getIdCategory()) ?>">
                <?= htmlspecialchars($category->getNameCategory()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Descuento -->
    <label for="discount">Descuento (%):</label>
    <input type="number" id="discount" name="discount" step="1" min="0" max="100" placeholder="Ej: 10">



    <!-- Imagen -->
    <label for="image">Seleccionar Imagen:</label>
    <input type="file" id="image" name="image" accept="image/*" required>

    

    <!-- Botón Guardar -->
    <button type="submit">Guardar</button>
</form>

</body>
</html>
