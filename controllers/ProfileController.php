<?php

require_once 'models/UserModel.php';

class ProfileController
{
    private $userModel;

    public function __construct()
    {
        $db = new Database(); // Conexión a la base de datos
        $pdo = $db->getConnection();
        $this->userModel = new UserModel($pdo); // Instancia del modelo
    }

public function main()
{
    // Verificar si hay un usuario logueado
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?c=AuthController&a=showLogin&m=noSession");
        exit;
    }

    // Obtener los datos del usuario logueado
    $userId = $_SESSION['user_id'];
    $user = $this->userModel->getUserProfileById($userId);

    if (!$user) {
        header("Location: index.php?c=AuthController&a=showLogin&m=invalidUser");
        exit;
    }

    // Renderizar la vista del perfil con los datos del usuario
    require_once("views/rol/user/modules/1head.php");
    require_once("views/rol/user/modules/2nav_lat.php");
    // Pasamos explícitamente el usuario a la vista
    require_once("views/rol/user/modules/3contenido.php");
    require_once("views/rol/user/modules/4footer.php");
}


    public function editProfile()
    {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?c=AuthController&a=showLogin&m=noSession");
            exit;
        }

        // Obtener los datos del usuario logueado
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserProfileById($userId);

        if (!$user) {
            header("Location: index.php?c=AuthController&a=showLogin&m=invalidUser");
            exit;
        }

        // Renderizar la vista para editar el perfil
        require_once("views/rol/user/modules/1head.php");
        require_once("views/rol/user/modules/2nav_lat.php");
        require_once("views/rol/user/modules/3edit.php"); // Vista para editar datos
        require_once("views/rol/user/modules/4footer.php");
    }

    public function updateProfile()
    {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?c=AuthController&a=showLogin&m=noSession");
            exit;
        }

        // Obtener los datos enviados por el formulario
        $id = $_SESSION['user_id'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $idNumber = $_POST['id_number'];
        $cel = $_POST['cel'];
        $email = $_POST['email'];
        $password = !empty($_POST['pass']) ? $_POST['pass'] : null;
        $imageProfile = $_POST['image_profile'];

        // Actualizar el perfil del usuario
        $result = $this->userModel->updateUserProfile($id, $name, $lastname, $idNumber, $cel, $email, $password, $imageProfile);

        if ($result) {
            header("Location: index.php?c=ProfileController&a=main&m=updateSuccess");
        } else {
            header("Location: index.php?c=ProfileController&a=editProfile&m=updateError");
        }
        exit;
    }
}
