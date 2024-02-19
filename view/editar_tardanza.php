<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../');
        exit();
    }
    $nombre = $_SESSION["nombre"];

    require_once '../php/conexion.php';
    $dia_get = $_GET['dia'];
    $cedula_get = $_GET['cedula'];

    $sql = "SELECT * FROM info_malla WHERE dia = '$dia_get' AND cedula = '$cedula_get'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

?>
<form class="form" id="edit_tarda">
    <input class="input" type="hidden" name="nombre" value="<?php echo $nombre; ?>" readonly>
    <br>
    <label for="">Día laboral</label>
    <input class="input" type="date" name="dia" value="<?php echo $row["dia"]; ?>" readonly>
    <label for="">Asesor</label>
    <input class="input" type="text" name="asesor" value="<?php echo $row["asesor"]; ?>" readonly>
    <input class="input" type="hidden" name="cedula" value="<?php echo $row["cedula"]; ?>" readonly>
    <label for="">Hora de ingreso</label>
    <input class="input" type="text" name="ingreso" value="<?php echo $row["ingreso"]; ?>" readonly>
    <label for="">Hora de Logueo</label>
    <input class="input" type="text" name="inicio" value="<?php echo $row["inicio"]; ?>" readonly>
    <label>
        Tardanza
        <select class="input" name="tardanza" id="tardanza">
            <option value="Injustificada">Injustificada</option>
            <option value="Justificada">Justificada</option>
        </select>
    </label>
    <label class="hidden" id="motivo_label">
        Motivo
        <select name="motivo" id="motivo" class="input">
            <option value="">---Seleccionar---</option>
            <option value="Cumplimiento en Ventas">Cumplimiento en Ventas</option>
            <option value="Acelerador de tiempo">Acelerador de tiempo</option>
            <option value="Pago de tiempo">Pago de tiempo</option>
        </select>
    </label>
    <div class="eg">
        <button class="button"><p class="submit">Guardar</p></button>
        <a href="#" class="volver" data-dia='<?= $row['dia'] ?>' data-form="consulta_tardanza"><button class="button"><p class="submit">Volver</p></button></a>
    </div>
</form>

<script src="../js/script.js"></script>