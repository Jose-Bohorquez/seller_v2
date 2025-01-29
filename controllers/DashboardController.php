<?php 

class DashboardController
{
    public function main()
    {
        // Verificar si la sesión ya está iniciada (NO se debe iniciar aquí)
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_rol'])) {
            // Si no hay sesión activa, redirigir al landing con mensaje de error
            header("Location: index.php?c=LandingController&a=main&m=noSession");
            exit;
        }

        // Validar si el usuario tiene permisos de acceso (solo roles 1 y 2)
        if (!in_array($_SESSION['user_rol'], [1, 2])) {
            // Si el rol no es 1 o 2, redirigir con mensaje de acceso denegado
            header("Location: index.php?c=LandingController&a=main&m=unauthorized");
            exit;
        }

        // Si todo está correcto, cargar las vistas del dashboard de administrador
        require_once("views/rol/admin/dashboard/modules/1head.php");
        require_once("views/rol/admin/dashboard/modules/2nav_lat.php");
        require_once("views/rol/admin/dashboard/modules/3contenido.php");
        require_once("views/rol/admin/dashboard/modules/4footer.php");
    }
}
?>
