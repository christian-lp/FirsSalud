<?php
// Inicia la sesión (si no está iniciada ya)
session_start();

if (isset($_SESSION['usr_rol']) == "") {
    echo '<script type="text/javascript"> ;
    window.location.href="login.php";</script>';
} else {
    if ($_SESSION["usr_rol"] == 1) {
        $_SESSION["rol"] = 1;
        $conectado = "PACIENTE";
        echo "<html><body>";
        echo "<h1>My Dashboard Paciente</h1>";
        echo "Bienvenido al Área de pacientes! <br> <strong>";
        echo $conectado . " " . $_SESSION["name"];
        echo "</strong><br>Has ingresado con el nombre de usuario: <strong>" . $_SESSION["email"] . " </strong><strong> ";
        echo $_SESSION["login"];
        echo "<br>";
        echo "</strong>";
        echo "</strong>";
        echo "<br>";
    }

    if (isset($_SESSION['usr_rol'])) {
      // Obtén el valor del rol desde la sesión
      $userRol = $_SESSION['usr_rol'];
  
      // Utiliza un switch para definir $userStatus según el valor de $userRol
      switch ($userRol) {
          case 1:
              $userStatus = 'Paciente';
              break;
          case 2:
              $userStatus = 'Médico';
              break;
          case 3:
              $userStatus = 'Usuario';
              break;
          case 4:
              $userStatus = 'Administrador';
              break;
          default:
              $userStatus = 'Usuario Desconocido'; // En caso de otro valor no reconocido
              break;
      }
  } else {
      // Si no está definida, establece un valor predeterminado o maneja el caso según tu lógica
      $userStatus = 'USUARIO DESCONOCIDO'; // Valor predeterminado en caso de que no se haya configurado
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Aquí puedes incluir tus archivos CSS y otros encabezados -->
</head>

<body>
    <!-- Tu contenido HTML aquí -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
        <ul class="nav navbar-nav">
            <li class="active"><a href="sitio/vistas/login/login.php">Acceso</a></li>
            <li><a href="#service">Servicios</a></li>
            <li><a href="#doctor">Doctores</a></li>
            <li><a href="#facilities">Nuestras Instalaciones</a></li>
            <!--<li><a href="#prices">Precios</a></li> -->
            <li class="dropdown">
                <a href="#Turn" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="badge custom-badge red pull-right">
                        <!-- Aquí se mostrará el estado del usuario -->
                        <?php echo $userStatus; ?>
                    </span><br>
                    Turnos <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index-sacarturnos.html">Turnos Disponibles</a></li>
                    <li><a href="index-buscador.html">Cancelación Turnos</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <br><br> Para cerrar la sesión, pulsa: <a href='logout.php'>Aqui</a><br>
</body>

</html>
