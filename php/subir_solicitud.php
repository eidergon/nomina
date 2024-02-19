<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $solicitud = $_POST['solicitud'];
    $correo = $_POST['correo'];
    $ciudad = $_POST['ciudad'];
    $user = $_POST['user'];
    $fecha = $_POST['fecha_solicitud'];

    $sql = "INSERT INTO tiket (nombre, correo, sede, solicitud, cedula, fecha) 
    values ('$nombre', '$correo', '$ciudad', '$solicitud', '$user', '$fecha')";

    if (mysqli_query($conn, $sql)) {
        $response['status'] = 'success';
        $response['message'] = "Solicitud subida";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error al subir la solicitud: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
