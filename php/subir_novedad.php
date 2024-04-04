<?php
require_once 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['cedula']) && !empty($_POST['cedula'])) {
        $cedula = $_POST['cedula'];
        $fecha_novedad = $_POST['fecha_novedad'];
        $fecha_novedad2 = $_POST['fecha_novedad2'];
        $tipo_novedad = $_POST['novedades'];
        $nombre = $_POST['nombre'];
        $inicio = strtotime($fecha_novedad);
        $fin = strtotime($fecha_novedad2);

        while ($inicio <= $fin) {
            $fecha_actual = date("Y-m-d", $inicio);

            $checkQuery = "SELECT cedula FROM info_malla WHERE cedula = '$cedula' AND dia = '$fecha_actual'";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                // Si no hay entradas para esa cédula y fecha, inserta un nuevo registro
                $insertQuery = "INSERT INTO info_malla (cedula, dia, novedad, supervisor) VALUES ('$cedula', '$fecha_actual', '$tipo_novedad', '$nombre')";
                if (mysqli_query($conn, $insertQuery)) {
                    $response['status'] = 'success';
                    $response['message'] = "Novedad agregada";
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Error al insertar novedad: " . mysqli_error($conn);
                }
            } else {
                // Si ya hay una entrada para esa cédula y fecha, actualiza el registro existente
                $updateQuery = "UPDATE info_malla SET novedad = '$tipo_novedad', supervisor = '$nombre' WHERE cedula = '$cedula' AND dia = '$fecha_actual'";
                if (mysqli_query($conn, $updateQuery)) {
                    $response['status'] = 'success';
                    $response['message'] = "Novedad actualizada";
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Error al actualizar novedad: " . mysqli_error($conn);
                }
            }

            // Incrementa la fecha actual en un día
            $inicio = strtotime("+1 day", $inicio);
        }
    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
