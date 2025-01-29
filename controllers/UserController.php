<?php

require_once 'models/UserModel.php';
require_once 'models/RoleModel.php';

class UserController
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $this->userModel = new UserModel($pdo);
        $this->roleModel = new RoleModel($pdo); // Para obtener los roles
    }

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
        
        $users = $this->userModel->getAllUsers();
        require_once 'views/rol/admin/dashboard/user/read_users.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->setName($_POST['name']);
            $this->userModel->setLastname($_POST['lastname']);
            $this->userModel->setIdNumber($_POST['id_number']);
            $this->userModel->setCel($_POST['cel']);
            $this->userModel->setEmail($_POST['email']);
            $this->userModel->setPass(password_hash($_POST['pass'], PASSWORD_DEFAULT)); // Contraseña encriptada
            $this->userModel->setRol($_POST['rol']);
            $this->userModel->setImageProfile($_POST['image_profile']);
            $this->userModel->createUser();

            header('Location: index.php?c=UserController&a=main');
            exit;
        }

        $roles = $this->roleModel->getAllRoles(); // Obtener los roles
        require_once 'views/rol/admin/dashboard/user/create_user.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->setIdUser($_POST['id_user']);
            $this->userModel->setName($_POST['name']);
            $this->userModel->setLastname($_POST['lastname']);
            $this->userModel->setIdNumber($_POST['id_number']);
            $this->userModel->setCel($_POST['cel']);
            $this->userModel->setEmail($_POST['email']);
            $this->userModel->setPass(password_hash($_POST['pass'], PASSWORD_DEFAULT)); // Contraseña encriptada
            $this->userModel->setRol($_POST['rol']);
            $this->userModel->setImageProfile($_POST['image_profile']);
            $this->userModel->updateUser();

            header('Location: index.php?c=UserController&a=main');
            exit;
        } elseif (isset($_GET['id'])) {
            $user = $this->userModel->getUserById($_GET['id']);
            $roles = $this->roleModel->getAllRoles(); // Obtener los roles
            require_once 'views/rol/admin/dashboard/user/update_user.php';
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->userModel->setIdUser($_GET['id']);
            $this->userModel->deleteUser();

            header('Location: index.php?c=UserController&a=main');
            exit;
        }
    }


    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y procesar los datos del formulario
            $this->userModel->setName($_POST['name']);
            $this->userModel->setLastname($_POST['lastname']);
            $this->userModel->setIdNumber($_POST['id_number']);
            $this->userModel->setCel($_POST['cel']);
            $this->userModel->setEmail($_POST['email']);
            $this->userModel->setPass(password_hash($_POST['pass'], PASSWORD_BCRYPT));
            $this->userModel->setRol(4); // Rol fijo para usuarios externos
            $this->userModel->setImageProfile($_POST['image_profile'] ?? null);

            $this->userModel->createUser();

            // Redirigir al landing con mensaje
            header('Location: index.php?c=LandingController&a=main&m=regOk');
            exit;
        }

        // Cargar la vista de registro externo
        require_once 'views/public/register/register.view.php';
    }






}

?>
