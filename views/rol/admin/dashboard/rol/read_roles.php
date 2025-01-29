<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Roles</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Listado de Roles</h1>
    <a href="index.php?c=RoleController&a=create">Crear Nuevo Rol</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= htmlspecialchars($rol->getIdRol()) ?></td>
                    <td><?= htmlspecialchars($rol->getNameRol()) ?></td>
                    <td>
                        <a href="index.php?c=RoleController&a=update&id=<?= htmlspecialchars($rol->getIdRol()) ?>">Editar</a>

                        <a href="#" class="delete-role" data-id="<?= htmlspecialchars($rol->getIdRol()) ?>" data-name="<?= htmlspecialchars($rol->getNameRol()) ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Seleccionar todos los enlaces con la clase "delete-role"
            const deleteLinks = document.querySelectorAll('.delete-role');

            deleteLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault(); // Evitar la redirección inmediata

                    const roleId = this.getAttribute('data-id');
                    const roleName = this.getAttribute('data-name');

                    // Mostrar SweetAlert2
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `¿Deseas eliminar el rol "${roleName}"?`,
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
                                text: `Esta acción no se puede deshacer. ¿Estás completamente seguro?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Eliminar definitivamente',
                                cancelButtonText: 'Cancelar'
                            }).then((secondResult) => {
                                if (secondResult.isConfirmed) {
                                    // Redirigir a la acción de eliminación
                                    window.location.href = `index.php?c=RoleController&a=delete&id=${roleId}`;
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
