<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../');
        exit();
    }

    $perfil = $_SESSION["perfil"];
    $nombre = $_SESSION["nombre"];
    $user = $_SESSION["Cc_user"];
?>

<form class="form" id="cambio_clave">
    <h1>Configuracion</h1>
    <input class="input" name="user" type="hidden" value="<?php echo $user; ?>">
    <input class="input" name="clave" type="text" placeholder="Nueva clave" required autocomplete="off">

    <button class="button"><p class="submit">Cambiar</p></button>
</form>
<script src="../js/script.js"></script>

