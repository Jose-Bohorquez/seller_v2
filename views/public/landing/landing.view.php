<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi E-Commerce</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .card.product-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card.product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card.product-card img {
        object-fit: cover;
        height: 150px;
    }

    .card.product-card .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 0.75rem;
        padding: 5px 10px;
    }

    .card-body {
        padding: 10px;
    }

    .card-title {
        font-size: 0.9rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
</style>




</head>

<body data-bs-spy="scroll" data-bs-target="#navbarNav">

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo o Nombre del sitio -->
            <a class="navbar-brand" href="index.php">Mi E-Commerce</a>

            <!-- Botón para dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del Navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#info">Info</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>

                    <!-- Menú desplegable de Categorías -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriasDropdown" role="button"
                            data-bs-toggle="dropdown">
                            Categorías
                        </a>

                    <!-- En la vista -->
                    <ul class="dropdown-menu" aria-labelledby="categoriasDropdown">
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a class="dropdown-item" href="index.php?category=<?= $category->getIdCategory() ?>">
                                <?= htmlspecialchars($category->getNameCategory()) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    </li>
                </ul>

                <!-- Formulario de búsqueda -->
                <form class="d-flex me-3">
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-light" type="submit">🔍</button>
                </form>

                <!-- Sección de Usuario -->
                <?php if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_name'])): ?>
                <a href="?c=DashboardController&a=main" class="btn btn-primary me-2">Ir al Dashboard</a>
                <a href="?c=AuthController&a=logout" class="btn btn-danger me-2">Cerrar Sesión</a>
                <?php else: ?>
                <a href="?c=AuthController&a=showLogin" class="btn btn-light me-2">Iniciar Sesión</a>
                <a href="?c=UserController&a=register" class="btn btn-secondary me-2">Registrarse</a>
                <?php endif; ?>

                <!-- Botón de Carrito -->
                <a href="#" class="btn btn-warning"><i class="fas fa-shopping-cart"></i> 🛒</a>
            </div>
        </div>
    </nav>



    <!-- Carrusel Dinámico -->
<!-- En la vista -->
<div id="carouselExample" class="carousel slide mt-5" data-bs-ride="carousel">
    <!-- Indicadores -->
    <div class="carousel-indicators">
        <?php foreach ($carouselImages as $index => $image): ?>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="<?= $index ?>"
            class="<?= $index === 0 ? 'active' : '' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach ($carouselImages as $index => $image): ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="3000">
            <img src="<?= htmlspecialchars($image->getRuta()) ?>" class="d-block w-100"
                alt="<?= htmlspecialchars($image->getNombre()) ?>">
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>






<div class="container mt-5">
    <div class="row row-cols-2 row-cols-md-6 g-4" id="product-container">
        <?php foreach ($products as $product): ?>
            <div class="col">

            <div class="card product-card">
    <span class="badge bg-danger">Oferta</span>
    <img src="<?= htmlspecialchars($product->getImage() ?: 'ruta/a/imagen_default.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($product->getName()) ?>">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product->getName()) ?></h5>
        <!-- Precio original tachado -->
        <p class="card-text text-muted">
            <del>Precio Original: <?= htmlspecialchars($product->getPriceFormatted()) ?></del>
        </p>
        <!-- Descuento aplicado -->
        <p class="card-text text-success">
            Descuento: <?= htmlspecialchars($product->getDiscountFormatted())  ?>%
        </p>
        <!-- Precio final destacado -->
        <p class="card-text text-primary">
            <strong>Precio Final: <?= htmlspecialchars($product->getFinalPriceFormatted()) ?></strong>
        </p>
        <!-- Cantidad disponible -->
        <p class="card-text text-muted">Disponibles: <?= htmlspecialchars($product->getAmount()) ?></p>
        <!-- Botón -->
        <button class="btn btn-primary btn-sm">Añadir al carrito</button>
    </div>
</div>
            

            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($products) && $hasMoreProducts): ?>
        <!-- Botón para cargar más productos -->
        <div class="text-center mt-4">
            <button id="load-more-btn" class="btn btn-primary">Mostrar más</button>
        </div>
    <?php endif; ?>
</div>





<!-- Script para manejar la carga dinámica -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const productContainer = document.getElementById('product-container');
    const loadMoreBtn = document.getElementById('load-more-btn');
    let offset = 12; // Inicialmente mostramos 12 productos

    // Obtener la categoría seleccionada (si existe)
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category') || '';

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            // Construir la URL para la solicitud fetch
            const fetchUrl = `index.php?c=LandingController&a=loadMoreProducts&category=${categoryId}&offset=${offset}`;
            console.log("URL de la solicitud:", fetchUrl); // Registro para depuración

            fetch(fetchUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la solicitud: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Respuesta del servidor:", data); // Registro para depuración

                    if (data.products.length > 0) {
                        // Insertar los nuevos productos en el contenedor
                        data.products.forEach(product => {
                            const productHtml = `
                                <div class="col">
                                    <div class="card product-card">
                                        <span class="badge bg-danger">Oferta</span>
                                        <img src="${product.image}" class="card-img-top" alt="${product.name}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">${product.name}</h5>
                                            <p class="card-text">${product.description}</p>
                                            <p class="card-text text-primary"><strong>Precio: ${product.final_price}</strong></p>
                                            <p class="card-text text-muted">Disponibles: ${product.amount}</p>
                                            <button class="btn btn-primary btn-sm">Añadir al carrito</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            productContainer.insertAdjacentHTML('beforeend', productHtml);
                        });

                        // Incrementar el offset para la próxima solicitud
                        offset += 12;

                        // Si no hay más productos, ocultar el botón
                        if (!data.hasMore) {
                            loadMoreBtn.style.display = 'none';
                        }
                    } else {
                        // Si no hay productos nuevos, ocultar el botón
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(error => console.error("Error al cargar más productos:", error));
        });
    }
});

</script>

<!-- Otros scripts y contenido -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreBtn = document.getElementById('load-more-btn');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function () {
                console.log("Botón 'Mostrar más' presionado");
                // Aquí continúa la lógica de carga de productos
            });
        }
    });
</script>








    <!-- Información -->
    <section id="info" class="bg-light py-5">
        <div class="container text-center">
            <h2>Sobre Nosotros</h2>
            <p>Ofrecemos productos de calidad con el mejor servicio al cliente.</p>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-5">
        <div class="container text-center">
            <h2>Contacto</h2>
            <p>Email: josejbohorquezd@gmail.com | Teléfono: +57 3178773186</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Mi E-Commerce. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>