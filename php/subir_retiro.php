<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha_retiro'];
    $cedula = $_POST['cedula'];

    $sql = "UPDATE login SET fecha_retiro = '$fecha' WHERE Cc_user = '$cedula'";

    if (mysqli_query($conn, $sql)) {
        $response['status'] = 'success';
        $response['message'] = "Retiro Agregado";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error al agregar retiro: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
