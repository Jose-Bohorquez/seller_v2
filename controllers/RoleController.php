<?php

require_once 'models/RoleModel.php';

class RoleController
{
    private $roleModel;

    public function __construct()
    {
        $db = new Database();
        $this->roleModel = new RoleModel($db->getConnection());
    }

    // Acción principal (listar roles)
    public function main()
    {
        $roles = $this->roleModel->getAllRoles(); // Obtener todos los roles
        require_once 'views/rol/admin/dashboard/rol/read_roles.php';
    }

    // Crear un nuevo rol
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name_rol = $_POST['name_rol']; // Obtener el nombre del rol del formulario
            #$this->roleModel->setIdRol(null);
            $this->roleModel->setNameRol($name_rol); // Usar setter para asignar el nombre
            $this->roleModel->createRole(); // Crear el nuevo rol usando el modelo
            header('Location: index.php?c=RoleController&a=main'); // Redirigir al listado
            exit;
        }
        require_once 'views/rol/admin/dashboard/rol/create_rol.php';
    }

    // Editar un rol existente
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $id_rol = $_POST['id_rol'];
            $name_rol = $_POST['name_rol'];

            // Configurar valores en el objeto RoleModel
            $this->roleModel->setIdRol($id_rol);
            $this->roleModel->setNameRol($name_rol);

            // Actualizar el rol
            $this->roleModel->updateRole();

            // Redirigir al listado
            header('Location: index.php?c=RoleController&a=main');
            exit;
        } elseif (isset($_GET['id'])) {
            // Cargar los datos del rol para edición
            $rol = $this->roleModel->getRoleById($_GET['id']);
            if ($rol) {
                require_once 'views/rol/admin/dashboard/rol/update_rol.php';
            } else {
                // Manejar caso de ID no válido
                header('Location: index.php?c=RoleController&a=main');
                exit;
            }
        }
    }


    // Confirmar eliminación de un rol
    public function delete()
    {
        if (isset($_GET['id'])) {
            $id_rol = $_GET['id'];

            // Configurar el ID en el objeto RoleModel
            $this->roleModel->setIdRol($id_rol);

            // Eliminar el rol
            $this->roleModel->deleteRole();

            // Redirigir al listado principal
            header('Location: index.php?c=RoleController&a=main');
            exit;
        }
    }





    
}

?>
