<?php
require_once ('producto.class.php');
$app = new producto();

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        $app -> checkRole('administrador');
        include 'views/producto/crear.php';
        break;
    }

    case 'nuevo': {
        $app -> checkRole('administrador');
        $data=$_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "producto dado de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "El producto no ha sido dado de alta";
            $tipo = "danger";
        }

        $productos = $app->readAll();
        include('views/producto/index.php');
        break;
    }

    case 'actualizar': {
        $app -> checkRole('administrador');
        $productos = $app -> readOne($id); 
        include('views/producto/crear.php');
        break;
    }
    
    case 'modificar': {
        $app -> checkRole('administrador');
        if ($id && is_numeric($id)) {
            $data = $_POST['data'];
            $imagen_actual = $app->getImageById($id);
    
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $data['foto'] = $app->uploadFoto();
            } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
                $data['foto'] = $imagen_actual;
            } else {

                $tipo = "danger";
                $mensaje = "Error al procesar la imagen.";
                include 'views/producto/index.php';
                break;
            }
    
            $resultado = $app->update($id, $data);

            $tipo = "success";
            $mensaje = $resultado ? "Producto actualizado correctamente." : "Error al actualizar el producto.";
        } else {
            $tipo = "danger";
            $mensaje = "ID de producto no válido o no encontrado.";
        }

        $productos = $app->readAll();
        include 'views/producto/index.php';
        break;
    }

    case 'eliminar': {
        $app -> checkRole('administrador');
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "El producto se eliminó correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "El producto no se eliminó correctamente";
                    $tipo = "danger";
                }
            }
        }
        $productos = $app->readAll();
        include('views/producto/index.php');
        break;
    }

    case 'descripcion': {
        $producto = $app -> readOne($id); 
        include('views/producto/descripcion.php');
        break;
    }

    default: {
        $productos = $app->readAll();
        include 'views/producto/index.php';
        break;
    }
}
?>