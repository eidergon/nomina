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

            $dia = !empty($datos[0]) ? ($datos[0]) : '';
            $cedula = !empty($datos[1]) ? ($datos[1]) : '';
            $asesor = !empty($datos[2]) ? ($datos[2]) : '';
            $ingreso = !empty($datos[3]) ? ($datos[3]) : '';
            $salida = !empty($datos[4]) ? ($datos[4]) : '';

            $checkQuery = "SELECT cedula, dia FROM info_malla WHERE cedula = '$cedula' AND dia = '$dia'";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                $insertar = "INSERT INTO info_malla (dia, cedula, asesor, ingreso, salida) 
                VALUES ('$dia', '$cedula', '$asesor', '$ingreso', '$salida')";

                if (mysqli_query($conn, $insertar)) {
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
    include_once("conexion_ocm.php");
    include_once("sql.php");
}