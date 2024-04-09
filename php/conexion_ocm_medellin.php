<?php
$servername_source = "200.7.103.57";
$username_source = "reportesoc";
$password_source = "fu1epOX3";
$database_source = "ocmdb";

$servername_destination = "localhost";
$username_destination = "root";
$password_destination = "";
$database_destination = "solicitud";

// Create source connection
$conn_source = new mysqli($servername_source, $username_source, $password_source, $database_source);

// Check source connection
if ($conn_source->connect_error) {
    die("Source Connection failed: " . $conn_source->connect_error);
}

$fechaActual = date("Y-m-d");
$fechaTresDiasAtras = date("Y-m-d", strtotime("-3 days", strtotime($fechaActual)));

$sql = "SELECT agent, DATE(fecha) as Dia, SUM(segundos) as Tiempo, MIN(TIME(fecha)) AS Inicio, MAX(TIME(fecha)) AS Final
        FROM ocm_log_agentstatus
        WHERE fecha >= '$fechaTresDiasAtras 00:00:00' AND fecha <= '$fechaActual 23:59:59'
        GROUP BY agent, Dia";

$result = $conn_source->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $conn_destination = new mysqli($servername_destination, $username_destination, $password_destination, $database_destination);

        if ($conn_destination->connect_error) {
            die("Destination Connection failed: " . $conn_destination->connect_error);
        }

        while ($row = $result->fetch_assoc()) {
            $agent = $row["agent"];
            $dia = $row["Dia"];
            $tiempo = $row["Tiempo"];
            $inicio = $row["Inicio"];
            $final = $row["Final"];

            $insert_query = "UPDATE info_malla SET tiempo = '$tiempo', inicio = '$inicio', final = '$final' WHERE cedula = '$agent' AND dia = '$dia'";
            $conn_destination->query($insert_query);
        }

        $conn_destination->close();
    } else {
        echo "No results found";
    }
} else {
    echo "Error in query: " . $conn_source->error;
}

$conn_source->close();
?>

