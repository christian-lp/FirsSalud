<?php

session_start();

if (isset($_SESSION["usr_rol"])) {
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '3') {
        header("location: ../vistas/login/login.php");
    } else {
        $useremail = $_SESSION["email"];
    }
} else {
    header("location: ../vistas/login/login.php");
}


//import link
include("../modelos/conexion.php");

$sql = "SELECT * FROM admins WHERE email = :useremail";
// Prepara la consulta SQL
$stmt = Conexion::conectar()->prepare($sql);
$stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);

// Si se está ejecutando la sentencia SQL
if ($stmt->execute()) {
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // Usar fetch en lugar de fetchAll
    if ($resultado) {
        $userid = $resultado["id_admin"];
        $username = $resultado["name"];
    } else {
        echo 'No se encontraron resultados!';
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/Logo.png">


    <title>Doctores</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .btn-toggle {
            padding: 12px 40px; /* Tamaño fijo del botón */
            white-space: nowrap; /* Evita el ajuste de texto */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../../img/Logo.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo $username  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22)  ?></p>                      
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../vistas/login/logout.php"><input type="button" value="Cerrar Sesión" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="dashboard.php"><input type="button" value="Nosotros" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Inicio</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active">
                    <div>
                        <p class="menu-text">Doctores</p>
                </a>
    </div>
    </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-schedule">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Calendario</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment">
            <a href="appointment.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Turnos</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-patient">
            <a href="patient.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Pacientes</p>
            </a></div>
        </td>
    </tr>

    </table>
    </div>
    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="index.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Volver</font>
                        </button></a>
                </td>
                <td>

                    <form action="" method="post" class="header-search">

                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Búsqueda por Nombre, Doctor o Correo" list="doctors">&nbsp;&nbsp;
                    
                        <?php
                        $database = Conexion::conectar();
                    
                        echo '<datalist id="doctors">';
                        $list11 = $database->prepare("select name_medic,email_medic from  medics;");
                        $list11->execute();
                        $num_rows = $list11->rowCount();

                        for ($y = 0; $y < $num_rows; $y++) {
                            $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                            $d = $row00["name_medic"];
                            $c = $row00["email_medic"];
                            echo "<option value='$d'><br/>";
                            echo "<option value='$c'><br/>";
                        };

                        echo ' </datalist>';
                        ?>


                        <input type="Submit" value="Búsqueda" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                    </form>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php
                        date_default_timezone_set('America/Argentina/Buenos_Aires');

                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../../img/calendar.svg" width="100%"></button>
                </td>


            </tr>

            <tr>
                <td colspan="2" style="padding-top:30px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Agregar Nuevo Doctor</p>
                </td>
                <td colspan="2">
                    <a href="?action=add&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('../../img/icons/add.svg');width:200px;margin-right: 50px;">Agregar Nuevo</font></button>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Doctores (<?php echo $num_rows; ?>)</p>
                </td>

            </tr>
            <?php
            if ($_POST)
            {
                $keyword = $_POST["search"];

                $sqlmain = "select * from medics where email_medic='$keyword' or name_medic='$keyword' or email_medic like '$keyword%' or email_medic like '%$keyword' or email_medic like '%$keyword%'";
            } 
            else 
            {
                $sqlmain = "SELECT * FROM medics ORDER BY id_medic DESC";
            }

            ?>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">


                                            Nombre Doctor

                                        </th>
                                        <th class="table-headin">
                                            Email
                                        </th>
                                        <th class="table-headin">

                                            Especialidad

                                        </th>
                                        <th class="table-headin">

                                            Eventos

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                
                                    $result = $database->prepare($sqlmain);
                                    $result->execute(); // Ejecutar la consulta
                                    $num_rows = $result->rowCount();
                                

                                    if ($num_rows == 0) 
                                    {
                                            echo '<tr>
                                        <td colspan="4">
                                        <br><br><br><br>
                                        <center>
                                        <img src="../../img/notfound.svg" width="25%">
                                        
                                        <br>
                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">¡No pudimos encontrar nada relacionado con sus palabras clave!</p>
                                        <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todos los doctores &nbsp;</font></button>
                                        </a>
                                        </center>
                                        <br><br><br><br>
                                        </td>
                                        </tr>';
                                        } 
                                        else {
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $docid = $row["id_medic"];
                                                $name = $row["name_medic"];
                                                $email = $row["email_medic"];
                                                $is_active = $row["is_active"];
                                                $spe = $row["specialty_medic"];
                                                $spcil_res = $database->prepare("select specialty_name from specialties where specialty_id= '$spe'");
                                                $spcil_res->execute();
                                                $spcil_array = $spcil_res->fetch(PDO::FETCH_ASSOC);
                                                $spcil_name = $spcil_array["specialty_name"];
                                                
                                                echo '<tr>
                                                        <td> &nbsp;' . substr($name, 0, 30) . '</td>
                                                        <td>' . substr($email, 0, 20) . '</td>
                                                        <td>' . substr($spcil_name, 0, 20) . '</td>
                                                        <td>
                                                            <div style="display:flex;justify-content: center;">
                                                                <a href="?action=edit&id=' . $docid . '&error=0" class="non-style-link">
                                                                    <button class="btn-primary-soft btn button-icon btn-edit" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;">
                                                                        <font class="tn-in-text">Editar</font>
                                                                    </button>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="?action=view&id=' . $docid . '" class="non-style-link">
                                                                    <button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;">
                                                                        <font class="tn-in-text">Ver</font>
                                                                    </button>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;';

                                                    // Ahora, aquí tienes el enlace y el botón para cambiar la activación
                                                    echo 
                                                    '<a href="?action=toggle&id=' . $docid . '&name=' . $name . '" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-toggle" style="padding-left: 10px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;margin-left:0px;"
                                                            data-toggle="' . ($is_active == 1 ? 'activo' : 'inactivo') . '"
                                                            data-target="' . ($is_active == 1 ? 'inactivo' : 'activo') . '"
                                                            data-id="' . $docid . '">
                                                            <font class="tn-in-text" style="color: ' . ($is_active == 1 ? 'blue' : 'red') . '">
                                                                ' . ($is_active == 1 ? 'Activo' : 'Inactivo') . '
                                                            </font>
                                                        </button>
                                                    </a>';
                                                
                                                    
                                                    // Continúa con el resto de tu código
                                                    echo '
                                                            </div>
                                                        </td>
                                                    </tr>';

                                            }
                                            
                                    }
                                    ?>

<style>
.button-icon {
    width: 120px; /* Ancho fijo deseado para el botón */
    padding: 12px; /* Ajusta el espaciado según sea necesario */
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease, color 0.3s ease; /* Efecto de transición suave */
}
</style>

<script>
var buttons = document.querySelectorAll('.btn-toggle');

buttons.forEach(function(button) {
    button.addEventListener('mouseover', function() {
        var toggle = this.getAttribute('data-toggle');
        if (toggle === 'inactivo') {
            this.querySelector('.tn-in-text').textContent = 'Activar';
        } else {
            this.querySelector('.tn-in-text').textContent = 'Desactivar';
        }
        this.style.backgroundColor = toggle === 'inactivo' ? 'var(--primarycolor)' : 'red'; // Cambio de color de fondo al pasar el cursor
        this.style.color = 'white'; // Cambio de color de texto al pasar el cursor
    });

    button.addEventListener('mouseout', function() {
        var toggle = this.getAttribute('data-toggle');
        if (toggle === 'inactivo') {
            this.querySelector('.tn-in-text').textContent = 'Inactivo';
        } else {
            this.querySelector('.tn-in-text').textContent = 'Activo';
        }
        this.style.backgroundColor = ''; // Restaurar el color de fondo al salir del cursor
        this.style.color = toggle === 'inactivo' ? 'white' : 'black'; // Restaurar el color de texto al salir del cursor
    });

    button.addEventListener('click', function(e) {
        e.preventDefault(); // Evitar que el enlace se abra
        var toggle = this.getAttribute('data-toggle');
        var target = this.getAttribute('data-target');
        var id2 = this.getAttribute('data-id'); // Asegúrate de agregar data-id en tu enlace

        // Realizar una solicitud AJAX para actualizar la base de datos
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'activity.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.onload = function() {
            // Manejar la respuesta si es necesario

            // Cambiar el texto del botón después de recibir una respuesta
            if (xhr.status === 200 && xhr.responseText === 'success') {
                var buttonText = target === 'activo' ? 'Inactivo' : 'Activo';
                var buttonColor = target === 'activo' ? 'blac' : 'black';
                this.querySelector('.tn-in-text').textContent = buttonText;
                this.style.backgroundColor = buttonColor; // Cambio de color de fondo
            }
        };

        xhr.send('id=' + id2 + '&target=' + target);
    });
});
</script>






                                </tbody>

                            </table>
                        </div>
                    </center>
                </td>
            </tr>
            <!-- <a href="?action=drop&id=' . $docid . '&name=' . $name . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                    <font class="tn-in-text" style="color: ' . ($is_active == 1 ? 'green' : 'red') . ';">' . ($is_active == 1 ? 'Activo' : 'Inactivo') . '  &nbsp;&nbsp;&nbsp;</font>
                                                                </button>
                                                            </a> -->


        </table>
    </div>
    </div>
    <?php
    if ($_GET) {

        $id = $_GET["id"];
        $action = $_GET["action"];
        if ($action == 'drop') {
            $nameget = $_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Estás segur@?</h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            Deseas borrar este registro<br>(' . substr($nameget, 0, 40) . ').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-doctor.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Si&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';



            
        } elseif ($action == 'view') {
            $sqlmain = "select * from medics where id_medic='$id'";
            $result = $database->prepare($sqlmain);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $name = $row["name_medic"];
            $sur = $row['surname_medic'];
            $email = $row["email_medic"];
            $matri= $row['matricul_medic'];
            $tele = $row['phone_medic'];
            $spe = $row["specialty_medic"];
            $avail = $row["availability"];

            $spcil_res = $database->prepare("select specialty_name from specialties where specialty_id='$spe'");
            $spcil_res->execute();
            $spcil_array = $spcil_res->fetch(PDO::FETCH_ASSOC);
            $spcil_name = $spcil_array["specialty_name"];
            


            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            MEDIC<br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Ver Detalles</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Nombre: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                                ' . $sur . '<br><br>
                            </td>
                            
                        </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Correo: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $email . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="matri" class="form-label">N° de Matricula: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $matri . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Teléfono: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $tele . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Especialidad: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            ' . $spcil_name . '<br><br>
                            </td>
                            </tr>

                            <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label">Disponibilidad: </label>
                            </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            ' . $avail . '<br><br>
                            </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                </td>
                
                            </tr>
                        
                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        } elseif ($action == 'add') {
            $error_1 = $_GET["error"];
            $errorlist = array(
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">La cuenta ya existe.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">¡Error de confirmación de contraseña! Reconfirmar contraseña</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => "",
                '5' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">¡Error de confirmación de fecha! Debe ser mayor de 24 años</label>',
                '0' => '',

            );
            if ($error_1 != '4') {
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="doctors.php">&times;</a>
                            <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                    <form action="add-new.php" method="POST" class="add-new-form">
                                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                            <tr>
                                                <td class="label-td" colspan="2">' . $errorlist[$error_1] . '</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Agregar Nuevo Doctor.</p><br><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="name_medic" class="form-label">Nombre: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="text" name="name_medic" class="input-text" placeholder="Nombre Doctor" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="surname_medic" class="form-label">Apellido: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="text" name="surname_medic" class="input-text" placeholder="Apellido Doctor" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="day_of_birth_medic" class="form-label">Fecha de Nacimiento: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="date" name="day_of_birth_medic" class="input-text" placeholder="Fecha de Nacimiento" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="email_medic" class="form-label">Correo: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="email" name="email_medic" class="input-text" placeholder="Email Address" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="matricul_medic" class="form-label">Matricula: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="text" name="matricul_medic" class="input-text" placeholder="N° de Matricula" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="phone_medic" class="form-label">Teléfono: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <input type="tel" name="phone_medic" class="input-text" placeholder="Teléfono Móvil" required><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="specialty_medic" class="form-label">Especialidad: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <select name="specialty_medic" id="" class="box">';
                                    
                                                    $list11 = $database->prepare("select  * from  specialties order by specialty_name asc;");
                                                    $list11->execute();
                                                    $num_rows = $list11->rowCount();
                                                    
                                                    for ($y = 0; $y < $num_rows; $y++) {
                                                        $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                                                        $sn = $row00["specialty_name"];
                                                        $id00 = $row00["specialty_id"];
                                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                    }
                                    
                                    echo '   </select><br><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="gender_medic" class="form-label">Genero: </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <select name="gender_medic" id="" class="box">';
                                    
                                                    $list11 = $database->prepare("select  * from  genders order by gender_name asc;");
                                                    $list11->execute();
                                                    $num_rows = $list11->rowCount();
                                                    
                                                    for ($y = 0; $y < $num_rows; $y++) {
                                                        $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                                                        $sn = $row00["gender_name"];
                                                        $id00 = $row00["gender_id"];
                                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                    }
                                    
                                    echo     '  </select><br><br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="availability" class="form-label">Disponibilidad: </label>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <input type="text" name="availability" class="input-text" placeholder="De lunes a viernes de 08:00hs. a 16:00hs." required><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="password_medic" class="form-label">Contraseña: </label>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <input type="password" name="password_medic" class="input-text" placeholder="Contraseña" required><br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <label for="cpassword" class="form-label">Confirmar Contraseña: </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <input type="password" name="cpassword" class="input-text" placeholder="Confirmar Contraseña" required><br>
                                                    </td>
                                                </tr>
                                                        
                                        
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="reset" value="Resetear" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    
                                                        <input type="submit" value="Add" class="login-btn btn-primary btn">
                                                    </td>
                                    
                                                </tr>
                                        </table>
                                    </form>
                                </tr> 
                            </div>
                        </div>
                    </center>
                <br><br>
            </div>
            </div>
            ';
            } else {
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            <br><br><br><br>
                                <h2>Nuevo Registro Añadido Exitosamente</h2>
                                <a class="close" href="doctors.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                            </center>
                    </div>
                    </div>
        ';
            }
        } 
        elseif ($action == 'edit') {
            $database = Conexion::conectar();
            $sqlmain = "select * from medics where id_medic='$id'";
            $result = $database->prepare($sqlmain);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $name = $row["name_medic"];
            $email = $row["email_medic"];
            $spe = $row["specialty_medic"];
            $avail = $row["availability"];

            $spcil_res = $database->prepare("select specialty_name from specialties where specialty_id='$spe'");
            $spcil_array = $spcil_res->fetch(PDO::FETCH_ASSOC);
            $spcil_name = $spcil_array["specialty_name"];
            $matri = $row['matricul_medic'];
            $tele = $row['phone_medic'];

            $error_1 = $_GET["error"];
            $errorlist = array(
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Ya existe una cuenta con esta direccion de E-mail.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => "",
                '0' => '',

            );

            if ($error_1 != '4') {
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            
                                <a class="close" href="doctors.php">&times;</a>
                                <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                        <td class="label-td" colspan="2">' .
                    $errorlist[$error_1]
                    . '</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Editar Información de Doctor</p>
                                        Doctor ID : ' . $id . ' (Auto Generado)<br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="edit-doc.php" method="POST" class="add-new-form">
                                            <label for="Email" class="form-label">Correo: </label>
                                            <input type="hidden" value="' . $id . '" name="id00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <input type="hidden" name="oldemail" value="' . $email . '" >
                                        <input type="email" name="email_medic" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name_medic" class="form-label">Nombre: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="name_medic" class="input-text" placeholder="Nombre Doctor" value="' . $name . '" required><br>
                                        </td>
                                        
                                    </tr>
                                    
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="matricul_medic" class="form-label">Matricula: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="matricul_medic" class="input-text" placeholder="Número de Matricula" value="' . $matri . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">Teléfono: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="tel" name="phone_medic" class="input-text" placeholder="Teléfono Móvil" value="' . $tele . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="specialty_medic" class="form-label">Escoger Especialidad: (Actual ' . $spcil_name . ')</label>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="specialty_medic" id="" class="box">';

                                $list11 = $database->prepare("select * from specialties;");
                                $list11->execute();
                                $rows = $list11->fetchAll(PDO::FETCH_ASSOC); // Usamos fetchAll para obtener todas las filas
                                
                                foreach ($rows as $row) { // Iteramos a través de todas las filas
                                    $sn = $row["specialty_name"];
                                    $id00 = $row["specialty_id"];
                                    echo "<option value='$id00'>$sn</option><br/>";
                                }
                
                                echo ' </select><br><br>
                                        </td>
                                    </tr>

                                    <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="availability" class="form-label">Disponibilidad: (Actual) </label>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="availability" class="input-text"  placeholder="Disponibilidad" value="' . $avail . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="password_medic" class="form-label">Contraseña: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="password" name="password_medic" class="input-text" placeholder="Definir una Contraseña" required><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="cpassword_medic" class="form-label">Confirmar Contraseña: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="password" name="cpassword_medic" class="input-text" placeholder="Confirmar Contraseña" required><br>
                                        </td>
                                    </tr>
                                    
                        
                                    <tr>
                                        <td colspan="2">
                                            <!--<input type="reset" value="Resetear" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                        
                                            <input type="submit" value="Guardar" class="login-btn btn-primary btn">
                                        </td>
                        
                                    </tr>
                                
                                    </form>
                                    </tr>
                                </table>
                                </div>
                                </div>
                            </center>
                            <br><br>
                    </div>
                    </div>
                    ';
            } else {
                echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                        <br><br><br><br>
                            <h2>Edición Exitosa</h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                            Si cambia su correo electrónico también, cierre la sesión y vuelva a iniciar sesión con su nuevo correo electrónico
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            
                            <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                            <a href="../vistas/login/logout.php" class="non-style-link"><button  class="btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Cerrar Sesión&nbsp;&nbsp;</font></button></a>

                            </div>
                            <br><br>
                        </center>
                </div>
                </div>
    ';
            };
        }
    }
    ?>
    </div>

</body>

</html>