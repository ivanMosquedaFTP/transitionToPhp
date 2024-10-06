<?php
require_once ('administrador.class.php');
$app = new administrador();

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        include 'views/administrador/crear.php';
        break;
    }

    case 'nuevo': {
        $data=$_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "Administrador dada de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "El administrador no ha sido dado de alta";
            $tipo = "danger";
        }

        $administradores = $app->readAll();
        include('views/administrador/index.php');
        break;
    }

    case 'actualizar': {
        $administradores = $app -> readOne($id); 
        include('views/administrador/crear.php');
        break;
    }
    
    case 'modificar': {
        $data= $_POST['data'];
        $result=$app->update($id,$data);
        if($result){
            $mensaje="El administrador se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $administradores = $app->readAll();
        include('views/administrador/index.php');
        break;
    }

    case 'eliminar': {
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "El administrador se eliminó correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "El administrador no se eliminó correctamente";
                    $tipo = "danger";
                }
            }
        }
        $administradores = $app->readAll();
        include('views/administrador/index.php');
        break;
    }

    default: {
        $administradores = $app->readAll();
        include 'views/administrador/index.php';
        break;
    }
}
?>