<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$user = $_SESSION["Cc_user"];

require_once 'conexion.php';
$mes = intval($_GET['mes']);
$anio = intval($_GET['anio']);
$value = $_GET['value'];

if ($value == 'anterior') {
    if ($mes == 1) {
        $mes_anterior = 12;
        $anio -= 1;
    } else {
        $mes_anterior = $mes - 1;
    }
    $mes_formato = str_pad($mes_anterior, 2, "0", STR_PAD_LEFT);
    $sql = "SELECT * FROM info_malla WHERE cedula = '$user' AND ((DATE_FORMAT(dia, '%m-%Y') = '$mes_formato-$anio'))";
} elseif ($value == 'siguiente') {
    if ($mes == 12) {
        $mes_siguiente = 1;
        $anio += 1;
    } else {
        $mes_siguiente = $mes + 1;
    }
    $mes_formato = str_pad($mes_siguiente, 2, "0", STR_PAD_LEFT);
    $sql = "SELECT * FROM info_malla WHERE cedula = '$user' AND ((DATE_FORMAT(dia, '%m-%Y') = '$mes_formato-$anio'))";
}


$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total = 0;
?>

<?php if ($result->num_rows > 0) : ?>
    <div class="btn" id="controles">
        <button class="mes" data-mes="anterior" id="mesAnterior">Mes Anterior</button>
        <h3>Informacion Del Mes <?php echo $mes_formato ?> - <?php echo $anio ?></h3>
        <input type="hidden" id="mes" value="<?php echo $mes_formato ?>">
        <input type="hidden" id="anio" value="<?php echo $anio ?>">
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
                <th>Minutos De Tardanza</th>
                <th>Descuento</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <?php $tiempo_en_horas = $row["tiempo"] / 3600; ?>
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
                    <?php if ($row["tardanza"] == "Injustificada") : ?>
                        <?php $ingreso = new DateTime($row["ingreso"]);
                        $inicio = new DateTime($row["inicio"]);
                        $diferencia = $ingreso->diff($inicio);
                        $minutos_diferencia = $diferencia->format('%i'); ?>
                        <td><?= $minutos_diferencia ?>M</td>
                        <td>$<?= number_format($descuento = ($minutos_diferencia / 60) * 5532, 0, '', '.') ?></td>
                        <?php $total = $total + $descuento ?>
                    <?php else : ?>
                        <td></td>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <h3><?php echo "Descuento Total: $" . number_format($total, 0, '', '.') ?></h3>
    </table>
<?php else : ?>
    <div class="btn" id="controles">
        <button class="mes" data-mes="anterior" id="mesAnterior">Mes Anterior</button>
        <h3>Informacion Del Mes <?php echo $mes_formato ?> - <?php echo $anio ?></h3>
        <input type="hidden" id="mes" value="<?php echo $mes_formato ?>">
        <input type="hidden" id="anio" value="<?php echo $anio ?>">
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
                <th>Minutos De Tardanza</th>
                <th>Descuento</th>
            </tr>
        </thead>
        <tbody>
            <tr scope='row'>
                <td colspan='11' class='no-data'>Sin Datos</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
<script src="../js/script.js"></script>