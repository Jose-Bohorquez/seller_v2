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
                            // Iniciar sesión
                            session_start();
                            $_SESSION['user_id'] = $user->getIdUser();
                            $_SESSION['user_name'] = $user->getName();
                            $_SESSION['user_rol'] = $user->getRol();
                
                            // Redirigir siempre al Landing con param de loginOk
                            header('Location: index.php?c=LandingController&a=main&m=loginOk');
                            exit;
                        } else {
                            // Credenciales inválidas
                            header('Location: index.php?c=AuthController&a=showLogin&error=invalid');
                            exit;
                        }
                    } else {
                        // Si no es POST, muestro login
                        header('Location: index.php?c=AuthController&a=showLogin');
                        exit;
                    }
                }
                

                public function showLogin()
                {
                    require_once 'views/public/login/login.view.php';
                }

                public function logout()
                {
                    session_start();
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        require_once 'controllers/ShoppingCartController.php';
                        $cart = new ShoppingCartController();
                        $cart->revertStockAndCleanCart();
                    }
                    session_destroy();
                    header('Location: index.php?c=LandingController&a=main');
                    exit;
                }

                public function goDashboard()
                {
                    session_start();
                    if (!isset($_SESSION['user_rol'])) {
                        // No logueado => mandar al login
                        header('Location: index.php?c=AuthController&a=showLogin');
                        exit;
                    }

                    switch ($_SESSION['user_rol']) {
                        case 1:
                        case 2:
                            header('Location: index.php?c=DashboardController&a=main');
                            break;
                        case 3:
                            header('Location: index.php?c=SellerController&a=main');
                            break;
                        case 4:
                            // Rol usuario => o mandas a su perfil, o niegas el acceso
                            header('Location: index.php?c=ProfileController&a=main');
                            break;
                        default:
                            // Cualquier otro => landing o error
                            header('Location: index.php?c=LandingController&a=main&m=unauthorized');
                            break;
                    }
                    exit;
                }

            

            
            
        }


?>