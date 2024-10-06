<?php
require_once ('seccion.class.php');
require_once ('invernadero.class.php');
$appInvernadero = new invernadero();
$app = new seccion();

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        $invernaderos = $appInvernadero -> readAll();
        include 'views/seccion/crear.php';
        break;
    }

    case 'nuevo': {
        $data=$_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "Sección dada de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "La sección no ha sido dado de alta";
            $tipo = "danger";
        }

        $secciones = $app->readAll();
        include('views/seccion/index.php');
        break;
    }

    case 'actualizar': {
        $secciones = $app -> readOne($id); 
        $invernaderos = $appInvernadero -> readAll();
        include('views/seccion/crear.php');
        break;
    }
    
    case 'modificar': {
        $data= $_POST['data'];
        $result=$app->update($id,$data);
        if($result){
            $mensaje="La sección se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $secciones = $app->readAll();
        include('views/seccion/index.php');
        break;
    }

    case 'eliminar': {
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "La sección se eliminó correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "La sección no se eliminó correctamente";
                    $tipo = "danger";
                }
            }
        }
        $secciones = $app->readAll();
        include('views/seccion/index.php');
        break;
    }

    default: {
        $secciones = $app->readAll();
        include 'views/seccion/index.php';
        break;
    }
}
?>