<!-- Page content -->
<section class="full-box page-content">
    <nav class="full-box navbar-info">
        <a href="#" class="float-left show-nav-lateral">
            <i class="fas fa-exchange-alt"></i>
        </a>
        <a href="#" class="btn-exit-system-admin">
            <i class="fas fa-power-off"></i>
        </a>
    </nav>

    <!-- modal cerrar sesion -->

    <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Evento para el botón de cerrar sesión
    document.querySelector('.btn-exit-system-admin').addEventListener('click', function (e) {
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

    <!-- Page header -->
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
        </h3>
        <p class="text-justify">
            esta vista prermite al administrador acceder a todos los datos 
        </p>
    </div>

    <!-- Content -->
    <div class="full-box tile-container">

        <!-- Productos -->
        <a href="index.php?c=ProductController&a=main" class="tile">
            <div class="tile-tittle">Productos</div>
            <div class="tile-icon">
                <i class="fas fa-box fa-fw"></i>
                <p>Gestionar Productos</p>
            </div>
        </a>

    </div>

</section>