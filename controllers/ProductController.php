<?php

require_once 'models/ProductModel.php';
require_once 'models/CategoryModel.php';

class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $this->productModel = new ProductModel($pdo);
        $this->categoryModel = new CategoryModel($pdo); // Instancia del modelo de categorías
    }

    // Método principal: listar productos
    public function main()
    {
        // Verificar si la sesión ya está iniciada (NO se debe iniciar aquí)
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_rol'])) {
            // Si no hay sesión activa, redirigir al landing con mensaje de error
            header("Location: index.php?c=LandingController&a=main&m=noSession");
            exit;
        }

        // Validar si el usuario tiene permisos de acceso (solo roles 1 y 2)
        if (!in_array($_SESSION['user_rol'], [1, 2, 3])) {
            // Si el rol no es 1 o 2, redirigir con mensaje de acceso denegado
            header("Location: index.php?c=LandingController&a=main&m=unauthorized");
            exit;
        }
        
        $products = $this->productModel->getAllProducts();
        require_once 'views/rol/admin/dashboard/products/read_products.php';
    }

    // Crear un nuevo producto
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productModel->setName($_POST['name']);
            $this->productModel->setDescription($_POST['description']);
            $this->productModel->setTechnicalDescription($_POST['technical_description']);
            $this->productModel->setPrice(round($_POST['price']));
            $this->productModel->setAmount($_POST['amount']);
            $this->productModel->setCategory($_POST['category']);
            $this->productModel->setImage($_POST['image']);
            $this->productModel->setDiscount(round($_POST['discount']));// Manejar el descuento
            $this->productModel->createProduct();

            header('Location: index.php?c=ProductController&a=main');
            exit;
        }

        $categories = $this->categoryModel->getAllCategories();
        require_once 'views/rol/admin/dashboard/products/create_product.php';
    }

    // Actualizar un producto existente
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productModel->setId($_POST['id']);
            $this->productModel->setName($_POST['name']);
            $this->productModel->setDescription($_POST['description']);
            $this->productModel->setTechnicalDescription($_POST['technical_description']);
            $this->productModel->setPrice($_POST['price']);
            $this->productModel->setAmount($_POST['amount']);
            $this->productModel->setCategory($_POST['category']);
            $this->productModel->setImage($_POST['image']);
            $this->productModel->setDiscount($_POST['discount']); // Manejar el descuento
            $this->productModel->updateProduct();

            header('Location: index.php?c=ProductController&a=main');
            exit;
        } elseif (isset($_GET['id'])) {
            // Obtener el producto por su ID
            $product = $this->productModel->getProductById($_GET['id']);

            // Obtener todas las categorías disponibles
            $categories = $this->categoryModel->getAllCategories();

            // Pasar los datos a la vista
            require_once 'views/rol/admin/dashboard/products/update_product.php';
        }
    }

    // Eliminar un producto
    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->productModel->setId($_GET['id']);
            $this->productModel->deleteProduct();

            header('Location: index.php?c=ProductController&a=main');
            exit;
        }
    }
}

?>
