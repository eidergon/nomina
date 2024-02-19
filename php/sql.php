<?php
require_once 'conexion.php';


// Consulta 2
$sql2 = "UPDATE info_malla
        SET tardanza = 'Injustificada'
        WHERE TIMEDIFF(STR_TO_DATE(inicio, '%H:%i:%s'), STR_TO_DATE(ingreso, '%H:%i:%s')) >= '00:05:00'
        AND inicio IS NOT NULL AND tardanza IS NULL";

if ($conn->query($sql2) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}

// Consulta 3
$sql3 = "UPDATE info_malla 
        INNER JOIN login ON info_malla.cedula = login.Cc_user SET info_malla.turno = 'Completo' 
        WHERE (info_malla.tiempo / 3600) > (login.Hora_contrato / 2)";

if ($conn->query($sql3) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}

// Consulta 4
$sql4 = "UPDATE info_malla 
        INNER JOIN login ON info_malla.cedula = login.Cc_user SET info_malla.turno = 'Incompleto' 
        WHERE (info_malla.tiempo / 3600) < (login.Hora_contrato / 2)";

if ($conn->query($sql4) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}

// Consulta 5
$sql5 = "UPDATE info_malla SET novedad = 'DESCANSO', turno = 'DESCANSO', tardanza = 'DESCANSO'
        WHERE ingreso = 'DESCANSO' and novedad is null";

if ($conn->query($sql5) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}

// Consulta 6
$currentDate = date("Y-m-d");
$sql6 = "UPDATE info_malla SET novedad = 'INJUSTIFICADA' WHERE ingreso != 'DESCANSO' and inicio is null AND DATE(dia) < '$currentDate' and novedad is null";

if ($conn->query($sql6) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}