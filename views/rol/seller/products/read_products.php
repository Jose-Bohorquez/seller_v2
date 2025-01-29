<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Productos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<h1>Listado de Productos</h1>
<a href="index.php?c=ProductController&a=create">Crear Nuevo Producto</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Descripción Técnica</th>
            <th>Precio Base</th>
            <th>Descuento (%)</th>
            <th>Precio Final</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Imagen (Vista Previa)</th>
            <th>URL de Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product->getId()) ?></td>
                <td><?= htmlspecialchars($product->getName()) ?></td>
                <td><?= htmlspecialchars($product->getDescription()) ?></td>
                <td><?= htmlspecialchars($product->getTechnicalDescription()) ?></td>
                <td><?= number_format($product->getPrice(), 0, ',', '.') ?></td>
                <td><?= number_format($product->getDiscount(), 0, ',', '.') ?>%</td>
                <td><?= number_format($product->getFinalPrice(), 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($product->getAmount()) ?></td>
                <td><?= htmlspecialchars($product->getCategoryName()) ?></td>
                <td>
                    <?php if ($product->getImage()): ?>
                        <img src="<?= htmlspecialchars($product->getImage()) ?>" alt="Imagen del producto">
                    <?php else: ?>
                        Sin imagen
                    <?php endif; ?>
                </td>
                <td>
                    <?= htmlspecialchars($product->getImage() ?? 'Sin URL') ?>
                </td>
                <td>
                    <a href="index.php?c=ProductController&a=update&id=<?= htmlspecialchars($product->getId()) ?>">Editar</a>
                    <a href="index.php?c=ProductController&a=delete&id=<?= htmlspecialchars($product->getId()) ?>" class="delete-product" data-id="<?= htmlspecialchars($product->getId()) ?>" data-name="<?= htmlspecialchars($product->getName()) ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteLinks = document.querySelectorAll('.delete-product');

        deleteLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');

                // Primera confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Deseas eliminar el producto "${productName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Segunda confirmación
                        Swal.fire({
                            title: 'Confirmar eliminación',
                            text: 'Esta acción no se puede deshacer. ¿Estás completamente seguro?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Eliminar definitivamente',
                            cancelButtonText: 'Cancelar'
                        }).then((secondResult) => {
                            if (secondResult.isConfirmed) {
                                window.location.href = `index.php?c=ProductController&a=delete&id=${productId}`;
                            }
                        });
                    }
                });
            });
        });
    });
</script>

</body>
</html>
