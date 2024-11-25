<?php
if (isset($_GET['PayerID'])) {
    $payer_id = $_GET['PayerID'];

    // Credenciales de la API de PayPal
    $paypal_user = 'sb-thsd034331470_api1.business.example.com'; // Reemplaza con tu usuario de la API
    $paypal_password = 'G9A4Y7DB24TGUS8S'; // Reemplaza con tu contraseña de la API
    $paypal_signature = 'AStwKS3.L4rNUPfkl7TOO9eahVmAAZHGKtmjCPS938-Pb4z0ATyPVfYW'; // Reemplaza con tu firma de la API
    $endpoint = "https://api-3t.sandbox.paypal.com/nvp";

    // Parámetros para consultar los detalles de la transacción
    $params = [
        "METHOD" => "GetTransactionDetails", // Método alternativo para usar con PayerID
        "USER" => $paypal_user,
        "PWD" => $paypal_password,
        "SIGNATURE" => $paypal_signature,
        "VERSION" => "204.0",
        "PAYERID" => $payer_id, // Usa solo el PayerID si el token no está disponible
    ];

    // Realiza la solicitud a la API de PayPal
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    // Convierte la respuesta en un arreglo
    parse_str($response, $parsed_response);

    // Verifica si la solicitud fue exitosa
    if ($parsed_response["ACK"] == "Success") {
        echo "<h3>Detalles de la Transacción</h3>";
        echo "<pre>";
        print_r($parsed_response); // Imprime todos los datos de la transacción
        echo "</pre>";
    } else {
        echo "<h3>Error al obtener detalles de la transacción:</h3>";
        echo "<pre>";
        print_r($parsed_response); // Imprime el error devuelto por PayPal
        echo "</pre>";
    }
} else {
    echo "No se recibió el PayerID en la URL.";
}
?>