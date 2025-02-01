<?php

require_once 'Database.php';

class CarouselImageModel
{
    private $db;
    private $id_img;
    private $nombre_img;
    private $ruta_img;
    private $estado;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Getters y Setters
    public function getId() { return $this->id_img; }
    public function setId($id_img) { $this->id_img = $id_img; }

    public function getNombre() { return $this->nombre_img; }
    public function setNombre($nombre_img) { $this->nombre_img = $nombre_img; }

    public function getRuta() { return $this->ruta_img; }
    public function setRuta($ruta_img) { $this->ruta_img = $ruta_img; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }

    // Obtener todas las imágenes activas para el carrusel
    public function getAllImages()
    {
        $query = "SELECT * FROM carousel"; // Eliminar el filtro WHERE estado = 1
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        $images = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $image = new CarouselImageModel($this->db);
            $image->setId($row['id_img']);
            $image->setNombre($row['nombre_img']);
            $image->setRuta($row['ruta_img']);
            $image->setEstado($row['estado']);
            $images[] = $image;
        }
    
        return $images;
    }
    

    // Obtener una imagen específica por ID
    public function getImageById($id)
    {
        $query = "SELECT * FROM carousel WHERE id_img = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->setId($row['id_img']);
            $this->setNombre($row['nombre_img']);
            $this->setRuta($row['ruta_img']);
            $this->setEstado($row['estado']);
            return $this;
        }

        return null;
    }

    // Insertar una nueva imagen
    public function createImage()
    {
        $query = "INSERT INTO carousel (nombre_img, ruta_img, estado) VALUES (:nombre_img, :ruta_img, :estado)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre_img', $this->nombre_img, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_img', $this->ruta_img, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Actualizar una imagen
    public function updateImage()
    {
        $query = "UPDATE carousel SET nombre_img = :nombre_img, ruta_img = :ruta_img, estado = :estado WHERE id_img = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id_img, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_img', $this->nombre_img, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_img', $this->ruta_img, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar una imagen
    public function deleteImage()
    {
        $query = "DELETE FROM carousel WHERE id_img = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id_img, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // En el CarouselImageModel
    public function getActiveImages()
    {
        $query = "SELECT * FROM carousel WHERE estado = 1"; // Filtra solo imágenes activas
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $images = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $image = new CarouselImageModel($this->db);
            $image->setId($row['id_img']);
            $image->setNombre($row['nombre_img']);
            $image->setRuta($row['ruta_img']);
            $image->setEstado($row['estado']);
            $images[] = $image;
        }

        return $images;
    }


}

?>
