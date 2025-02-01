<?php

    class ProductModel
    {
        private $db;
        private $id;
        private $name;
        private $description;
        private $technical_description;
        private $price;
        private $amount;
        private $category;
        private $image;
        private $discount;
        private $final_price;

        public function __construct($pdo)
        {
            $this->db = $pdo;
        }

        // Getters y Setters
        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }

        public function getName() { return $this->name; }
        public function setName($name) { $this->name = $name; }

        public function getDescription() { return $this->description; }
        public function setDescription($description) { $this->description = $description; }

        public function getTechnicalDescription() { return $this->technical_description; }
        public function setTechnicalDescription($technical_description) { $this->technical_description = $technical_description; }

        public function getPrice() { return $this->price; }
        public function setPrice($price) { $this->price = $price; }

        public function getAmount() { return $this->amount; }
        public function setAmount($amount) { $this->amount = $amount ?? 0; /* Si $amount es null, asignar 0 como fallback */ }
        
        public function getCategory() { return $this->category; }
        public function setCategory($category) { $this->category = $category; }

        public function setCategoryName($categoryName) { $this->categoryName = $categoryName; }
        public function getCategoryName() { return $this->categoryName ?? 'Sin categoría'; }

        public function getImage() { return $this->image ?? ''; }
        public function setImage($image) { $this->image = $image; }

        public function getDiscount() { return $this->discount ?? 0; }
        public function setDiscount($discount) { $this->discount = $discount; }

        public function getFinalPrice() { return $this->final_price ?? 0; } // Getter para final_price
        public function setFinalPrice($final_price) { $this->final_price = $final_price; }

        public function getPriceFormatted() { return number_format($this->price, 0, ',', '.'); }

        public function getDiscountFormatted() { return number_format($this->discount, 0, ',', '.'); }

        public function getFinalPriceFormatted() { return number_format($this->final_price, 0, ',', '.'); }


        // CRUD Operations
        //read
        public function getAllProducts()
        {
            $query = "
                SELECT 
                    p.id, 
                    p.name, 
                    p.description, 
                    p.technical_description, 
                    p.price, 
                    p.amount, 
                    p.image, 
                    p.category, 
                    p.discount, 
                    p.final_price, 
                    c.name_category AS category_name
                FROM 
                    products p
                LEFT JOIN 
                    category c ON p.category = c.id_category
            ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $product = new ProductModel($this->db);
                $product->setId($row['id']);
                $product->setName($row['name']);
                $product->setDescription($row['description']);
                $product->setTechnicalDescription($row['technical_description']);
                $product->setPrice($row['price']);
                $product->setAmount($row['amount']);
                $product->setCategory($row['category']);
                $product->setImage($row['image']);
                $product->setDiscount($row['discount']);
                $product->setFinalPrice($row['final_price']); // Asignar final_price
                $product->setCategoryName($row['category_name']);
                $products[] = $product;
            }

            return $products;
        }

        //buscar 1 producto por id
        public function getProductById($id)
        {
            $query = "
                SELECT 
                    p.*, 
                    c.name_category AS category_name
                FROM 
                    products p
                LEFT JOIN 
                    category c ON p.category = c.id_category
                WHERE 
                    p.id = :id
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->setId($row['id']);
                $this->setName($row['name']);
                $this->setDescription($row['description']);
                $this->setTechnicalDescription($row['technical_description']);
                $this->setPrice($row['price']);
                $this->setAmount($row['amount']);
                $this->setCategory($row['category']);
                $this->setImage($row['image']);
                $this->setDiscount($row['discount']);
                $this->setFinalPrice($row['final_price']); // Asignar final_price
                $this->setCategoryName($row['category_name']);
                return $this;
            }

            return null;
        }

        //create product
        public function createProduct()
        {
            $query = "INSERT INTO products (name, description, technical_description, price, amount, category, image, discount)
                      VALUES (:name, :description, :technical_description, :price, :amount, :category, :image, :discount)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':technical_description', $this->technical_description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':amount', $this->amount, PDO::PARAM_INT);
            $stmt->bindParam(':category', $this->category, PDO::PARAM_INT);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
            $stmt->bindParam(':discount', $this->discount, PDO::PARAM_STR);

            return $stmt->execute();
        }

        //update product
        public function updateProduct()
        {
            $query = "UPDATE products SET 
                        name = :name,
                        description = :description,
                        technical_description = :technical_description,
                        price = :price,
                        amount = :amount,
                        category = :category,
                        image = :image,
                        discount = :discount
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':technical_description', $this->technical_description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':amount', $this->amount, PDO::PARAM_INT);
            $stmt->bindParam(':category', $this->category, PDO::PARAM_INT);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
            $stmt->bindParam(':discount', $this->discount, PDO::PARAM_STR);

            return $stmt->execute();
        }

        //delete product
        public function deleteProduct()
        {
            $query = "DELETE FROM products WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        // Métodos para la vista de Landing// En project/models/ProductModel.php
        public function getProductsByCategory($categoryId, $limit = null, $offset = null)
{
    $query = "
        SELECT 
            p.id, 
            p.name, 
            p.description, 
            p.price, 
            p.image, 
            p.discount, 
            p.final_price, 
            p.amount, 
            c.name_category AS category_name
        FROM 
            products p
        LEFT JOIN 
            category c ON p.category = c.id_category
        WHERE 
            (:categoryId IS NULL OR p.category = :categoryId) 
            AND p.amount > 0
    ";

    if ($limit !== null && $offset !== null) {
        $query .= " LIMIT :limit OFFSET :offset";
    }

    $stmt = $this->db->prepare($query);

    // Vincula el parámetro categoryId correctamente según su valor
    if ($categoryId === null) {
        $stmt->bindValue(':categoryId', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    }

    // Vincula limit y offset si están presentes
    if ($limit !== null && $offset !== null) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    }

    $stmt->execute();

    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = new ProductModel($this->db);
        $product->setId($row['id']);
        $product->setName($row['name']);
        $product->setDescription($row['description']);
        $product->setPrice($row['price']);
        $product->setImage($row['image']);
        $product->setDiscount($row['discount']);
        $product->setFinalPrice($row['final_price']);
        $product->setCategoryName($row['category_name']);
        $product->setAmount($row['amount']);
        $products[] = $product;
    }

    return $products;
}

        
        

        

        

        public function countProductsByCategory($categoryId)
        {
            $query = "
                SELECT COUNT(*) AS total
                FROM products
                WHERE (:categoryId IS NULL OR category = :categoryId)
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }




    }


?>
