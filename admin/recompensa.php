<?php
require_once ('recompensa.class.php');
$app = new recompensa();

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        include 'views/recompensa/crear.php';
        break;
    }

    case 'nuevo': {
        $data=$_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "recompensa dada de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "La recompensa no ha sido dada de alta";
            $tipo = "danger";
        }

        $recompensas = $app->readAll();
        include('views/recompensa/index.php');
        break;
    }

    case 'actualizar': {
        $recompensas = $app -> readOne($id); 
        include('views/recompensa/crear.php');
        break;
    }
    
    case 'modificar': {
        $data= $_POST['data'];
        $result=$app->update($id,$data);
        if($result){
            $mensaje="La recompensa se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $recompensas = $app->readAll();
        include('views/recompensa/index.php');
        break;
    }

    case 'eliminar': {
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "La recompensa se eliminó correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "La recompensa no se eliminó correctamente";
                    $tipo = "danger";
                }
            }
        }
        $recompensas = $app->readAll();
        include('views/recompensa/index.php');
        break;
    }

    default: {
        $recompensas = $app->readAll();
        include 'views/recompensa/index.php';
        break;
    }
}
?>
