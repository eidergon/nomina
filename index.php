<?php
session_start();

session_destroy();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="img/logo-removebg-preview 2.ico" type="image/x-icon">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <form class="form" method="POST">
        <a href="#"><img src="img/logo-removebg-preview 2.ico" alt="Logo" class="logo"></a>
        <div class="form-container">
            <input type="text" name="usuario" class="input" placeholder="Usuario" required>
            <input type="password" name="pass" class="input" placeholder="Contraseña" required>
            <button class="btn"> Ingresar </button>
        </div>
        <p class="message" id="mensaje">¿Se te olvido la contraseña?</p>
        <p class="message" id="developer">&copy; Desarrollo creado para One Contact</p>
    </form>

    <?php
        require 'php/conexion.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['usuario'];
            $pass = $_POST['pass'];
            $sql = "SELECT * FROM login WHERE Cc_user = '$usuario' AND pass = '$pass'";
            $resultado = $conn->query($sql);
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                if ($row['estado'] == 1) {
                    session_start();
                    $_SESSION["nombre"] = $row["nombre"];
                    $_SESSION["perfil"] = $row["perfil"];
                    $_SESSION["ciudad"] = $row["ciudad"];
                    $_SESSION["Cc_user"] = $row["Cc_user"];
                    $_SESSION['logged_in'] = true;
                    $nombre = $row["nombre"];

                    $sql2 = "INSERT INTO logueo (nombre) VALUES ('$nombre')";
                    if (mysqli_query($conn, $sql2)) {
                        header("Location: ./view/inicio.php");
                        exit;
                    } else {
                        // Manejar el error en caso de que la consulta falle
                        echo "Error al insertar en la base de datos: " . mysqli_error($conexion);
                    }

                    // Cerrar conexión
                    mysqli_close($conexion);
                } else {
                    echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error de autenticación",
                        text: "Usuario Desabilitado",
                    });
                </script>';
                }
            } else {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error de autenticación",
                    text: "Usuario o contraseña incorrectos",
                });
            </script>';
            }
        }
    ?>
    <script src="js/script.js"></script>
</body>
</html>