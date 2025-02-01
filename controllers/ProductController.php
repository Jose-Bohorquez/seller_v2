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
            $name = $_POST['name'];
            $description = $_POST['description'];
            $technical_description = $_POST['technical_description'];
            $price = round($_POST['price']);
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $discount = round($_POST['discount']);
    
            // Convertir el nombre a CamelCase para la carpeta
            $productFolder = preg_replace('/[^a-zA-Z0-9]/', '', ucwords(str_replace(' ', '', $name)));
    
            // Crear la carpeta si no existe
            $uploadDir = "assets/images/products/$productFolder/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $imagePath = ''; // Ruta final de la imagen
    
            // Validar si se subió una imagen
            if (!empty($_FILES['image']['name'])) {
                $imageName = preg_replace('/[^a-zA-Z0-9]/', '', pathinfo($_FILES['image']['name'], PATHINFO_FILENAME));
                $imageExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $finalImageName = $imageName . '.' . $imageExt;
    
                $targetFile = $uploadDir . $finalImageName;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                }
            }
    
            // Guardar en el modelo
            $this->productModel->setName($name);
            $this->productModel->setDescription($description);
            $this->productModel->setTechnicalDescription($technical_description);
            $this->productModel->setPrice($price);
            $this->productModel->setAmount($amount);
            $this->productModel->setCategory($category);
            $this->productModel->setImage($imagePath); // Guardar la ruta en la BD
            $this->productModel->setDiscount($discount);
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
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $technical_description = $_POST['technical_description'];
            $price = $_POST['price'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $discount = $_POST['discount'];
    
            // Obtener el producto actual para ver si ya tiene imagen
            $product = $this->productModel->getProductById($id);
    
            // Convertir el nombre a CamelCase
            $productFolder = preg_replace('/[^a-zA-Z0-9]/', '', ucwords(str_replace(' ', '', $name)));
            $uploadDir = "assets/images/products/$productFolder/";
    
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $imagePath = $product->getImage(); // Mantener la imagen si no se actualiza
    
            if (!empty($_FILES['image']['name'])) {
                // Eliminar la imagen anterior si existe
                if (!empty($product->getImage()) && file_exists($product->getImage())) {
                    unlink($product->getImage());
                }
    
                // Procesar la nueva imagen
                $imageName = preg_replace('/[^a-zA-Z0-9]/', '', pathinfo($_FILES['image']['name'], PATHINFO_FILENAME));
                $imageExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $finalImageName = $imageName . '.' . $imageExt;
    
                $targetFile = $uploadDir . $finalImageName;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                }
            }
    
            // Actualizar en el modelo
            $this->productModel->setId($id);
            $this->productModel->setName($name);
            $this->productModel->setDescription($description);
            $this->productModel->setTechnicalDescription($technical_description);
            $this->productModel->setPrice($price);
            $this->productModel->setAmount($amount);
            $this->productModel->setCategory($category);
            $this->productModel->setImage($imagePath);
            $this->productModel->setDiscount($discount);
            $this->productModel->updateProduct();
    
            header('Location: index.php?c=ProductController&a=main');
            exit;
        } elseif (isset($_GET['id'])) {
            $product = $this->productModel->getProductById($_GET['id']);
            $categories = $this->categoryModel->getAllCategories();
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
