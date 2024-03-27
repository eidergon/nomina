<?php
require_once 'conexion.php';

// Consulta 1
$sql = "UPDATE info_malla
        SET tardanza = null
        WHERE TIMEDIFF(inicio, ingreso) <= '00:05:00'
        AND inicio IS NOT NULL";

if ($conn->query($sql) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}

// Consulta 2
$sql2 = "UPDATE info_malla
        SET tardanza = 'Injustificada'
        WHERE TIMEDIFF(inicio, ingreso) > '00:05:00'
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

// Consulta 6
$currentDate = date("Y-m-d");
$sql6 = "UPDATE info_malla SET novedad = 'INJUSTIFICADA' WHERE inicio is null AND DATE(dia) < '$currentDate' and novedad is null";

if ($conn->query($sql6) === TRUE) {
    // echo "Consulta 2 ejecutada correctamente";
} else {
    // echo "Error en la consulta 2: " . $conn->error;
}