<?php

    session_start();

    require_once("models/Database.php");

    /**
     * Manejo del tiempo de inactividad de la sesión.
     * Se define 5 minutos = 300 segundos.
     */
    $inactivityLimit = 300; // 5 minutos

        if (isset($_SESSION['last_activity'])) {
            $elapsedTime = time() - $_SESSION['last_activity'];

            if ($elapsedTime > $inactivityLimit) {
                // --- La sesión ha expirado por inactividad ---
                
                // 1) Si hay un carrito activo, revertir el stock
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    require_once 'controllers/ShoppingCartController.php';
                    $cartController = new ShoppingCartController();
                    $cartController->revertStockAndCleanCart();
                }

                // 2) Destruir la sesión
                session_unset();
                session_destroy();

                // 3) Redirigir con mensaje
                header('Location: index.php?c=AuthController&a=showLogin&m=sessionExpired');
                exit;
            }
        }

        // Actualizar la última actividad de la sesión
        $_SESSION['last_activity'] = time();

        /**
         * Salida por buffer (ob_start),
         * requerimos Database y luego
         * enrutamos la solicitud al controlador/action.
         */

        ob_start();
        require_once "models/Database.php";

        if (!isset($_REQUEST['c'])) {
            // No se especifica controlador => vamos al Landing
            require_once "controllers/LandingController.php";
            $controller = new LandingController();
            $controller->main();

        } else {
            // Tomamos la variable c => indica el controlador
            $controllerName = $_REQUEST['c'];
            require_once "controllers/" . $controllerName . ".php";

            // Instanciamos el controlador
            $controller = new $controllerName;

            // La acción se indica con 'a', si no, 'main'
            $action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'main';

            // Llamamos la acción
            call_user_func(array($controller, $action));
        }

    ob_end_flush();

?>