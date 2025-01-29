<?php

require_once 'models/UserModel.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $this->userModel = new UserModel($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user->getPass())) {
                // Configurar la sesión
                session_start();
                $_SESSION['user_id'] = $user->getIdUser();
                $_SESSION['user_name'] = $user->getName();
                $_SESSION['user_rol'] = $user->getRol();

                // Redirigir según el rol
                switch ($user->getRol()) {
                    case 1: // Super Admin
                    case 2: // Admin
                        header('Location: index.php?c=DashboardController&a=main');
                        break;
                    case 3: // Seller
                        header('Location: index.php?c=SellerController&a=main');
                        break;
                    case 4: // Usuario
                        header('Location: index.php?c=ProfileController&a=main');
                        break;
                    default:
                        header('Location: index.php?c=LandingController&a=main');
                        break;
                }
                exit;
            } else {
                // Redirigir con error
                header('Location: index.php?c=AuthController&a=showLogin&error=invalid');
                exit;
            }
        }
    }

    public function showLogin()
    {
        require_once 'views/public/login/login.view.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php?c=LandingController&a=main');
        exit;
    }
}


?>