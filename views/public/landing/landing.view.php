<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi E-Commerce</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 0px;
            /* Ajusta este valor a la altura exacta de tu navbar */
            margin: 0;
        }

        .navbar {
            margin-bottom: 0;
            /* Evitar márgenes adicionales debajo de la navbar */
        }

        #carouselExample {
            margin-top: 0 !important;
            /* Eliminar cualquier margen superior del carrusel */
        }

        .carousel {
            margin: 0;
            padding: 0;
        }



        /* Estilo general del card */
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

        /* Imagen del producto */
        .card.product-card img {
            object-fit: cover;
            height: 150px;
        }

        /* Estilo de la etiqueta "Oferta" */
        .card.product-card .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.75rem;
            padding: 5px 10px;
            background-color: #dc3545;
            /* Rojo */
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        /* Espaciado interno del card */
        .card-body {
            padding: 10px;
        }

        /* Título del producto */
        .card-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        /* Texto general */
        .card-text {
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        /* Precio original tachado */
        .card-text del {
            font-size: 0.8rem;
            color: #b0b0b0;
            /* Gris */
        }

        /* Descuento */
        .card-text.text-success {
            font-size: 0.9rem;
            color: #28a745;
            /* Verde */
            font-weight: bold;
        }

        /* Precio final */
        .card-text.text-primary {
            font-size: 1.1rem;
            color: #007bff;
            /* Azul */
            font-weight: bold;
        }

        /* Botón */
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
    <?php 
        // Verificamos el rol
        $rol = $_SESSION['user_rol'] ?? null; 
    ?>
    
    <?php if (in_array($rol, [1, 2, 3])): ?>
        <!-- Botón: Ir al Dashboard (usa goDashboard para redirigir según rol) -->
        <a href="?c=AuthController&a=goDashboard" class="btn btn-primary btn-sm me-2">Ir al Dashboard</a>
    <?php elseif ($rol == 4): ?>
        <!-- Botón: Mi Perfil (o la ruta que uses para mostrarlo) -->
        <a href="?c=ProfileController&a=main" class="btn btn-primary btn-sm me-2">Mi Perfil</a>
    <?php endif; ?>

    <!-- Botón para Cerrar Sesión (igual para todos los roles) -->
    <a href="?c=AuthController&a=logout" class="btn btn-danger btn-sm me-2">Cerrar Sesión</a>
<?php else: ?>
    <!-- Si NO está logueado, mostramos Login y Registro -->
    <a href="?c=AuthController&a=showLogin" class="btn btn-sm btn-light me-2">Iniciar Sesión</a>
    <a href="?c=UserController&a=register" class="btn btn-sm btn-secondary me-2">Registrarse</a>
<?php endif; ?>


                <!-- Botón de Carrito -->
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fas fa-shopping-cart"></i>
                    🛒
                </button>

            </div>
        </div>
    </nav>

    <!-- Modal Carrito  03 feb 2025-->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tu Carrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <table class="table" id="cart-items-table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                    <hr>
                    <h5 class="text-end">Total: <span id="cart-total">0</span></h5>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Seguir comprando</button>
                    <button class="btn btn-primary">Finalizar Compra</button>
                    <!-- O un link a la pasarela de pago, etc. -->
                </div>
            </div>
        </div>
    </div>

    <!-- Carrusel Dinámico -->
    <!-- En la vista -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
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
                    <img src="<?= htmlspecialchars($product->getImage() ?: 'ruta/a/imagen_default.jpg') ?>"
                        class="card-img-top" alt="<?= htmlspecialchars($product->getName()) ?>">
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
                        <button class="btn btn-primary btn-sm add-to-cart-btn"
                            data-product-id="<?= $product->getId(); ?>">
                            Añadir al carrito
                        </button>

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

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para manejar la carga dinámica de productos -->
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
            console.log("URL de la solicitud:", fetchUrl);

            fetch(fetchUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la solicitud: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Respuesta del servidor:", data);

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
                                            <p class="card-text text-primary">
                                                <strong>Precio: ${product.final_price}</strong>
                                            </p>
                                            <p class="card-text text-muted">Disponibles: ${product.amount}</p>
                                            <!-- Aquí podrías añadir un botón "add-to-cart-btn" dinámico si quieres 
                                                 que los productos cargados también se puedan agregar al carrito. -->
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

<!-- Otros scripts y contenido (registrar el click "Mostrar más") -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            console.log("Botón 'Mostrar más' presionado");
            // Aquí ya se está manejando la lógica en el script anterior
        });
    }
});
</script>

