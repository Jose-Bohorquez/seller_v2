<?php

class CategoryModel
{
    private $db;
    private $id_category;
    private $name_category;
    private $desc_category;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Getters y Setters
    public function getIdCategory(){  return $this->id_category; }

    public function setIdCategory($id_category){  $this->id_category = $id_category; }

    public function getNameCategory(){  return $this->name_category; }

    public function setNameCategory($name_category){  $this->name_category = $name_category; }

    public function getDescCategory(){  return $this->desc_category; }

    public function setDescCategory($desc_category){  $this->desc_category = $desc_category; }

    // CRUD Operations
    // Leer todas las categorías
    public function getAllCategories()
    {
        $query = "SELECT * FROM category";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new CategoryModel($this->db);
            $category->setIdCategory($row['id_category']);
            $category->setNameCategory($row['name_category']);
            $category->setDescCategory($row['desc_category']);
            $categories[] = $category;
        }

        return $categories;
    }

    // Leer una categoría por ID
    public function getCategoryById($id)
    {
        $query = "SELECT * FROM category WHERE id_category = :id_category";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_category', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->setIdCategory($row['id_category']);
            $this->setNameCategory($row['name_category']);
            $this->setDescCategory($row['desc_category']);
            return $this;
        }

        return null;
    }

    // Crear una categoría
    public function createCategory()
    {
        $query = "INSERT INTO category (name_category, desc_category) VALUES (:name_category, :desc_category)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name_category', $this->name_category, PDO::PARAM_STR);
        $stmt->bindParam(':desc_category', $this->desc_category, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Actualizar una categoría
    public function updateCategory()
    {
        $query = "UPDATE category SET name_category = :name_category, desc_category = :desc_category WHERE id_category = :id_category";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_category', $this->id_category, PDO::PARAM_INT);
        $stmt->bindParam(':name_category', $this->name_category, PDO::PARAM_STR);
        $stmt->bindParam(':desc_category', $this->desc_category, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Eliminar una categoría
    public function deleteCategory()
    {
        $query = "DELETE FROM category WHERE id_category = :id_category";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_category', $this->id_category, PDO::PARAM_INT);

        return $stmt->execute();
    }


    // filtrado de categorias que tiene almenos 1 producto en stock
    public function getCategoriesWithProducts()
    {
        $query = "
            SELECT DISTINCT c.id_category, c.name_category
            FROM category c
            JOIN products p ON c.id_category = p.category
            WHERE p.amount > 0
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new CategoryModel($this->db);
            $category->setIdCategory($row['id_category']);
            $category->setNameCategory($row['name_category']);
            $categories[] = $category;
        }

        return $categories;
    }


}

?>
