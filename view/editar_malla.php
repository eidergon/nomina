<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../');
        exit();
    }

    require_once '../php/conexion.php';
    $dia_get = $_GET['dia'];
    $cedula_get = $_GET['cedula'];

    $sql = "SELECT * FROM info_malla WHERE dia = '$dia_get' AND cedula = '$cedula_get'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

?>
<form class="form" id="editar">
    <span>Malla de Turno</span>
    <br>
    <label for="">Día laboral</label>
    <input class="input" type="date" name="dia" value="<?php echo $row["dia"]; ?>" readonly>
    <label for="">Asesor</label>
    <input class="input" type="text" name="asesor" value="<?php echo $row["asesor"]; ?>" readonly>
    <label for="">Cédula</label>
    <input class="input" type="text" name="cedula" value="<?php echo $row["cedula"]; ?>" readonly>
    <label for="">Hora de ingreso</label>
    <input class="input" type="text" name="ingreso" value="<?php echo $row["ingreso"]; ?>">
    <label for="">Hora de salida</label>
    <input class="input" type="text" name="salida" value="<?php echo $row["salida"]; ?>">
    <div class="eg">
        <button class="button"><p class="submit">Guardar</p></button>
        <a href="#" class="volver" data-cedula='<?= $row['cedula'] ?>' data-form="consulta_malla"><button class="button"><p class="submit">Volver</p></button></a>
    </div>
</form>

<script src="../js/script.js"></script>