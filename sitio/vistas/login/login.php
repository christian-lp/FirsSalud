<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
    error_reporting(E_ALL);
    if (isset($_SESSION['usr_rol']) != "") 
    {
        echo '<script type="text/javascript"> ;
        window.location.href="index.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- Estilos -->
    <link rel="stylesheet" href="../../css/login.css">

    <title>Formulario Login y Registro de Usuarios</title>
</head>
<body>
<div class="login-box">
  <h2>Login</h2>
  
  <form method="post">

    <?php      
        include("/var/www/html/MedicV4/FirsSalud/sitio/modelos/conexion.php");
        include("/var/www/html/MedicV4/FirsSalud/sitio/controladores/UserController.php");
    ?> 
    <div class="user-box">
    <label for="username"></label>
    <input type="text" name="loginUsr" maxlength="50" placeholder="Usuario (email)" required>
</div>

<div class="user-box">
    <label for="password"></label>
    <input type="password" name="passUsr" placeholder="Contraseña" required>
</div>

<div>
    <a>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <label for="login"></label>
        <input type="text" name="login" style="display: none;"> <!-- Agrega un input oculto con el mismo nombre que el botón -->
        <input type="submit" value="Iniciar Sesión"> <!-- Usa un input de tipo submit -->
    </a>
</div>
<?php
        if (isset($_POST['login'])) 
        {
            (new ControladorUsuarios())->ctrLogin();
        }
    ?>
</form>

</div>

</body>
</html>
