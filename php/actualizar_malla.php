<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dia = $_POST['dia'];
    $asesor = $_POST['asesor'];
    $cedula = $_POST['cedula'];
    $ingreso = $_POST['ingreso'];
    $salida = $_POST['salida'];

    $sql = "UPDATE info_malla SET ingreso = '$ingreso', salida = '$salida' WHERE dia = '$dia' AND cedula = '$cedula'";

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
?>