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
$row = $result->fetch_assoc();
?>

<?php if ($perfil == 'admin' || $perfil == 'SUPER WF') : ?>
    <form class="visualizar" id="visualizar">
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
                    <th>cedula</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Asesor</th>
                    <?php if ($perfil == 'SUPER WF' || $perfil == 'admin') : ?>
                        <th>Editar</th>
                    <?php else : ?>
                    <?php endif; ?>
                </tr>
            </thead>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tbody>
                    <tr scope='row'>
                        <td>
                            <?= $row["dia"] ?>
                        </td>
                        <td>
                            <?= $row["cedula"] ?>
                        </td>
                        <td>
                            <?= $row["ingreso"] ?>
                        </td>
                        <td>
                            <?= $row["salida"] ?>
                        </td>
                        <td>
                            <?= $row["asesor"] ?>
                        </td>
                        <?php if ($perfil == 'SUPER WF' || $perfil == 'admin') : ?>
                            <td>
                                <a class="link" data-form="edit_malla" data-id='<?= $row['id'] ?>'>
                                    <button class="edit-button">
                                        <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                            </path>
                                        </svg>
                                    </button>
                                </a>
                            </td>
                        <?php else : ?>
                        <?php endif; ?>
                    </tr>
                </tbody>
            <?php endwhile; ?>
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