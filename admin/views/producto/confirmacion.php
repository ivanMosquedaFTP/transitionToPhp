<?php
require('../../config.class.php');
require('../../sistema.class.php');

$db = new Config();
$conexion = $db->conectar();

if ($_POST['payment_status'] === "Completed") {
    echo"completado";
    die();
    $id_producto = $_POST['item_number'];

    $query = "UPDATE productos SET stock = stock - 1 WHERE id = :id AND stock > 0";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id_producto);
    if ($stmt->execute()) {
        echo "Pago confirmado y stock actualizado.";
    } else {
        echo "Error al actualizar el stock.";
    }
} else {
    echo "El pago no se completó.";
}