<?php
// Leer los datos enviados por PayPal
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = [];
foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2) {
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
}

// Validar la notificación con PayPal
$req = 'cmd=_notify-validate';
foreach ($myPost as $key => $value) {
    $value = urlencode($value);
    $req .= "&$key=$value";
}

// Enviar solicitud de validación
$ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
$response = curl_exec($ch);
curl_close($ch);

// Validar la respuesta de PayPal
if (strcmp($response, "VERIFIED") == 0) {
    // Datos válidos, procesa la transacción
    file_put_contents('log_ipn.txt', print_r($myPost, true), FILE_APPEND);

    // Ejemplo: Imprime los datos de la transacción
    echo "<h3>Notificación de PayPal IPN</h3>";
    echo "<pre>";
    print_r($myPost);
    echo "</pre>";
} else {
    // Notificación inválida
    echo "IPN inválido.";
}
?>