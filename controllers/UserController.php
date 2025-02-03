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
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $id_number = $_POST['id_number'];
            $cel = $_POST['cel'];
            $email = $_POST['email'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $rol = $_POST['rol'];
    
            $profileDir = "assets/images/profile/$id_number/";
            if (!is_dir($profileDir)) {
                mkdir($profileDir, 0777, true);
            }
    
            $imagePath = 'assets/images/profile/default.png'; // Imagen por defecto
    
            if (!empty($_FILES['image_profile']['name'])) {
                $imageName = preg_replace('/[^a-zA-Z0-9]/', '', pathinfo($_FILES['image_profile']['name'], PATHINFO_FILENAME));
                $imageExt = strtolower(pathinfo($_FILES['image_profile']['name'], PATHINFO_EXTENSION));
                $finalImageName = $imageName . '.' . $imageExt;
                $targetFile = $profileDir . $finalImageName;
    
                if (move_uploaded_file($_FILES['image_profile']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile; // Solo cambia si la imagen se subió bien
                } else {
                    echo "⚠️ Error al mover el archivo. Código de error: " . $_FILES['image_profile']['error'];
                }
            }
    
            $this->userModel->setName($name);
            $this->userModel->setLastname($lastname);
            $this->userModel->setIdNumber($id_number);
            $this->userModel->setCel($cel);
            $this->userModel->setEmail($email);
            $this->userModel->setPass($pass);
            $this->userModel->setRol($rol);
            $this->userModel->setImageProfile($imagePath);
            $this->userModel->createUser();
    
            header('Location: index.php?c=UserController&a=main');
            exit;
        }
    
        $roles = $this->roleModel->getAllRoles();
        require_once 'views/rol/admin/dashboard/user/create_user.php';
    }
    
    






    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_user'];
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $id_number = $_POST['id_number'];
            $cel = $_POST['cel'];
            $email = $_POST['email'];
            $pass = !empty($_POST['pass']) ? password_hash($_POST['pass'], PASSWORD_DEFAULT) : null;
            $rol = $_POST['rol'];
    
            $user = $this->userModel->getUserById($id);
            if (!$user) {
                header("Location: index.php?c=UserController&a=main&m=userNotFound");
                exit;
            }
    
            $profileDir = "assets/images/profile/$id_number/";
            if (!is_dir($profileDir)) {
                mkdir($profileDir, 0777, true);
            }
    
            $imagePath = $user->getImageProfile(); // Mantener la imagen si no se actualiza
    
            if (!empty($_FILES['image_profile']['name'])) {
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath); // Eliminar la imagen anterior
                }
    
                $imageName = preg_replace('/[^a-zA-Z0-9]/', '', pathinfo($_FILES['image_profile']['name'], PATHINFO_FILENAME));
                $imageExt = strtolower(pathinfo($_FILES['image_profile']['name'], PATHINFO_EXTENSION));
                $finalImageName = $imageName . '.' . $imageExt;
                $targetFile = $profileDir . $finalImageName;
    
                if (move_uploaded_file($_FILES['image_profile']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                }
            }
    
            // 🔥 Ahora pasamos el `rol` correctamente
            $this->userModel->updateUser($id, $name, $lastname, $id_number, $cel, $email, $rol, $pass, $imagePath);
    
            header('Location: index.php?c=UserController&a=main');
            exit;
        } elseif (isset($_GET['id'])) {
            $user = $this->userModel->getUserById($_GET['id']);
            if (!$user) {
                header("Location: index.php?c=UserController&a=main&m=userNotFound");
                exit;
            }
    
            $roles = $this->roleModel->getAllRoles();
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
            $this->userModel->setName($_POST['name']);
            $this->userModel->setLastname($_POST['lastname']);
            $this->userModel->setIdNumber($_POST['id_number']);
            $this->userModel->setCel($_POST['cel']);
            $this->userModel->setEmail($_POST['email']);
            $this->userModel->setPass(password_hash($_POST['pass'], PASSWORD_BCRYPT));
            $this->userModel->setRol(4); // Rol fijo para usuarios externos
            $this->userModel->setImageProfile($_POST['image_profile'] ?? null);
    
            $result = $this->userModel->createUser();
    
            if ($result === true) {
                // Éxito
                header('Location: index.php?c=LandingController&a=main&m=regOk');
                exit;
            } elseif ($result === 'duplicate_email') {
                // Email ya existe
                header('Location: index.php?c=UserController&a=register&m=dupEmail');
                exit;
            } elseif ($result === 'duplicate_idNumber') {
                // id_number ya existe
                header('Location: index.php?c=UserController&a=register&m=dupId');
                exit;
            } elseif ($result === 'duplicate_cel') {
                // cel ya existe
                header('Location: index.php?c=UserController&a=register&m=dupCel');
                exit;
            } elseif ($result === 'duplicate_other') {
                // Algún otro índice UNIQUE se violó
                header('Location: index.php?c=UserController&a=register&m=dupOther');
                exit;
            } else {
                // Error genérico de BD
                header('Location: index.php?c=UserController&a=register&m=error');
                exit;
            }
        }
    
        // Cargar la vista de registro
        require_once 'views/public/register/register.view.php';
    }
    
    






}

?>
