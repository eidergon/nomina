<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}
require_once 'conexion.php';

if (isset($_POST['fecha'])) {
    $termino = $_POST['fecha'];

    $sql = "SELECT * FROM tiket WHERE fecha_peticion = '$termino' order by fecha_peticion desc";

    $result = $conn->query($sql);
}

$conn->close();
?>

<form class="visualizar" id="filtrar">
    <div class="container-input">
        <input type="date" name="fecha" class="input date">
        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
        </svg>
        <button class="envia" type="submit">enviar</button>
    </div>
</form>

<?php if ($result->num_rows > 0) : ?>
    <table class='table'>
        <thead>
            <tr>
                <th>Fecha Petición</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Sede</th>
                <th>Solicitud</th>
                <th>Fecha Programada</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr scope='row'>
                    <td>
                        <?= $row["fecha_peticion"] ?>
                    </td>
                    <td>
                        <?= $row["nombre"] ?>
                    </td>
                    <td>
                        <?= $row["cedula"] ?>
                    </td>
                    <td>
                        <?= $row["sede"] ?>
                    </td>
                    <td>
                        <?= $row["solicitud"] ?>
                    </td>
                    <td>
                        <?= $row["fecha"] ?>
                    </td>
                    <td>
                        <?= $row["correo"] ?>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <table class='table'>
        <thead>
            <tr>
                <th>Fecha Petición</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Sede</th>
                <th>Solicitud</th>
                <th>Fecha Programada</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <tr scope='row'>
                <td colspan='7' class='no-data'>Sin Datos</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
<script src="../js/script.js"></script>