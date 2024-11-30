<?php
require_once(__DIR__ . '/../../../admin/venta.class.php');
$venta = new venta();

$log_file = 'log_ipn.txt';

$log_data = file_get_contents($log_file);

if ($log_data !== false) {
    preg_match('/\[mc_gross\]\s*=>\s*([0-9\.]+)/', $log_data, $mc_gross_matches);
    preg_match('/\[payment_date\]\s*=>\s*([^\n]+)/', $log_data, $payment_date_matches);
    preg_match('/\[payer_email\]\s*=>\s*([^\n]+)/', $log_data, $payer_email_matches);
    preg_match('/\[item_number\]\s*=>\s*(\d+)/', $log_data, $item_number_matches);
    preg_match('/\[quantity\]\s*=>\s*(\d+)/', $log_data, $quantity_matches);

    $monto = isset($mc_gross_matches[1]) ? $mc_gross_matches[1] : null;
    $fecha_venta = isset($payment_date_matches[1]) ? date('Y-m-d', strtotime($payment_date_matches[1])) : null;
    $usuario_id = 1;
    $producto_id = isset($item_number_matches[1]) ? $item_number_matches[1] : null;
    $cantidad = isset($quantity_matches[1]) ? $quantity_matches[1] : 1;

    if ($monto && $producto_id) {
        try {
            $data = [
                'usuario_id' => $usuario_id,
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'monto' => $monto,
                'fecha_venta' => $fecha_venta
            ];
            $venta->create($data);
            echo "Venta registrada correctamente.";
        } catch (Exception $e) {
            echo "Error al registrar la venta: " . $e->getMessage();
        }
    } else {
        echo "Datos insuficientes para registrar la venta.";
    }
} else {
    echo "Error al leer el archivo de log.";
}
?>