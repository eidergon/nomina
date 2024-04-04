<?php
require_once 'conexion.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_FILES['archivo_excel']['type'];
    $tamanio = $_FILES['archivo_excel']['size'];
    $archivotmp = $_FILES['archivo_excel']['tmp_name'];
    $lineas = file($archivotmp);

    $i = 0;
    $errors = 0;
    $insertedRecords = 0;
    $existente = 0;

    foreach ($lineas as $linea) {
        $cantidad_registros = count($lineas);
        $cantidad_regist_agregados = ($cantidad_registros - 1);

        if ($i != 0) {
            $datos = explode(";", $linea);

            $nombre = !empty($datos[0]) ? ($datos[0]) : '';
            $tipo_documento = !empty($datos[1]) ? ($datos[1]) : '';
            $cc_user = !empty($datos[2]) ? ($datos[2]) : '';
            $contraseña = !empty($datos[3]) ? ($datos[3]) : '';
            $fecha = !empty($datos[4]) ? date('Y-m-d', strtotime($datos[4])) : '';
            $hora_contrato = !empty($datos[5]) ? ($datos[5]) : '';
            $jefe = !empty($datos[6]) ? ($datos[6]) : '';
            $campaña = !empty($datos[7]) ? ($datos[7]) : '';
            $sub_campaña = !empty($datos[8]) ? ($datos[8]) : '';
            $cargo = !empty($datos[9]) ? ($datos[9]) : '';
            $eps = !empty($datos[10]) ? ($datos[10]) : '';
            $ciudad = !empty($datos[11]) ? ($datos[11]) : '';
            $perfil = !empty($datos[12]) ? ($datos[12]) : '';
            $estado = !empty($datos[13]) ? ($datos[13]) : '';

            $checkQuery = "SELECT Cc_user FROM login WHERE Cc_user = '$cc_user'";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                $sql = "INSERT INTO login (nombre, tipo_documento, Cc_user, pass, Fecha_ingreso, Hora_contrato, jefe_inmediato, campaña, subcampaña, cargo, eps, ciudad, perfil, estado) 
                    VALUES ('$nombre', '$tipo_documento', '$cc_user', '$contraseña', '$fecha', '$hora_contrato', '$jefe', '$campaña', '$sub_campaña', '$cargo', '$eps', '$ciudad', '$perfil', '$estado')";

                if (mysqli_query($conn, $sql)) {
                    $insertedRecords++;
                } else {
                    $errors++;
                }
            } else {
                $existente++;
            }
        }

        $i++;
    }

    if ($errors === 0) {
        $response['status'] = 'success';
        $response['message'] = 'Archivo subido correctamente.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al subir archivo. Detalles: ' . $e->getMessage();
    }

    $response['total_records'] = $cantidad_regist_agregados;
    $response['inserted_records'] = $insertedRecords;
    $response['duplicados'] = $existente;
    header('Content-Type: application/json');
    echo json_encode($response);
}
