<?php

require_once 'Database.php';

class RoleModel
{
    private $id_rol;      // ID del rol
    private $name_rol;    // Nombre del rol
    private $db;          // Conexión a la base de datos

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // --- Getters y Setters ---
    // Getter para ID del rol
    public function getIdRol()
    {
        return $this->id_rol;
    }

    // Setter para ID del rol
    public function setIdRol($id_rol)
    {
        $this->id_rol = $id_rol;
    }

    // Getter para nombre del rol
    public function getNameRol()
    {
        return $this->name_rol;
    }

    // Setter para nombre del rol
    public function setNameRol($name_rol)
    {
        $this->name_rol = $name_rol;
    }

    // --- Métodos CRUD con abstracción ---
    // Obtener todos los roles
    public function getAllRoles()
    {
        $query = "SELECT * FROM rol";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $role = new RoleModel($this->db); // Crear un objeto para cada rol
            $role->setIdRol($row['id_rol']);
            $role->setNameRol($row['name_rol']);
            $roles[] = $role; // Agregarlo a la lista
        }

        return $roles; // Retorna un array de objetos RoleModel
    }

    // Obtener un rol por su ID
    public function getRoleById($id)
    {
        $query = "SELECT * FROM rol WHERE id_rol = :id_rol";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_rol', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->setIdRol($row['id_rol']);
            $this->setNameRol($row['name_rol']);
            return $this; // Retorna el objeto actual con datos cargados
        }

        return null; // Si no se encuentra el rol
    }

    // Crear un nuevo rol
    public function createRole()
    {
        $query = "INSERT INTO rol (name_rol) VALUES (:name_rol)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name_rol', $this->name_rol, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Actualizar un rol existente
    public function updateRole()
    {
        $query = "UPDATE rol SET name_rol = :name_rol WHERE id_rol = :id_rol";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_rol', $this->id_rol, PDO::PARAM_INT);
        $stmt->bindParam(':name_rol', $this->name_rol, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Eliminar un rol por su ID
    public function deleteRole()
    {
        $query = "DELETE FROM rol WHERE id_rol = :id_rol";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_rol', $this->id_rol, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
