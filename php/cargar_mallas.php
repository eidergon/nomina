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
            $ingreso = !empty($datos[3]) ? rtrim($datos[3]) : '';
            $salida = !empty($datos[4]) ? rtrim($datos[4]) : '';

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

    // Obtener el primer y último día del mes
    $primer_dia_mes = date('Y-m-01');
    $ultimo_dia_mes = date('Y-m-t');

    // Obtener todas las fechas entre el primer y último día del mes
    $fechas_mes = array();
    $fecha_actual = $primer_dia_mes;
    while ($fecha_actual <= $ultimo_dia_mes) {
        $fechas_mes[] = $fecha_actual;
        $fecha_actual = date('Y-m-d', strtotime($fecha_actual . ' +1 day'));
    }

    // Obtener fechas presentes en el archivo Excel
    $fechas_excel = array();
    foreach ($lineas as $linea) {
        $datos = explode(";", $linea);
        $dia = !empty($datos[0]) ? $datos[0] : '';
        $fechas_excel[] = $dia;
    }

    // Obtener fechas faltantes del mes
    $fechas_faltantes = array_diff($fechas_mes, $fechas_excel);

    // Insertar registros para las fechas faltantes con los mismos datos de cédula y asesor
    foreach ($fechas_faltantes as $fecha) {
        $insertar = "INSERT INTO novedades (dia, cedula, asesor) 
                    VALUES ('$fecha', '$cedula', '$asesor')";

        if (mysqli_query($conn, $insertar)) {
            $insertedRecords++;
        } else {
            $errors++;
        }
    }

    if ($errors === 0) {
        $response['status'] = 'success';
        $response['message'] = 'Archivo subido correctamente.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al subir archivo.';
    }

    $response['total_records'] = $cantidad_regist_agregados;
    $response['inserted_records'] = $insertedRecords;
    $response['duplicados'] = $existente;

    header('Content-Type: application/json');
    echo json_encode($response);
    include_once("conexion_ocm_portabilidad.php");
    include_once("conexion_ocm_medellin.php");
    include_once("conexion_ocm_bogota.php");
    include_once("sql.php");
}
?>
