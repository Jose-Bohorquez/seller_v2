<?php

require_once 'models/CarouselImageModel.php';

class CarouselImageController
{
    private $imageModel;

    public function __construct()
    {
        $db = new Database();
        $this->imageModel = new CarouselImageModel($db->getConnection());
    }

    // Mostrar todas las imágenes en la administración
    public function main()
    {
        $images = $this->imageModel->getAllImages();
        require_once 'views/rol/admin/dashboard/carousel/read_baners.php';
    }

    // Agregar una nueva imagen
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['ruta_img'])) {
            if ($_FILES['ruta_img']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/baners/';
                
                // Sanitizar el nombre de la imagen
                $nombreImagen = $_POST['nombre_img']; 
                $nombreImagenSanitizado = preg_replace('/[^A-Za-z0-9\- ]/', '', $nombreImagen); // Eliminar caracteres especiales
                $nombreImagenSanitizado = str_replace(' ', '_', trim($nombreImagenSanitizado)); // Reemplazar espacios por guiones bajos
                
                // Obtener extensión del archivo
                $extension = pathinfo($_FILES['ruta_img']['name'], PATHINFO_EXTENSION);
                $uploadFile = $uploadDir . $nombreImagenSanitizado . '.' . $extension;
    
                if (move_uploaded_file($_FILES['ruta_img']['tmp_name'], $uploadFile)) {
                    // Guardar en la base de datos con ruta corregida
                    $this->imageModel->setNombre($nombreImagen);
                    $this->imageModel->setRuta($uploadFile);
                    $this->imageModel->setEstado(1); // Activo por defecto
    
                    $this->imageModel->createImage();
                    header('Location: index.php?c=CarouselImageController&a=main');
                    exit;
                } else {
                    die('Error al subir la imagen.');
                }
            }
        }
        require_once 'views/rol/admin/dashboard/carousel/create_baner.php';
    }
    

    // Editar una imagen
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_img'];
            $image = $this->imageModel->getImageById($id);
    
            if ($image) {
                $nombreImagen = $_POST['nombre_img']; 
                $nombreImagenSanitizado = preg_replace('/[^A-Za-z0-9\- ]/', '', $nombreImagen);
                $nombreImagenSanitizado = str_replace(' ', '_', trim($nombreImagenSanitizado));
    
                // Si se sube una nueva imagen, renombrarla correctamente
                if (!empty($_FILES['ruta_img']['name'])) {
                    $uploadDir = 'assets/images/baners/';
                    $extension = pathinfo($_FILES['ruta_img']['name'], PATHINFO_EXTENSION);
                    $uploadFile = $uploadDir . $nombreImagenSanitizado . '.' . $extension;
    
                    if (move_uploaded_file($_FILES['ruta_img']['tmp_name'], $uploadFile)) {
                        $image->setRuta($uploadFile);
                    }
                }
    
                // Guardar en la BD el nuevo nombre y estado
                $image->setNombre($nombreImagen);
                $image->setEstado($_POST['estado']);
                $image->updateImage();
    
                header('Location: index.php?c=CarouselImageController&a=main');
                exit;
            }
        } elseif (isset($_GET['id'])) {
            $image = $this->imageModel->getImageById($_GET['id']);
            require_once 'views/rol/admin/dashboard/carousel/update_baner.php';
        }
    }
    
    




    // Eliminar una imagen
    public function delete()
    {
        if (isset($_GET['id'])) {
            $image = $this->imageModel->getImageById($_GET['id']);
            if ($image) {
                unlink($image->getRuta()); // Elimina el archivo del servidor
                $image->deleteImage();
            }

            header('Location: index.php?c=CarouselImageController&a=main');
            exit;
        }
    }
}

?>
