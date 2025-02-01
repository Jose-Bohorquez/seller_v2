<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="container mt-4">
    <h1 class="text-center mb-4">Listado de Imágenes</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="?c=CarouselImageController&a=create" class="btn btn-success">➕ Agregar Imagen</a>
        <a href="?c=DashboardController&a=main" class="btn btn-info">volver al dashboard</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Ruta</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <tr>
                        <td><?= htmlspecialchars($image->getId()) ?></td>
                        <td><?= htmlspecialchars($image->getNombre()) ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($image->getRuta()) ?>" 
                                 alt="<?= htmlspecialchars($image->getNombre()) ?>" 
                                 width="120" class="img-thumbnail">
                        </td>
                        <td><?= htmlspecialchars($image->getRuta()) ?></td>
                        <td>
                            <span class="badge <?= $image->getEstado() == 1 ? 'bg-success' : 'bg-danger' ?>">
                                <?= $image->getEstado() == 1 ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td class="text-center d-flex justify-content-center">
                            <a href="index.php?c=CarouselImageController&a=update&id=<?= htmlspecialchars($image->getId()) ?>" 
                               class="mx-1 btn btn-sm btn-warning btn-sm">✏️ Editar</a>

                            <button class="mx-1 btn btn-sm btn-danger btn-sm delete-banner" 
                                    data-id="<?= htmlspecialchars($image->getId()) ?>"
                                    data-name="<?= htmlspecialchars($image->getNombre()) ?>">
                                🗑️ Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay imágenes registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- SweetAlert2 para confirmación de eliminación -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-banner');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bannerId = this.getAttribute('data-id');
                    const bannerName = this.getAttribute('data-name');

                    Swal.fire({
                        title: "¿Eliminar imagen?",
                        text: `¿Seguro que deseas eliminar "${bannerName}"?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Sí, eliminar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `index.php?c=CarouselImageController&a=delete&id=${bannerId}`;
                        }
                    });
                });
            });
        });
    </script>

</body>
</html>
