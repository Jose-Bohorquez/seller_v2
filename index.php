<?php

    session_start();

    // Manejo del tiempo de inactividad de la sesión
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
        // Si han pasado más de 10 minutos, destruir la sesión
        session_unset();
        session_destroy();
        header('Location: index.php?c=AuthController&a=showLogin&m=sessionExpired');
        exit;
    }

    // Actualizar la última actividad de la sesión
    $_SESSION['last_activity'] = time();

    ob_start();

    require_once "models/Database.php";

    if (!isset($_REQUEST['c'])) {
        require_once "controllers/LandingController.php";

        $controller = new LandingController;
        $controller->main();
    } else {
        $controller = $_REQUEST['c'];

        require_once "controllers/" . $controller . ".php";

        $controller = new $controller;
        $action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'main';

        call_user_func(array($controller, $action));
    }

    ob_end_flush();
    
?>
