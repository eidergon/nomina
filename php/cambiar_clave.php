<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['clave'])  && !empty($_POST['clave'])) {
        $clave = $_POST['clave'];
        $user = $_POST['user'];

        $sql = "UPDATE login SET pass = '$clave' WHERE Cc_user = '$user'";

        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = "Clave cambiada exitosamente.";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error en la actualización: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}

header('Content-Type: application/json');
echo json_encode($response);
