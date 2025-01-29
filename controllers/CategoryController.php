<?php

require_once 'models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $db = new Database();
        $this->categoryModel = new CategoryModel($db->getConnection());
    }

    // Listar categorías
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

        $categories = $this->categoryModel->getAllCategories();
        require_once 'views/rol/admin/dashboard/categories/read_categories.php';
    }

    // Crear categoría
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name_category = $_POST['name_category'];
            $desc_category = $_POST['desc_category'];

            $this->categoryModel->setNameCategory($name_category);
            $this->categoryModel->setDescCategory($desc_category);
            $this->categoryModel->createCategory();

            header('Location: index.php?c=CategoryController&a=main');
            exit;
        }

        require_once 'views/rol/admin/dashboard/categories/create_category.php';
    }

    // Editar categoría
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_category = $_POST['id_category'];
            $name_category = $_POST['name_category'];
            $desc_category = $_POST['desc_category'];

            $this->categoryModel->setIdCategory($id_category);
            $this->categoryModel->setNameCategory($name_category);
            $this->categoryModel->setDescCategory($desc_category);
            $this->categoryModel->updateCategory();

            header('Location: index.php?c=CategoryController&a=main');
            exit;
        } elseif (isset($_GET['id'])) {
            $category = $this->categoryModel->getCategoryById($_GET['id']);
            require_once 'views/rol/admin/dashboard/categories/update_category.php';
        }
    }

    // Eliminar categoría
    public function delete()
    {
        if (isset($_GET['id'])) {
            $id_category = $_GET['id'];

            $this->categoryModel->setIdCategory($id_category);
            $this->categoryModel->deleteCategory();

            header('Location: index.php?c=CategoryController&a=main');
            exit;
        }
    }
}

?>
