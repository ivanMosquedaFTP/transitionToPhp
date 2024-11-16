<?php
require_once ('producto.class.php');
$app = new producto();
$app -> checkRole('administrador');

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        include 'views/producto/crear.php';
        break;
    }

    case 'nuevo': {
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
        $productos = $app -> readOne($id); 
        include('views/producto/crear.php');
        break;
    }
    
    case 'modificar': {
        $data= $_POST['data'];
        $result=$app->update($id,$data);
        if($result){
            $mensaje="El producto se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $productos = $app->readAll();
        include('views/producto/index.php');
        break;
    }

    case 'eliminar': {
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

    default: {
        $productos = $app->readAll();
        include 'views/producto/index.php';
        break;
    }
}
?>