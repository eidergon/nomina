<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}
$perfil = $_SESSION["perfil"];
require_once 'conexion.php';

if (isset($_POST['busqueda'])) {
    $termino = $_POST['busqueda'];

    $anio_mes_actual = date('Y-m');
    $anio_mes_pasado = date('Y-m', strtotime('-1 month'));

    if (date('m') == '01') {
        $anio_pasado = date('Y', strtotime('-1 year'));
        $sql = "SELECT * FROM info_malla WHERE cedula = '$termino' AND 
            (DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_actual' OR 
            DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_pasado' OR 
            DATE_FORMAT(dia, '%Y-%m') = '$anio_pasado-12') ORDER BY dia DESC";
    } else {
        $sql = "SELECT * FROM info_malla WHERE cedula = '$termino' AND 
            (DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_actual' OR 
            DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_pasado') ORDER BY dia DESC";
    }

    $result = $conn->query($sql);
} else {
    $termino = $_GET['cedula'];

    $anio_mes_actual = date('Y-m');
    $anio_mes_pasado = date('Y-m', strtotime('-1 month'));

    if (date('m') == '01') {
        $anio_pasado = date('Y', strtotime('-1 year'));
        $sql = "SELECT * FROM info_malla WHERE cedula = '$termino' AND 
            (DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_actual' OR 
            DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_pasado' OR 
            DATE_FORMAT(dia, '%Y-%m') = '$anio_pasado-12') ORDER BY dia DESC";
    } else {
        $sql = "SELECT * FROM info_malla WHERE cedula = '$termino' AND 
            (DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_actual' OR 
            DATE_FORMAT(dia, '%Y-%m') = '$anio_mes_pasado') ORDER BY dia DESC";
    }

    $result = $conn->query($sql);
}

$conn->close();
?>

<form class="visualizar" id="visualizar2">
    <div class="container-input">
        <input type="text" name="busqueda" autocomplete="off" placeholder="Ingrese Cédula" name="text" class="input">
        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
        </svg>
    </div>
</form>
<?php if ($result->num_rows > 0) : ?>
    <table class='table' id="table">
        <thead>
            <tr>
                <th>Día</th>
                <th>cedula</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Asesor</th>
                <th>Tiempo</th>
                <th>Novedad</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <?php $tiempo_en_horas = $row["tiempo"] / 3600;?>
                <tr scope='row'>
                    <td><?= $row["dia"] ?></td>
                    <td><?= $row["cedula"] ?></td>
                    <td><?= $row["ingreso"] ?></td>
                    <td><?= $row["salida"] ?></td>
                    <td><?= $row["asesor"] ?></td>
                    <td><?= floor($tiempo_en_horas) . "H:" . str_pad(round(($tiempo_en_horas - floor($tiempo_en_horas)) * 60), 2, "0", STR_PAD_LEFT) . "M"; ?></td>
                    <td><?= $row["novedad"] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <table class='table' id="table">
        <thead>
            <tr>
                <th>Día</th>
                <th>cedula</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Asesor</th>
            </tr>
        </thead>
        <tbody>
            <tr scope='row'>
                <td colspan='5' class='no-data'>Sin Datos</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
<script src="../js/script.js"></script>