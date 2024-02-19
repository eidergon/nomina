<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $tipo_documento = $_POST['tipo_documento'];
        $cc_user = $_POST['cc_user'];
        $contraseña = $_POST['contraseña'];
        $fecha = $_POST['fecha'];
        $hora_contrato = $_POST['hora_contrato'];
        $jefe = $_POST['jefe'];
        $campaña = $_POST['campaña'];
        $sub_campaña = $_POST['sub_campaña'];
        $cargo = $_POST['cargo'];
        $eps = $_POST['eps'];
        $ciudad = $_POST['ciudad'];
        $perfil = $_POST['perfil'];
        $estado = 1;

        $checkQuery = "SELECT Cc_user FROM login WHERE Cc_user = '$cc_user'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Empleado ya existente.';
        } else {
            $sql = "INSERT INTO login (nombre, tipo_documento, Cc_user, pass, Fecha_ingreso, Hora_contrato, jefe_inmediato, campaña, subcampaña, cargo, eps, ciudad, perfil, estado) 
            VALUES ('$nombre', '$tipo_documento', '$cc_user', '$contraseña', '$fecha', '$hora_contrato', '$jefe', '$campaña', '$sub_campaña', '$cargo', '$eps', '$ciudad', '$perfil', '$estado')";

            if (mysqli_query($conn, $sql)) {
                $response['status'] = 'success';
                $response['message'] = 'Empleado agregado correctamente.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al subir empleado: ' . mysqli_error($conn);
            }
        }

    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}

header('Content-Type: application/json');
echo json_encode($response);
