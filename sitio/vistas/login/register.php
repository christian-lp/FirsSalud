<?php
session_start(); // Inicia la sesión al principio

if (session_status() == PHP_SESSION_NONE) 
{
    error_reporting(E_ALL);
    if (isset($_SESSION['usr_rol']) != "") 
    {
        echo '<script type="text/javascript">window.location.href="index.php";</script>';
    }
}

if (isset($_POST['sing_up'])) 
{
    // Recoge los datos del formulario
    $email = $_POST['emailUsr'];
    $password = $_POST['passUsr'];
    $confirmPassword = $_POST['CpassUsr'];

    // Verifica que las contraseñas coincidan
    if ($password === $confirmPassword) 
    {
        // Genera un salt aleatorio
        $salt = random_bytes(16);

        // Combina la contraseña con el salt
        $saltedPassword = $password . $salt;

        // Hashea la contraseña
        $hashedPassword = password_hash($saltedPassword, PASSWORD_DEFAULT);

        // Aquí debes guardar $email, $hashedPassword y $salt en tu base de datos

        // Luego, puedes redirigir al usuario o mostrar un mensaje de registro exitoso
    } 
    else 
    {
        echo "Las contraseñas no coinciden.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../../css/login.css">
    <title>Formulario Registro de Usuarios</title>
</head>
<body>
<div class="login-box">
  <h2>Registrarse</h2>
  <form method="post" id="registration-form">
    <div id="error-message" style="color: red;"></div>

    <?php      
        include("/var/www/html/FirsSalud/sitio/modelos/conexion.php");
        include("/var/www/html/FirsSalud/sitio/controladores/UserController.php");
    ?> 
    <div class="user-box">
        <label for="emailUsr"></label>
        <input type="text" name="emailUsr" maxlength="50" placeholder="Usuario (email)" >
    </div>

    <div class="user-box">
        <label for="passUsr"></label>
        <input type="password" name="passUsr" placeholder="Contraseña" >
    </div>

    <div class="user-box">
        <label for="CpassUsr"></label>
        <input type="password" name="CpassUsr" placeholder="Repite Contraseña" >
    </div>

    <div>
        <a>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <label for="sing_up"></label>
            <input type="submit" name="sing_up" value="Registrarse"><!-- Usa un input de tipo submit -->
        </a>
    </div>

    <div>
        <a href="login.php">Iniciar Sesión</a>
    </div>

</form>
</div>
</body>
</html>
