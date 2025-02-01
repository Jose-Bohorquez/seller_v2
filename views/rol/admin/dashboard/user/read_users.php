<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Usuarios</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .table-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center">Listado de Usuarios</h1>
    
    <div class="text-end mb-3 d-flex justify-content-between">  
        <a href="index.php?c=UserController&a=create" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Crear Nuevo Usuario
        </a>
        <a href="index.php?c=DashboardController&a=main" class="btn btn-info">
            <i class="fas fa-user-plus"></i> volver al dashboard
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Número de Identificación</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->getIdUser() ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user->getName() ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user->getLastname() ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user->getIdNumber() ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user->getCel() ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user->getEmail() ?? 'N/A') ?></td>
                        <td class="text-center">
                            <span class="badge bg-info"><?= htmlspecialchars($user->getRolName() ?? 'Sin Rol') ?></span>
                        </td>
                        <td class="text-center">
                            <img src="<?= htmlspecialchars($user->getImageProfile() ?: 'assets/plantilla/dashboard/assets/avatar/Avatar.png') ?>" 
                                 onerror="this.onerror=null; this.src='assets/plantilla/dashboard/assets/avatar/Avatar.png';" 
                                 class="table-img" alt="Imagen de Perfil">
                        </td>
                        <td class="text-center">
                            <a href="index.php?c=UserController&a=update&id=<?= htmlspecialchars($user->getIdUser()) ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> EDITAR
                            </a>
                            <button class="btn btn-danger btn-sm delete-user" 
                                    data-id="<?= htmlspecialchars($user->getIdUser()) ?>" 
                                    data-name="<?= htmlspecialchars($user->getName() ?? 'Usuario') ?>">
                                <i class="fas fa-trash"></i>ELIMINAR
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap y SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-user').forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const userId = this.dataset.id;
            const userName = this.dataset.name;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Deseas eliminar al usuario "${userName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Confirmar eliminación',
                        text: 'Esta acción no se puede deshacer. ¿Estás completamente seguro?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Eliminar definitivamente',
                        cancelButtonText: 'Cancelar'
                    }).then(secondResult => {
                        if (secondResult.isConfirmed) {
                            window.location.href = `index.php?c=UserController&a=delete&id=${userId}`;
                        }
                    });
                }
            });
        });
    });
</script>

</body>
</html>
