<?php
session_start(); // Mueve esta línea al principio

if (session_status() == PHP_SESSION_NONE) 
{
    error_reporting(E_ALL);
    if (isset($_SESSION['usr_rol']) != "") 
    {
		echo '<script type="text/javascript">window.location.href="index.php";</script>';
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
  <h2>Registrarse</h2>
  
  
  <form method="post" id="registration-form">

	<?php
		// if (isset($_SESSION['registration_error'])) {
		// 	echo '<p style="color: red;">' . $_SESSION['registration_error'] . '</p>';
		// 	unset($_SESSION['registration_error']); // Limpia la variable de sesión después de mostrar el mensaje
		// }
		?>
		<div id="error-message" style="color: red;"></div>

    <?php      
        include("/var/www/html/MedicV4/FirsSalud/sitio/modelos/conexion.php");
        include("/var/www/html/MedicV4/FirsSalud/sitio/controladores/UserController.php");
    ?> 
    <div class="user-box">
        <label for="emailUsr"></label>
        <input type="email" name="emailUsr" maxlength="50" placeholder="Usuario (email)" required>
    </div>

    <div class="user-box">
        <label for="passUsr"></label>
        <input type="password" name="passUsr" placeholder="Contraseña" required>
    </div>

    <div class="user-box">
        <label for="CpassUsr"></label>
        <input type="password" name="CpassUsr" placeholder="Repite Contraseña" required>
    </div>

    <div>
        <a>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <label for="sing_up"></label>
            <input type="text" name="sing_up" style="display: none;"> <!-- Agrega un input oculto con el mismo nombre que el botón -->
            <input type="submit" name="sing_up" value="Registrarse"><!-- Usa un input de tipo submit -->
        </a>
    </div>

    <?php
        if (isset($_POST['sing_up'])) 
        {
            (new ControladorUsuarios())->ctrRegister();
        }
    ?>
    
    <div>
        <a href="login.php">Iniciar Sesión</a>
    </div>


</form>
</div>
</body>
</html>
