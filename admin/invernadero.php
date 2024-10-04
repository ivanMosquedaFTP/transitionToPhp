<?php
require_once ('invernadero.class.php');
$app = new invernadero();

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        include 'views/invernadero/crear.php';
        break;
    }

    case 'nuevo': {
        $data=$_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "Invernadero dado de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "El invernadero no ha sido dado de alta";
            $tipo = "danger";
        }

        $invernaderos = $app->readAll();
        include('views/invernadero/index.php');
        break;
    }

    case 'actualizar': {
        $invernaderos = $app -> readOne($id); 
        include('views/invernadero/crear.php');
        break;
    }
    
    case 'modificar': {
        $data= $_POST['data'];
        $result=$app->update($id,$data);
        if($result){
            $mensaje="El invernadero se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $invernaderos = $app->readAll();
        include('views/invernadero/index.php');
        break;
    }

    case 'eliminar': {
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "El invernadero se elimino correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "El invernadero no se elimino correctamente";
                    $tipo = "danger";
                }
            }
        }
        $invernaderos = $app->readAll();
        include('views/invernadero/index.php');
        break;
    }

    default: {
        $invernaderos = $app->readAll();
        include 'views/invernadero/index.php';
        break;
    }
}
?>
