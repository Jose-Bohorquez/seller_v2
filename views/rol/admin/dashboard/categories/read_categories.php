<h1>Listado de Categorías</h1>
<a href="index.php?c=CategoryController&a=create">Crear Nueva Categoría</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category->getIdCategory()) ?></td>
                <td><?= htmlspecialchars($category->getNameCategory()) ?></td>
                <td><?= htmlspecialchars($category->getDescCategory()) ?></td>
                <td>
                    <a href="index.php?c=CategoryController&a=update&id=<?= htmlspecialchars($category->getIdCategory()) ?>">Editar</a>
                    <a href="index.php?c=CategoryController&a=delete&id=<?= htmlspecialchars($category->getIdCategory()) ?>" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
