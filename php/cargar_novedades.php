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
    
            $cedula = !empty($datos[0]) ? ($datos[0]) : '';
            $fecha_novedad = !empty($datos[1]) ? ($datos[1]) : '';
            $tipo_novedad = !empty($datos[2]) ? ($datos[2]) : '';
            $nombre = !empty($datos[3]) ? rtrim($datos[3]) : '';
    
            $checkQuery = "SELECT cedula, dia FROM info_malla WHERE cedula = '$cedula' AND dia = '$fecha_novedad'";
            $checkResult = mysqli_query($conn, $checkQuery);
    
            if (mysqli_num_rows($checkResult) > 0) {
                $sql = "UPDATE info_malla SET novedad = '$tipo_novedad', supervisor = '$nombre' WHERE cedula = '$cedula' AND dia = '$fecha_novedad'";
                if (mysqli_query($conn, $sql)) {
                    $insertedRecords++;
                } else {
                    $errors++;
                    $existente++;
                }
            } else {
                // Si el registro no existe, insertarlo
                $sql = "INSERT INTO info_malla (cedula, dia, novedad, supervisor) VALUES ('$cedula', '$fecha_novedad', '$tipo_novedad', '$nombre')";
                if (mysqli_query($conn, $sql)) {
                    $insertedRecords++;
                } else {
                    $errors++;
                }
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
