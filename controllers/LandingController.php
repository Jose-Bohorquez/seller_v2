<?php 

    class LandingController
    {
            public function main()
        {
            $message = $_GET['m'] ?? null;

            // Cargar la vista principal del landing
            require_once 'views/public/landing/landing.view.php';
        }
    }


?>