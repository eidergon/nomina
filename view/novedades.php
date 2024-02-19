<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../');
        exit();
    }

    $perfil = $_SESSION["perfil"];
    $nombre = $_SESSION["nombre"];
?>

<form id="novedades" enctype="multipart/form-data" class="form">
    <h1>Novedades</h1>
    <input type="hidden" name="nombre" value="<?php echo $nombre ?>">

    <input class="input" placeholder="Cédula" type="text" name="cedula" id="cedula" autocomplete="off" required />
    <label>
        Fecha Inicio
        <input class="input" type="date" id="fecha_novedad" name="fecha_novedad" autocomplete="off" required />
    </label>

    <label>
        Fecha Fin
        <input class="input" type="date" id="fecha_novedad2" name="fecha_novedad2" autocomplete="off" required />
    </label>

    <label for="tipo_novedad">Tipo de novedad:</label>
    <select class="input" name="novedades" id="novedades" required>
        <option value="">Novedad</option>
        <option value="VC">Vacaciones</option>
        <option value="INC">Incapacidad</option>
        <option value="LR">Licencia Remunerada</option>
        <option value="PNR">Permiso NO Remunerado</option>
        <option value="SUS">Suspensión</option>
    </select>

    <button class="button"><p class="submit">Subir</p></button>
</form>

<script src="../js/script.js"></script>