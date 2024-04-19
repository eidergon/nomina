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

$sql = "SELECT * FROM info_malla WHERE cedula = '$user' AND ((DATE_FORMAT(dia, '%m-%Y') = '$mes_actual-$anio_actual'))";


$result = $conn->query($sql);
$total = 0;
?>

<?php if ($perfil == 'admin' || $perfil == 'SUPERVISOR' || $perfil === 'SUPER OP') : ?>
    <form class="visualizar" id="visualizar2">
        <div class="container-input">
            <input type="text" name="busqueda" autocomplete="off" placeholder="Ingrese Cédula" name="text" class="input">
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
            </svg>
        </div>
    </form>
<?php else : ?>
    <?php if ($result->num_rows > 0) : ?>
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
                    <th>Minutos de tardanza</th>
                    <th>Descuento</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
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
<?php endif; ?>
<script src="../js/script.js"></script>