<!-- Script del carrito: AGREGAR al carrito con SweetAlert2 -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            fetch('index.php?c=ShoppingCartController&a=addToCart', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Respuesta addToCart:", data);
                if (data.success) {
                    // SweetAlert2 para éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Carrito',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Si quieres recargar la página para refrescar stock, lo haces aquí:
                        window.location.reload();
                    });
                } else {
                    // SweetAlert2 para aviso
                    Swal.fire({
                        icon: 'info',
                        title: 'Aviso',
                        text: data.message,
                        confirmButtonText: 'Entendido'
                    });
                }
            })
            .catch(err => {
                console.error('Error al agregar al carrito:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al agregar el producto.',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
});
</script>

<!-- Script para manejar el MODAL del Carrito: listar, actualizar, eliminar -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartModal = document.getElementById('cartModal');

    // Al abrir el modal, cargamos los items del carrito
    cartModal.addEventListener('show.bs.modal', function () {
        refreshCartUI();
    });

    // Función para refrescar la tabla del carrito
    function refreshCartUI() {
        fetch('index.php?c=ShoppingCartController&a=getCartItems')
            .then(res => res.json())
            .then(data => {
                console.log("Respuesta getCartItems:", data);

                if (!data.success) {
                    // Si no está logueado o hay algún error:
                    document.querySelector('#cart-items-table tbody').innerHTML =
                        `<tr><td colspan="6">${data.message}</td></tr>`;
                    document.getElementById('cart-total').innerText = '0';
                    return;
                }

                const cartItems = data.cartItems;
                let tbodyHtml = '';
                let total = data.total || 0;

                cartItems.forEach(item => {
                    const subtotal = item.price * item.quantity;
                    tbodyHtml += `
                      <tr>
                        <td>
                          <img src="${item.image}" alt="${item.name}" 
                               style="width: 50px; height: 50px;" />
                        </td>
                        <td>${item.name}</td>
                        <td>$ ${subtotalFormat(item.price)}</td>
                        <td>
                          <input 
                            type="number" 
                            min="1" 
                            class="form-control form-control-sm cart-item-qty" 
                            data-product-id="${item.id}" 
                            value="${item.quantity}" 
                            style="width:60px;"
                          />
                        </td>
                        <td>$ ${subtotalFormat(subtotal)}</td>
                        <td>
                          <button 
                            class="btn btn-danger btn-sm remove-cart-item" 
                            data-product-id="${item.id}"
                          >
                            Eliminar
                          </button>
                        </td>
                      </tr>
                    `;
                });

                document.querySelector('#cart-items-table tbody').innerHTML = tbodyHtml;
                document.getElementById('cart-total').innerText = subtotalFormat(total);

                // Activar listeners en inputs y botones
                addCartListeners();
            })
            .catch(err => console.error("Error al cargar items del carrito:", err));
    }

    function addCartListeners() {
        // Cambiar cantidad
        document.querySelectorAll('.cart-item-qty').forEach(input => {
            input.addEventListener('change', function () {
                const newQty = this.value;
                const productId = this.getAttribute('data-product-id');
                updateCartItem(productId, newQty);
            });
        });

        // Eliminar producto
        document.querySelectorAll('.remove-cart-item').forEach(btn => {
            btn.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                removeCartItem(productId);
            });
        });
    }

    // Actualizar la cantidad (sin recargar ni cerrar modal)
    function updateCartItem(productId, newQty) {
        fetch('index.php?c=ShoppingCartController&a=updateCartItem', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                product_id: productId,
                quantity: newQty
            })
        })
        .then(r => r.json())
        .then(data => {
            console.log("Respuesta updateCartItem:", data);
            if (!data.success) {
                Swal.fire({
                    icon: 'info',
                    title: 'Aviso',
                    text: data.message || 'Error al actualizar la cantidad.'
                });
            } else {
                // Simplemente refrescamos la tabla para ver cambios
                refreshCartUI();
            }
        })
        .catch(err => {
            console.error("Error al actualizar cantidad:", err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al actualizar.'
            });
        });
    }

    // Eliminar un item del carrito
    function removeCartItem(productId) {
        fetch('index.php?c=ShoppingCartController&a=removeCartItem', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                product_id: productId
            })
        })
        .then(r => r.json())
        .then(data => {
            console.log("Respuesta removeCartItem:", data);
            if (!data.success) {
                Swal.fire({
                    icon: 'info',
                    title: 'Aviso',
                    text: data.message || 'Error al eliminar producto.'
                });
            } else {
                // Volvemos a refrescar la tabla
                refreshCartUI();
            }
        })
        .catch(err => {
            console.error("Error al eliminar producto:", err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al eliminar.'
            });
        });
    }

    // Función para formatear números con separador de miles
    function subtotalFormat(val) {
        return new Intl.NumberFormat('es-CO').format(val);
    }
});
</script>

<!-- SweetAlert2 para mensajes de éxito o error -->
<!-- SweetAlert2 para mensajes de éxito o error -->
<?php if (isset($_GET['m'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  let mensaje = "<?php echo $_GET['m']; ?>";

  switch (mensaje) {
    case 'regOk':
      Swal.fire({
        icon: 'success',
        title: '¡Registro Exitoso!',
        text: 'Te has registrado correctamente. ¡Ahora puedes iniciar sesión!',
        confirmButtonText: 'OK'
      });
      break;

    case 'loginOk':
      Swal.fire({
        icon: 'success',
        title: '¡Sesión Iniciada!',
        text: 'Has iniciado sesión exitosamente. ¡Ahora puedes comprar!',
        confirmButtonText: 'OK'
      }).then(() => {
        // Redirección tras pulsar "OK"
        window.location = 'index.php';
      });
      break;

    case 'logoutOk':
      Swal.fire({
        icon: 'success',
        title: '¡Sesión Cerrada!',
        text: 'Has cerrado sesión exitosamente.',
        confirmButtonText: 'OK'
      }).then(() => {
        // Redirección tras pulsar "OK"
        window.location = 'index.php';
      });
      break;

    // Puedes agregar más casos si los necesitas
    // case 'otraCosa':
    //   ...
    //   break;
  }
});
</script>
<?php endif; ?>





</body>

</html>