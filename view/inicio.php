<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../');
        exit();
    }

    $perfil = $_SESSION["perfil"];
    $nombre = $_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomina</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../img/logo-removebg-preview 2.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h3><?php echo $nombre; ?></h3>
        <nav class="navbar">
            <ul class="nav-links">
                <!-- Mallas -->
                <?php if ($perfil === 'SUPER WF' || $perfil === 'admin') : ?>
                    <li class="nav-link service">
                        <a>Mallas <span class="drop-icon"><i class="fa-solid fa-caret-down"></i></span></a>
                        <ul class="drop-down">
                            <li class="php" data-form="subir_malla">Cargar</li>
                            <li class="php" data-form="ver_malla">Turnos</li>
                        </ul>
                    </li>
                <?php elseif ($perfil === 'EMPLEADO') : ?>
                    <li class="nav-link service">
                        <a href="#">Mallas <span class="drop-icon"><i class="fa-solid fa-caret-down"></i></span></a>
                        <ul class="drop-down">
                            <li class="php" data-form="ver_malla">Turno</li>
                            <li class="php" data-form="ver_info">Informacion</li>
                        </ul>
                    </li>
                <?php elseif ($perfil === 'SUPERVISOR') : ?>
                    <li class="nav-link service">
                        <a href="#">Mallas <span class="drop-icon"><i class="fa-solid fa-caret-down"></i></span></a>
                        <ul class="drop-down">
                            <li class="php" data-form="ver_malla2">Turno</li>
                            <li class="php" data-form="ver_info2">Informacion</li>
                        </ul>
                    </li>
                <?php else : ?>
                <?php endif; ?>

                <!-- Solicitudes -->
                <!-- <li class="nav-link service">
                    <a href="#">Solicitudes <span class="drop-icon"><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="drop-down">
                        <li data-form="solicitudes" class="php">Solicitar</li>
                        <li data-form="ver_solicitudes" class="php">ver</li>
                        <?php if ($perfil === 'SUPER TH' || $perfil === 'admin') : ?>
                        <li data-form="ver_solicitudesth" class="php">ver todas</li>
                        <?php else : ?>
                        <?php endif; ?>
                    </ul>
                </li> -->

                <!-- Novedad -->
                <?php if ($perfil === 'SUPER TH' || $perfil === 'admin') : ?>
                    <li class="nav-link service">
                        <a href="#">Novedades <span class="drop-icon"><i class="fa-solid fa-caret-down"></i></span></a>
                        <ul class="drop-down">
                            <li class="php" data-form="novedades">Novedad</li>
                            <li class="php" data-form="subir_novedades">Cargar novedades</li>
                        </ul>
                    </li>
                <?php else : ?>
                <?php endif; ?>

                <!-- Tardanza -->
                <?php if ($perfil === 'SUPERVISOR' || $perfil === 'admin') : ?>
                    <li class="nav-link php" data-form="tardanza">Tardanzas</li>
                <?php else : ?>
                <?php endif; ?>

                <!-- Empleados -->
                <?php if ($perfil === 'USUARIOS' || $perfil === 'admin') : ?>
                    <li class="nav-link service">
                        <a>Empleados <span class="drop-icon"><i class="fa-solid fa-caret-down"></i></span></a>
                        <ul class="drop-down">
                            <li data-form="empleados" class="php">Agregar</li>
                            <li data-form="retiro" class="php">Retiro</li>
                            <li data-form="subir_empleados" class="php">Cargar Empleados</li>
                        </ul>
                    </li>
                <?php else : ?>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="icon">
            <i class="fa-solid fa-user-gear php" data-form="config"></i>
            <a href="../php/cerrar.php"><i class="fa-solid fa-right-to-bracket"></i></a>
        </div>
    </header>

    <main id="resultado"></main>

    <script src="../js/script.js"></script>
</body>
</html>

<?php
include_once("../php/conexion_ocm_portabilidad.php");
include_once("../php/conexion_ocm_medellin.php");
include_once("../php/conexion_ocm_bogota.php");
include_once("../php/sql.php");
?>