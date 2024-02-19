<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$perfil = $_SESSION["perfil"];
$nombre = $_SESSION["nombre"];
?>

<form id="malla" enctype="multipart/form-data" class="form">
    <h1>Mallas de turno</h1>
    <input class="input" id="archivo_excel" type="file" name="archivo_excel" accept=".csv" required />
    <button class="button"><p class="submit">Subir</p></button>
</form>
<div class="loader hidden" id="loader">
    <div class="loader-inner">
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
        <div class="loader-block"></div>
    </div>
</div>

<script src="../js/script.js"></script>