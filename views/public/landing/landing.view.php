<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?c=LandingController&a=main">Mi Sitio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php?c=LandingController&a=main">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?c=AuthController&a=showLogin">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?c=UserController&a=register">Registrarse</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?c=DashboardController&a=main">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Más Opciones
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?c=RoleController&a=main">Gestionar Roles</a></li>
                            <li><a class="dropdown-item" href="index.php?c=CategoryController&a=main">Gestionar Categorías</a></li>
                            <li><a class="dropdown-item" href="index.php?c=ProductController&a=main">Gestionar Productos</a></li>
                            <li><a class="dropdown-item" href="index.php?c=UserController&a=main">Gestionar Usuarios</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1>Bienvenido a Mi Sitio Web</h1>
            <p class="lead">Explora nuestras funcionalidades o inicia sesión para continuar.</p>
            <a href="index.php?c=AuthController&a=showLogin" class="btn btn-light btn-lg">Iniciar Sesión</a>
            <a href="index.php?c=UserController&a=register" class="btn btn-secondary btn-lg">Registrarse</a>
        </div>
    </header>

    <!-- Sección de Información -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Sobre Nosotros</h2>
            <p class="text-center">Descubre las soluciones que ofrecemos para gestionar tu negocio.</p>
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="bi bi-laptop fs-1 text-primary"></i>
                    <h3>Diseño Responsivo</h3>
                    <p>Tu sitio web se verá increíble en cualquier dispositivo.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-speedometer2 fs-1 text-success"></i>
                    <h3>Rápido y Optimizado</h3>
                    <p>Carga rápida y optimización para motores de búsqueda.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-heart-fill fs-1 text-danger"></i>
                    <h3>Fácil de Usar</h3>
                    <p>Interfaz amigable para el usuario final.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pie de Página -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2025 Mi Sitio Web. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap Bundle con JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
