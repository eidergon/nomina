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

        $checkQuery = "SELECT cedula, dia FROM info_malla WHERE cedula = '$cedula' AND dia = '$fecha_novedad' AND novedad IS NOT NULL AND supervisor IS NOT NULL";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Ya tiene una novedad el dia ' . $fecha_novedad;
        } else {
            while ($inicio <= $fin) {
                // Formatear la fecha actual del ciclo al formato deseado, p.ej., Y-m-d
                $fecha_actual = date("Y-m-d", $inicio);

                // Tu consulta SQL y ejecución
                $sql = "UPDATE info_malla SET novedad = '$tipo_novedad', supervisor = '$nombre' WHERE cedula = '$cedula' AND dia = '$fecha_actual'";

                if (mysqli_query($conn, $sql)) {
                    $response['status'] = 'success';
                    $response['message'] = "Novedad agregada";
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Error al subir novedad: " . mysqli_error($conn);
                }

                // Incrementar la fecha actual en un día
                $inicio = strtotime("+1 day", $inicio);
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
