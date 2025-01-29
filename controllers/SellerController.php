<?php

    class SellerController
    {
        public function main()
        {
            // Verificar si la sesión está iniciada
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_rol'])) {
                // Si no hay sesión, redirigir al landing con mensaje de error
                header("Location: index.php?c=LandingController&a=main&m=noSession");
                exit;
            }

            // Validar si el usuario tiene el rol de Seller (3)
            if ($_SESSION['user_rol'] != 3) {
                // Si el rol no es 3, redirigir con mensaje de acceso denegado
                header("Location: index.php?c=LandingController&a=main&m=unauthorized");
                exit;
            }

            // Cargar las vistas del Seller
            require_once("views/rol/seller/modules/1head.php");
            require_once("views/rol/seller/modules/2nav_lat.php");
            require_once("views/rol/seller/modules/3contenido.php");
            require_once("views/rol/seller/modules/4footer.php");
        }
    }

?>
