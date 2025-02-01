<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Producto</title>
    <script>
        function toggleCategorySelect() {
            const categoryText = document.getElementById('category-text');
            const categorySelectWrapper = document.getElementById('category-select-wrapper');

            // Ocultar el texto y mostrar el select
            categoryText.style.display = 'none';
            categorySelectWrapper.style.display = 'block';
        }
    </script>
</head>
<body>

<h1>Editar Producto</h1>
<form action="index.php?c=ProductController&a=update" method="POST" enctype="multipart/form-data">
    <!-- ID del Producto -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($product->getId()) ?>">  
    <br>
    <br>

    <!-- Nombre -->
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product->getName()) ?>" required> 
    <br>
    <br>

    <!-- Descripción -->
    <label for="description">Descripción:</label>
    <input type="text" id="description" name="description" value="<?= htmlspecialchars($product->getDescription()) ?>"> 
    <br>
    <br>

    <!-- Descripción Técnica -->
    <label for="technical_description">Descripción Técnica:</label>
    <textarea id="technical_description" name="technical_description"><?= htmlspecialchars($product->getTechnicalDescription()) ?></textarea>
    <br>

    <!-- Precio -->
    <label for="price">Precio:</label>
    <input type="number" id="price" name="price" value="<?= htmlspecialchars($product->getPrice()) ?>" step="0.01" min="0" required>    
    <br>
    <br>

    <!-- Cantidad -->
    <label for="amount">Cantidad:</label>
    <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($product->getAmount()) ?>" min="0" required> 
    <br>
    <br>

    <!-- Categoría Actual -->
    <label for="category">Categoría Actual:</label>
    <span id="category-text">
        <?= htmlspecialchars($product->getCategoryName() ?? 'Sin categoría') ?>
        <button type="button" onclick="toggleCategorySelect()">Cambiar Categoría</button>
    </span>

    <!-- Selección de nueva categoría -->
    <div id="category-select-wrapper" style="display: none;">
        <select id="category" name="category">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category->getIdCategory()) ?>" <?= $product->getCategory() == $category->getIdCategory() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->getNameCategory()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>

    <!-- Imagen Actual -->
    <label>Imagen Actual:</label>
    <br>
    <?php if ($product->getImage()): ?>
        <img src="<?= htmlspecialchars($product->getImage()) ?>" alt="Imagen del producto" width="150">
    <?php else: ?>
        <p>Sin imagen</p>
    <?php endif; ?>
    <br>

    <!-- Seleccionar Nueva Imagen -->
    <label for="image">Seleccionar Nueva Imagen:</label>
    <input type="file" id="image" name="image" accept="image/*">
    <br>
    <br>

    <!-- Descuento -->
    <label for="discount">Descuento (%):</label>
    <input type="number" id="discount" name="discount" value="<?= htmlspecialchars($product->getDiscount()) ?>" step="0.01" min="0" max="100">
    <br>
    <br>

    <!-- Precio Final -->
    <label for="final_price">Precio Final:</label>
    <input type="text" id="final_price" name="final_price" value="<?= htmlspecialchars($product->getFinalPrice()) ?>" readonly>
    <br>
    <br>

    <!-- Botón Actualizar -->
    <button type="submit">Actualizar</button>
</form>

</body>
</html>
