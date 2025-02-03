<?php
require_once 'models/ProductModel.php';

class ShoppingCartController
{
    private $db;
    private $productModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function addToCart()
    {
        // 1) Verificar si el usuario está logueado
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }



        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode([
              'success' => false,
              'message' => 'Debes iniciar sesión o registrarte para agregar al carrito.'
            ]);
            exit;
        }
        

        // 2) Recibir datos por POST o GET (depende de tu enfoque)
        $productId = $_POST['product_id'] ?? null;
        $quantity  = $_POST['quantity']   ?? 1; // Por defecto 1

        // 3) Validar existencia y stock del producto
        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            // Producto inexistente
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
            exit;
        }

        // 4) Verificar stock disponible
        if ($product->getAmount() < $quantity) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
            exit;
        }

        // 5) Descontar stock en la BD (reservar)
        //    Restar la cantidad solicitada y actualizar
        $newStock = $product->getAmount() - $quantity;
        $product->setAmount($newStock);
        $product->updateProduct(); 
        // O podrías crear un método como $this->productModel->updateStock($productId, -$quantity).

        // 6) Agregar al carrito en sesión
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Revisa si el producto ya estaba en el carrito
        if (!isset($_SESSION['cart'][$productId])) {
            // Agregar un nuevo ítem
            $_SESSION['cart'][$productId] = [
                'id'       => $product->getId(),
                'name'     => $product->getName(),
                'image'    => $product->getImage(),
                'price'    => $product->getFinalPrice() > 0 
                               ? $product->getFinalPrice()
                               : $product->getPrice(), // usar el finalPrice si existe
                'quantity' => $quantity
            ];
        } else {
            // Aumentar la cantidad si ya existe
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        }

        // 7) Responder con JSON (si usas AJAX) o redirigir
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart_count' => count($_SESSION['cart'])
        ]);
    }

    // Actualizar la cantidad de un item en el carrito
    public function updateCartItem()
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }



        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        $newQty    = $_POST['quantity']   ?? 1;

        if (!$productId || !isset($_SESSION['cart'][$productId])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Producto no existe en el carrito']);
            exit;
        }

        // Primero, ver la diferencia entre la cantidad anterior y la nueva
        $oldQty = $_SESSION['cart'][$productId]['quantity'];
        $diff   = $newQty - $oldQty;

        // Si $diff > 0 => se está incrementando, hay que reservar más stock
        // Si $diff < 0 => se está reduciendo, hay que devolver stock
        if ($diff > 0) {
            // Verificar en la BD si hay stock suficiente
            $product = $this->productModel->getProductById($productId);
            if ($product->getAmount() < $diff) {
                // No hay suficiente stock
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
                exit;
            }

            // Decrementar BD
            $product->setAmount($product->getAmount() - $diff);
            $product->updateProduct(); 
        } else if ($diff < 0) {
            // Devolver stock a la BD
            $product = $this->productModel->getProductById($productId);
            $product->setAmount($product->getAmount() + abs($diff));
            $product->updateProduct();
        }

        // Actualizar cantidad en sesión
        $_SESSION['cart'][$productId]['quantity'] = $newQty;

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Cantidad actualizada']);
    }

    // Eliminar un producto del carrito
    public function removeCartItem()
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); 
        }



        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        if (!$productId || !isset($_SESSION['cart'][$productId])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Producto no existe en el carrito']);
            exit;
        }

        // Devolver stock a la BD
        $qtyToRestore = $_SESSION['cart'][$productId]['quantity'];
        $product = $this->productModel->getProductById($productId);
        if ($product) {
            $product->setAmount($product->getAmount() + $qtyToRestore);
            $product->updateProduct();
        }

        // Remover del carrito en sesión
        unset($_SESSION['cart'][$productId]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito']);
    }

    // Obtener contenido del carrito (para el modal)
    public function getCartItems()
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); 
        }



        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }

        $cartItems = $_SESSION['cart'] ?? [];
        // Opcional: calcular el total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success'   => true,
            'cartItems' => array_values($cartItems), 
            'total'     => $total
        ]);
    }

    // Revertir stock cuando la sesión expira o cierra
    public function revertStockAndCleanCart()
    {
        // Se asume que session_start() se hizo afuera
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $productId = $cartItem['id'];
                $qty       = $cartItem['quantity'];

                $product = $this->productModel->getProductById($productId);
                if ($product) {
                    $product->setAmount($product->getAmount() + $qty);
                    $product->updateProduct();
                }
            }
        }

        // Limpiar el carrito
        $_SESSION['cart'] = [];
    }
}

?>