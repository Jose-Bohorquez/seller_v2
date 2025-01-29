<!-- Page content -->
<section class="full-box page-content">
    <nav class="full-box navbar-info">
        <a href="#" class="float-left show-nav-lateral">
            <i class="fas fa-exchange-alt"></i>
        </a>
        <a href="#" class="btn-exit-system-pu">
            <i class="fas fa-power-off"></i>
        </a>
    </nav>

    <!-- Page header -->
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fab fa-dashcube fa-fw"></i> &nbsp; Perfil
        </h3>
        <p class="text-justify">
            esta vista prermite al usuario acceder a todos sus datos personales y actualizarlos
        </p>
    </div>

<!-- Content -->
<div class="container">

    <section class="container">
<?php if (!$user): ?>
    <p>No se encontraron datos del usuario.</p>
<?php else: ?>
    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Perfil de Usuario</h4>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="<?= htmlspecialchars($user->getImageProfile() ?: 'assets/plantilla/dashboard/assets/avatar/Avatar.png') ?>" 
                     alt="Imagen de Perfil" 
                     class="rounded-circle border" 
                     style="width: 150px; height: 150px; object-fit: cover;">
            </div>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($user->getName() ?? 'N/A') ?></p>
            <p><strong>Apellidos:</strong> <?= htmlspecialchars($user->getLastname() ?? 'N/A') ?></p>
            <p><strong>Número de Identificación:</strong> <?= htmlspecialchars($user->getIdNumber() ?? 'N/A') ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($user->getCel() ?? 'N/A') ?></p>
            <p><strong>Correo Electrónico:</strong> <?= htmlspecialchars($user->getEmail() ?? 'N/A') ?></p>
        </div>
        <div class="card-footer text-center">
            <a href="index.php?c=ProfileController&a=editProfile" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar Mis Datos
            </a>
        </div>
    </div>
<?php endif; ?>

</section>


</div>



</section>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Evento para el botón de cerrar sesión
        document.querySelector('.btn-exit-system-pu').addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro de cerrar la sesión?',
                text: "Estás a punto de cerrar la sesión y salir del sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes redirigir o realizar la acción para cerrar sesión
                    window.location = "?c=AuthController&a=logout";
                }
            });
        });
    </script>