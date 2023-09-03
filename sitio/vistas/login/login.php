<?php
session_start();
error_reporting(E_ALL);
if(isset($_SESSION['usr_id'])) {
		echo'<script type="text/javascript"> ;
		window.location.href="login.php";</script>';
	
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Formulario de Inicio de Sesión</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
            }
    
            .login-container {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
    
            .login-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }
    
            .form-group {
                margin-bottom: 20px;
            }
    
            .form-group label {
                display: block;
                margin-bottom: 5px;
            }
    
            .form-group input {
                width: 100%;
                padding: 8px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
    
            .form-group button {
                width: 100%;
                padding: 10px;
                background-color: #639aff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
    
            .form-group button:hover {
                background-color: #45a049;
            }
            .additional-links {
        margin-top: 20px; /* Agrega espacio arriba */
    }

    .additional-links a {
        display: block; /* Convierte los enlaces en bloques separados */
        margin-bottom: 10px; /* Agrega espacio entre los enlaces */
    }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h2>Inicio de Sesión</h2>

            <form action="tu_archivo_de_autenticacion.php" method="post">
                <div class="form-group">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" name="loginUsr" class="form-control" maxlength="10" placeholder="Usuario(tu DNI)" title="tu usuario es tu dni" required>        
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="Password" name="passUsr" class="form-control"  placeholder="Clave" title="la clave es mínimo de 8 carácteres" required>        
                </div>

                <?php 
                    if (isset($_POST['login'])) {
                        (new ControladorUsuarios()) -> ctrLogin();
                    }                
                    ?> 

                <div class="form-group">
                <button type="submit" name="login" class="btn btn-secondary btn-block">Iniciar Sesion</button>
                </div>
            </form>

            <div class="additional-links">
                <a href="register.php">Registrarse</a>
                <a href="recover-password.php">¿Olvidaste tu contraseña?</a>
                <a href="../../../index.php">Volver atrás</a>
            </div>
            <div class="alert alert-info text-center">
                Si es la primera vez que ingresás, tu clave es tu DNI
                luego deberás cambiarla. 
        </div>   
        </div>
    
    </body>
    </html>