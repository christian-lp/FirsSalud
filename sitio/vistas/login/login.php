<?php
include("/var/www/html/FirsSalud/sitio/modelos/conexion.php");
include("/var/www/html/FirsSalud/sitio/controladores/UserController.php");

if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
    error_reporting(E_ALL);
    if (isset($_SESSION['usr_rol']) != "") 
    {
        $rol = $_SESSION['usr_rol'];
        
        // Redirigir al index según el rol
        if ($rol == '1') {
            header("Location: ../../patient/index.php"); // Reemplaza 'index_admin.php' con la URL del index de administrador
            exit();
        } elseif ($rol == '2') {
            header("Location: ../../medic/index.php"); // Reemplaza 'index_usuario.php' con la URL del index de usuario
            exit();
        } elseif ($rol == '3') {
            header("Location: ../../admin/index.php"); // Reemplaza 'index_usuario.php' con la URL del index de usuario
            exit();
        }
        else {
            // Manejar otros roles o redirigir a una página predeterminada
            header("Location: login.php");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" href="../../css/login2.css">

</head>

<body>
	<div class="hero">
		<div class="main-box">
			<div class="form-box">
				<div id="after"></div>
				<div class="button-box">
					<div class="btn" id="btn"></div>
					<button id="log" type="button" class="toggle-btn" onclick="login()">Iniciar Sesión</button>
					<button id="reg" type="button" class="toggle-btn" onclick="register()">Registrarse</button>
				</div>
				<!-- <div class="social-icons">
					<a class="icon-link" href="#">
						<i style="font-size: 28px; color: rgb(6, 147, 255);" class="fab fa fa-facebook"></i>
					</a>
					<a class="icon-link" href="#">
						<i style="font-size: 28px;  color: rgb(236, 67, 160);" class="fab fa fa-instagram"></i>
					</a>
					<a class="icon-link" href="#">
						<i style="font-size: 28px;  color: rgb(255, 255, 255);" class="fab fa fa-github"></i>
					</a>

				</div> -->
				<form id="login" method="POST" class="input-group">
					<input type="text" name="emailUsr" maxlength="50" class="input-field" placeholder="Usuario (email)" required>
					<input id="pwd" type="Password" name="passUsr" class="input-field" placeholder="Contraseña" required>
					
					<input type="submit" name="login" class="submit-btn" value="Iniciar">
				</form>
				<?php
					if (isset($_POST['login'])) 
					{
						(new ControladorUsuarios())->ctrLogin();
					}
				?>
				<form method="POST" id="register" class="input-group">
					<input type="email" name="emailUsr" maxlength="50" class="input-field" placeholder="Email" required>
					<input id="pwd" type="Password" name="passUsr" class="input-field" placeholder="Contraseña" required>
					<input id="pwd" type="Password" name="CpassUsr" class="input-field" placeholder="Repite Contraseña" required>

					<input type="submit" name="sing_up" class="submit-btn" value="Registrarse">
				</form>
				<?php
					if (isset($_POST['sing_up'])) 
					{
						(new ControladorUsuarios())->ctrRegister();
					}
				?>
			</div>
			<span class="sp sp-t"></span>
			<span class="sp sp-r"></span>
			<span class="sp sp-b"></span>
			<span class="sp sp-l"></span>
		</div>
	</div>



	<!--Social Liks codings below-->
	<!-- <a id="source-link" class="meta-link" href="https://t.me/+7yc_oGHnLJhlOWVl" target="_blank">
		<i class="fas fa-link"></i>
		<span class="roboto-mono">Join my Telegram</span>
	</a>

	<a id="yt-link" class="meta-link" href="https://www.youtube.com/@codewith_muhilan?sub_confirmation=1"
		target="_blank">
		<i class="fab fa-youtube"></i>
		<span>Subscribe my channel..❤</span>
	</a> -->
	<script>
		let x = document.getElementById("login");
		let y = document.getElementById("register");
		let z = document.getElementById("btn");
		let log = document.getElementById("log");
		let reg = document.getElementById("reg");
		let after = document.getElementById("after");

		function register() {
			x.style.left = "-500px";
			y.style.left = "0px";
			z.style.left = "110px";
			log.style.color = "rgb(234, 234, 235)";
			reg.style.color = "#252525";
			after.style.left = "0";
			after.style.top = "0";
		}
		function login() {
			x.style.left = "0px";
			y.style.left = "500px";
			z.style.left = "0px";
			reg.style.color = "rgb(234, 234, 235)";
			log.style.color = "#252525";
			after.style.left = "50%";
			after.style.top = "0";

		}
	</script>
</body>

</html>

