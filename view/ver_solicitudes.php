<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$perfil = $_SESSION["perfil"];
$user = $_SESSION["Cc_user"];

require_once '../php/conexion.php';

$sql = "SELECT * FROM tiket WHERE cedula = '$user' ORDER BY id desc";
$result = mysqli_query($conn, $sql);
?>

<?php if ($result->num_rows > 0) : ?>
    <table class='table'>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Sede</th>
                <th>Solicitud</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr scope='row'>
                    <td>
                        <?= $row["fecha"] ?>
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
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha</th>
                <th>Sede</th>
                <th>Solicitud</th>
            </tr>
        </thead>
        <tbody>
            <tr scope='row'>
                <td colspan='5' class='no-data'>Sin Datos</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>