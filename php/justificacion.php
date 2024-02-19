<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dia = $_POST['dia'];
    $cedula = $_POST['cedula'];
    $tardanza = $_POST['tardanza'];
    $nombre = $_POST['nombre'];
    $motivo = $_POST['motivo'];

    if ($tardanza === 'Injustificada') {
        $sql = "UPDATE info_malla SET tardanza = '$tardanza', aprobacion = null, motivo = null WHERE dia = '$dia' AND cedula = '$cedula'";
    } else {
        $sql = "UPDATE info_malla SET tardanza = '$tardanza', aprobacion = '$nombre', motivo = $motivo WHERE dia = '$dia' AND cedula = '$cedula'";
    }

    if (mysqli_query($conn, $sql)) {
        $response['status'] = 'success';
        $response['message'] = "Actualización exitosa";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error en la actualización: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}

header('Content-Type: application/json');
echo json_encode($response);
