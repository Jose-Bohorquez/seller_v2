<?php

require_once("models/CarouselImageModel.php"); 
require_once("models/CategoryModel.php"); 
require_once("models/ProductModel.php"); 
require_once("models/Database.php"); 

class LandingController
{
    private $db;

    public function __construct()
    {
        
        $database = new Database();
        $this->db = $database->getConnection(); 
    }

    public function main()
    {
        $carouselImageModel = new CarouselImageModel($this->db);
        $carouselImages = $carouselImageModel->getActiveImages();
    
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategoriesWithProducts();
    
        $productModel = new ProductModel($this->db);
    
        // Si no hay categoría seleccionada, obtener todos los productos
        $selectedCategoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
    
        // Obtener solo los primeros 12 productos
        $products = $productModel->getProductsByCategory($selectedCategoryId, 12, 0);
        #var_dump($products); // Depuración para verificar los datos obtenidos
    
        // Contar el total de productos en general si no hay filtro de categoría
        $totalProducts = $productModel->countProductsByCategory($selectedCategoryId);
        $hasMoreProducts = $totalProducts > 12;
    
        require_once("views/public/landing/landing.view.php");
    }
    


    
    public function loadMoreProducts()
    {
        $categoryId = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null; // Cambiar cadena vacía a null
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 12;
        $limit = 12;
    
        $productModel = new ProductModel($this->db);
        $products = $productModel->getProductsByCategory($categoryId, $limit, $offset);
    
        $totalProducts = $productModel->countProductsByCategory($categoryId);
        $hasMoreProducts = ($offset + $limit) < $totalProducts;
    
        header('Content-Type: application/json');
        echo json_encode([
            'products' => array_map(function ($product) {
                return [
                    'image' => htmlspecialchars($product->getImage()),
                    'name' => htmlspecialchars($product->getName()),
                    'description' => htmlspecialchars($product->getDescription()),
                    'final_price' => htmlspecialchars($product->getFinalPriceFormatted()),
                    'amount' => htmlspecialchars($product->getAmount()),
                ];
            }, $products),
            'hasMore' => $hasMoreProducts,
        ]);
        exit;
    }
    
    
    
    



    
}

?>