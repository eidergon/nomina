<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$perfil = $_SESSION["perfil"];
$nombre = $_SESSION["nombre"];

$partesNombre = explode(" ", $nombre);
$primerNombre = $partesNombre[0];
require_once 'conexion.php';

if (isset($_POST['fecha'])) {
    $termino = $_POST['fecha'];

    if ($perfil == 'admin') {
        $sql = "SELECT * FROM info_malla
        WHERE dia  = '$termino' AND tardanza = 'injustificada'";
    } else {
        $sql = "SELECT * FROM info_malla inner join login on info_malla.cedula = login.Cc_user
        WHERE login.Jefe_inmediato LIKE '%$primerNombre%' 
        AND info_malla.dia = '$termino' AND tardanza = 'injustificada'";
    }

    $result = $conn->query($sql);
} else {
    $termino = $_GET['dia'];

    if ($perfil == 'admin') {
        $sql = "SELECT * FROM info_malla
        WHERE dia = '$termino' AND tardanza = 'injustificada'";
    } else {
        $sql = "SELECT * FROM info_malla inner join login on info_malla.cedula = login.Cc_user
        WHERE login.Jefe_inmediato LIKE '%$primerNombre%' 
        AND info_malla.dia = '$termino' AND tardanza = 'injustificada'";
    }

    $result = $conn->query($sql);
}
$conn->close();
?>

<form class="visualizar" id="tardanza">
    <div class="container-input">
        <input type="date" name="fecha" class="input date">
        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
        </svg>
        <button type="submit" class="envia">enviar</button>
    </div>
</form>
<?php if ($result->num_rows > 0) : ?>
    <table class='table'>
        <tr>
            <th>Día</th>
            <th>Asesor</th>
            <th>Ingreso</th>
            <th>Logueo</th>
            <th>Turno</th>
            <th>Tardanza</th>
            <th>Editar</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr scope='row'>
                <td>
                    <?php echo $row["dia"]; ?>
                </td>
                <td>
                    <?php echo $row["asesor"]; ?>
                </td>
                <td>
                    <?php echo $row["ingreso"]; ?>
                </td>
                <td>
                    <?php echo $row["inicio"]; ?>
                </td>
                <td>
                    <?php echo $row["turno"]; ?>
                </td>
                <td>
                    <?php echo $row["tardanza"]; ?>
                </td>
                <td>
                    <button class="link edit" data-form="editar_tardanza" data-cedula='<?= $row['cedula'] ?>' data-dia='<?= $row['dia'] ?>'>
                        <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="#FFFFFF" height="24" width="24" viewBox="0 0 24 24">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                        Edit
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else : ?>
    <table class='table'>
        <tr>
            <th>Día</th>
            <th>Asesor</th>
            <th>Ingreso</th>
            <th>Logueo</th>
            <th>Turno</th>
            <th>Tardanza</th>
        </tr>
        <tr scope='row'>
            <td colspan='6' class='no-data'>Sin Datos</td>
        </tr>
    </table>
<?php endif; ?>
<script src="../js/script.js"></script>