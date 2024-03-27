<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$perfil = $_SESSION["perfil"];
$user = $_SESSION["Cc_user"];

require_once '../php/conexion.php';
$mes_actual = date('m');
$anio_actual = date('Y');
$mes_pasado = date('m', strtotime('-1 month'));
$mes_siguiente = date('m', strtotime('+1 month'));

$sql = "SELECT * FROM info_malla WHERE cedula = '$user' AND ((DATE_FORMAT(dia, '%m-%Y') = '$mes_actual-$anio_actual'))";


$result = $conn->query($sql);
?>

<?php if ($result->num_rows > 0) : ?>
    <div class="ee" id="ee">
        <div class="btn" id="controles">
            <button class="mes" data-mes="anterior" id="mesAnterior">Mes Anterior</button>
            <h3>Informacion Del Mes <?php echo $mes_actual ?> - <?php echo $anio_actual ?></h3>
            <input type="hidden" id="mes" value="<?php echo $mes_actual ?>">
            <input type="hidden" id="anio" value="<?php echo $anio_actual ?>">
            <button class="mes" data-mes="siguiente" id="mesSiguiente">Mes Siguiente</button>
        </div>

        <table class='table' id="table">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora De Ingreso</th>
                    <th>Hora De Salida</th>
                    <th>Hora De Logueo</th>
                    <th>Hora De Deslogueo</th>
                    <th>Tiempo</th>
                    <th>Turno</th>
                    <th>Tardanza</th>
                    <th>Novedad</th>
                </tr>
            </thead>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <?php $tiempo_en_horas = $row["tiempo"] / 3600;?>
                <tbody>
                    <tr scope='row'>
                        <td><?= $row["dia"] ?></td>
                        <td><?= $row["ingreso"] ?></td>
                        <td><?= $row["salida"] ?></td>
                        <td><?= $row["inicio"] ?></td>
                        <td><?= $row["final"] ?></td>
                        <td><?= floor($tiempo_en_horas) . "H:" . str_pad(round(($tiempo_en_horas - floor($tiempo_en_horas)) * 60), 2, "0", STR_PAD_LEFT) . "M"; ?></td>
                        <td><?= $row["turno"] ?></td>
                        <td><?= $row["tardanza"] ?></td>
                        <td><?= $row["novedad"] ?></td>
                    </tr>
                </tbody>
            <?php endwhile; ?>
        </table>
    </div>
<?php else : ?>
    <div class="ee" id="ee">
        <div class="btn" id="controles">
            <button class="mes" data-mes="anterior" id="mesAnterior">Mes Anterior</button>
            <h3>Informacion Del Mes <?php echo $mes_actual ?> - <?php echo $anio_actual ?></h3>
            <input type="hidden" id="mes" value="<?php echo $mes_actual ?>">
            <input type="hidden" id="anio" value="<?php echo $anio_actual ?>">
            <button class="mes" data-mes="siguiente" id="mesSiguiente">Mes Siguiente</button>
        </div>
        <table class='table' id="table">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Ingreso</th>
                    <th>Logueo</th>
                    <th>Tiempo</th>
                    <th>Turno</th>
                    <th>Tardanza</th>
                    <th>Novedad</th>
                </tr>
            </thead>
            <tbody>
                <tr scope='row'>
                    <td colspan='7' class='no-data'>Sin Datos</td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<script src="../js/script.js"></script>