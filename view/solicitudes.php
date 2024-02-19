<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$nombre = $_SESSION["nombre"];
$ciudad = $_SESSION["ciudad"];
$user = $_SESSION["Cc_user"];
?>

<form id="solicitudes" enctype="multipart/form-data" class="form">
    <h3>Solicitudes</h3>
    <input type="hidden" name="nombre" value="<?php echo $nombre ?>">
    <input type="hidden" name="ciudad" value="<?php echo $ciudad ?>">
    <input type="hidden" name="user" value="<?php echo $user ?>">
    <select name="solicitud" id="solicitud" class="input" required>
        <option value="">Tipo de solicitud</option>
        <option value="Calamidad">Calamidad</option>
        <option value="Permiso No Remunerado">Permiso No Remunerado</option>
        <option value="Permiso Remunerado">Permiso Remunerado</option>
        <option value="Incapacidad">Incapacidad</option>
        <option value="Solicitud Vacaciones">Solicitud Vacaciones</option>
    </select>
    <label for="fecha_vacaciones" id="label"></label>
    <input type="date" class="input" name="fecha_solicitud" id="fecha_solicitud">
    <input type="email" name="correo" id="correo" class="input" placeholder="Correo electrónico" required autocomplete="off">

    <button class="button"><p class="submit">Enviar</p></button>
</form>

<script src="../js/script.js"></script>