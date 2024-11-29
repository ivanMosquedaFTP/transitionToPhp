<?php
// Ruta del archivo de log
// $log_file = '../../../admin/views/producto/log_ipn.txt';
$log_file = 'log_ipn.txt';

// Leer el archivo de log
$log_data = file_get_contents($log_file);

// Verificar si el archivo se ha leído correctamente
if ($log_data !== false) {
    // Buscar los valores específicos en el archivo de log usando expresiones regulares
    preg_match('/\[mc_gross\]\s*=>\s*([0-9\.]+)/', $log_data, $mc_gross_matches);
    preg_match('/\[payment_date\]\s*=>\s*([^\n]+)/', $log_data, $payment_date_matches);
    preg_match('/\[payer_email\]\s*=>\s*([^\n]+)/', $log_data, $payer_email_matches);
    preg_match('/\[item_number\]\s*=>\s*(\d+)/', $log_data, $item_number_matches);
    preg_match('/\[quantity\]\s*=>\s*(\d+)/', $log_data, $quantity_matches);

    // Asignar los valores encontrados o un valor por defecto si no se encuentran
    $mc_gross = isset($mc_gross_matches[1]) ? $mc_gross_matches[1] : 'No disponible';
    $payment_date = isset($payment_date_matches[1]) ? $payment_date_matches[1] : 'No disponible';
    $payer_email = isset($payer_email_matches[1]) ? $payer_email_matches[1] : 'No disponible';
    $item_number = isset($item_number_matches[1]) ? $item_number_matches[1] : 'No disponible';
    $quantity = isset($quantity_matches[1]) ? $quantity_matches[1] : 'No disponible';

    // Mostrar los datos en la página
    echo "<h3>Detalles de la transacción:</h3>";
    echo "Monto: " . $mc_gross . "<br>";
    echo "Fecha de pago: " . $payment_date . "<br>";
    echo "Email del pagador: " . $payer_email . "<br>";
    echo "Número del producto: " . $item_number . "<br>";
    echo "Cantidad: " . $quantity . "<br>";
} else {
    echo "Error al leer el archivo de log.";
}
?>