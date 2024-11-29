<?php
require_once ('venta.class.php');
require_once ('usuario.class.php');
require_once ('producto.class.php');
$app = new venta();
$appUsuarios = new usuario();
$appProductos = new producto();

$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        $usuarios = $appUsuarios -> readAll(); 
        $productos = $appProductos -> readAll(); 
        $ventas = $app -> readAll(); 
        // echo'<pre/>';
        // echo'inicia usuarios';
        // print_r($usuarios);
        // echo'inicia productos';
        // print_r($productos);
        // echo'inicia ventas';
        // print_r($ventas);
        // die();
        include 'views/venta/crear.php';
        break;
    }

    case 'nuevo': {
        $data=$_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "Venta dada de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "La venta no ha sido dado de alta";
            $tipo = "danger";
        }

        $ventas = $app->readAll();
        include('views/venta/index.php');
        break;
    }

    case 'actualizar': {
        $ventas = $app -> readOne($id); 
        $usuarios = $appUsuarios -> readAll($id); 
        $productos = $appProductos -> readAll($id); 
        include('views/venta/crear.php');
        break;
    }
    
    case 'modificar': {
        $data= $_POST['data'];
        $result=$app->update($id,$data);
        if($result){
            $mensaje="La venta se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $ventas = $app->readAll();
        include('views/venta/index.php');
        break;
    }

    case 'eliminar': {
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "La venta se eliminó correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "La venta no se eliminó correctamente";
                    $tipo = "danger";
                }
            }
        }
        $ventas = $app->readAll();
        include('views/venta/index.php');
        break;
    }

    default: {
        $ventas = $app->readAll();
        include 'views/venta/index.php';
        break;
    }
}
?>
