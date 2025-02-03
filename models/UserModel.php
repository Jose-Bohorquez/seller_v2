<?php

class UserModel
{
    private $db;
    private $id_user;
    private $name;
    private $lastname;
    private $id_number;
    private $cel;
    private $email;
    private $pass;
    private $rol;
    private $rol_name; // Nuevo atributo para el nombre del rol
    private $image_profile;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Getters y Setters
    public function getIdUser() { return $this->id_user; }
    public function setIdUser($id_user) { $this->id_user = $id_user; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getLastname() { return $this->lastname; }
    public function setLastname($lastname) { $this->lastname = $lastname; }

    public function getIdNumber() { return $this->id_number; }
    public function setIdNumber($id_number) { $this->id_number = $id_number; }

    public function getCel() { return $this->cel; }
    public function setCel($cel) { $this->cel = $cel; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPass() { return $this->pass; }
    public function setPass($pass) { $this->pass = $pass; }

    public function getRol() { return $this->rol; }
    public function setRol($rol) { $this->rol = $rol; }

    public function getRolName() { return $this->rol_name; } // Getter para el nombre del rol
    public function setRolName($rol_name) { $this->rol_name = $rol_name; } // Setter para el nombre del rol

    public function getImageProfile() { return $this->image_profile; }
    public function setImageProfile($image_profile) { $this->image_profile = $image_profile; }

    // Métodos CRUD (ya implementados anteriormente)
    public function getAllUsers()
    {
        $query = "
            SELECT 
                u.*, 
                r.name_rol AS rol_name
            FROM 
                user u
            LEFT JOIN 
                rol r ON u.rol = r.id_rol
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserModel($this->db);
            $user->setIdUser($row['id_user']);
            $user->setName($row['name']);
            $user->setLastname($row['lastname']);
            $user->setIdNumber($row['id_number']);
            $user->setCel($row['cel']);
            $user->setEmail($row['email']);
            $user->setPass($row['pass']);
            $user->setRol($row['rol']);
            $user->setRolName($row['rol_name']); // Asigna el nombre del rol
            $user->setImageProfile($row['image_profile']);
            $users[] = $user;
        }

        return $users;
    }


    public function getUserById($id)
    {
        $query = "SELECT * FROM user WHERE id_user = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->setIdUser($row['id_user']);
            $this->setName($row['name']);
            $this->setLastname($row['lastname']);
            $this->setIdNumber($row['id_number']);
            $this->setCel($row['cel']);
            $this->setEmail($row['email']);
            $this->setPass($row['pass']);
            $this->setRol($row['rol']);
            $this->setImageProfile($row['image_profile']);
            return $this;
        }

        return null;
    }

    public function createUser()
    {
        try {
            $query = "
                INSERT INTO user (name, lastname, id_number, cel, email, pass, rol, image_profile)
                VALUES (:name, :lastname, :id_number, :cel, :email, :pass, :rol, :image_profile)
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
            $stmt->bindParam(':id_number', $this->id_number, PDO::PARAM_STR);
            $stmt->bindParam(':cel', $this->cel, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $this->pass, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $this->rol, PDO::PARAM_INT);
            $stmt->bindParam(':image_profile', $this->image_profile, PDO::PARAM_STR);
    
            $stmt->execute();
            return true;  // Éxito
        } catch (PDOException $e) {
    
            // Verificar si es violación de UNIQUE => $e->errorInfo[1] == 1062
            if ($e->errorInfo[1] == 1062) {
                // Mensaje tipo "Duplicate entry '...' for key 'user.email'"
                $errorMsg = $e->errorInfo[2];
    
                // Detectar campo repetido
                if (stripos($errorMsg, 'user.email') !== false) {
                    return 'duplicate_email';
                } elseif (stripos($errorMsg, 'user.id_number') !== false) {
                    return 'duplicate_idNumber';
                } elseif (stripos($errorMsg, 'user.cel') !== false) {
                    return 'duplicate_cel';
                } else {
                    // Por si tienes otro índice único
                    return 'duplicate_other';
                }
            } else {
                // Otro tipo de error
                return 'error';
            }
        }
    }
    
    





  
    public function updateUser($id, $name, $lastname, $idNumber, $cel, $email, $rol, $password = null, $imageProfile = null)
    {
        $query = "
            UPDATE user 
            SET name = :name, lastname = :lastname, id_number = :idNumber, cel = :cel, email = :email, 
                rol = :rol, image_profile = :imageProfile
            WHERE id_user = :id";
        
        // Si hay nueva contraseña, la incluimos en la actualización.
        if (!empty($password)) {
            $query = "
                UPDATE user 
                SET name = :name, lastname = :lastname, id_number = :idNumber, cel = :cel, email = :email, 
                    pass = :password, rol = :rol, image_profile = :imageProfile
                WHERE id_user = :id";
        }
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':idNumber', $idNumber, PDO::PARAM_STR);
        $stmt->bindParam(':cel', $cel, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_INT);
        $stmt->bindParam(':imageProfile', $imageProfile, PDO::PARAM_STR);
    
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }
    
        return $stmt->execute();
    }
        




    

    public function deleteUser()
    {
        $query = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $user = new UserModel($this->db);
            $user->setIdUser($row['id_user']);
            $user->setName($row['name']);
            $user->setLastname($row['lastname']);
            $user->setIdNumber($row['id_number']);
            $user->setCel($row['cel']);
            $user->setEmail($row['email']);
            $user->setPass($row['pass']);
            $user->setRol($row['rol']);
            $user->setImageProfile($row['image_profile']);
            return $user;
        }

        return null;
    }



public function getUserProfileById($id)
{
    $query = "
        SELECT 
            u.id_user,
            u.name,
            u.lastname,
            u.id_number,
            u.cel,
            u.email,
            u.pass,
            u.rol,
            r.name_rol AS rol_name,
            u.image_profile
        FROM 
            user u
        LEFT JOIN 
            rol r ON u.rol = r.id_rol
        WHERE 
            u.id_user = :id
    ";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $user = new UserModel($this->db);
        $user->setIdUser($row['id_user']);
        $user->setName($row['name']);
        $user->setLastname($row['lastname']);
        $user->setIdNumber($row['id_number']);
        $user->setCel($row['cel']);
        $user->setEmail($row['email']);
        $user->setPass($row['pass']);
        $user->setRol($row['rol']);
        $user->setRolName($row['rol_name']);
        $user->setImageProfile($row['image_profile']);
        return $user;
    }

    return null;
}






    public function updateUserProfile($id, $name, $lastname, $idNumber, $cel, $email, $password = null, $imageProfile = null)
    {
        $query = "
            UPDATE user 
            SET name = :name, lastname = :lastname, id_number = :idNumber, cel = :cel, email = :email, 
                image_profile = :imageProfile
            WHERE id_user = :id";

        // Si se incluye una nueva contraseña, actualízala
        if (!empty($password)) {
            $query = "
                UPDATE user 
                SET name = :name, lastname = :lastname, id_number = :idNumber, cel = :cel, email = :email, 
                    pass = :password, image_profile = :imageProfile
                WHERE id_user = :id";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':idNumber', $idNumber, PDO::PARAM_STR);
        $stmt->bindParam(':cel', $cel, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':imageProfile', $imageProfile, PDO::PARAM_STR);

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }








}

?>
