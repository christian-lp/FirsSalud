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

    <title>Inicio</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
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
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Inicio</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor ">
                <a href="doctors.php" class="non-style-link-menu ">
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
                    <p class="menu-text">Cita</p>
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
    <div class="dash-body" style="margin-top: 15px">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">

            <tr>

                <td colspan="2" class="nav-bar">

                    <form action="doctors.php" method="post" class="header-search">

                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Búsqueda por Nombre, Doctor o Correo" list="doctors">&nbsp;&nbsp;

                        <?php
                        echo '<datalist id="doctors">';
                        try {
                            $stmt = Conexion::conectar()->prepare("SELECT name_medic, email_medic FROM medics");
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $d = $row["name_medic"];
                                $c = $row["email_medic"];
                                echo "<option value='$d'><br/>";
                                echo "<option value='$c'><br/>";
                            }
                        } catch (PDOException $e) {
                            // Manejar el error de la base de datos aquí
                            echo "Error de base de datos: " . $e->getMessage();
                        }
                        echo ' </datalist>';
                        ?>



                        <input type="Submit" value="Búsqueda" class="login-btn btn-primary-soft btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                    </form>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php
                        date_default_timezone_set('America/Argentina/Buenos_Aires');

                        $today = date('d-M-Y');
                        echo $today;
                        
                        $patientstmt = Conexion::conectar()->prepare("select  * from  patients;");
                        $patientstmt->execute();
                        $patientCount = $patientstmt->rowCount();
                        
                        $doctorstmt = Conexion::conectar()->prepare("select  * from  medics;");
                        $doctorstmt->execute();
                        $doctorCount = $doctorstmt->rowCount();
                        
                        $appointmentstmt = Conexion::conectar()->prepare("select  * from  appointment where appodate>='$today';");
                        $appointmentstmt->execute();
                        $appointmentCount = $appointmentstmt->rowCount();
                        
                        $schedulestmt = Conexion::conectar()->prepare("select  * from  schedule where scheduledate='$today';");
                        $schedulestmt->execute();
                        $scheduleCount = $schedulestmt->rowCount();

                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../../img/calendar.svg" width="100%"></button>
                </td>


            </tr>
            <tr>
                <td colspan="4">

                    <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Dashboard</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div>
                                            <div class="h1-dashboard">
                                                <?php echo $doctorCount  ?>
                                            </div><br>
                                            <div class="h3-dashboard">
                                                Doctores &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../../img/icons/doctors-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                            <div class="h1-dashboard">
                                                <?php echo $patientCount  ?>
                                            </div><br>
                                            <div class="h3-dashboard">
                                                Pacientes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../../img/icons/patients-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex; ">
                                        <div>
                                            <div class="h1-dashboard">
                                                <?php echo $appointmentCount  ?>
                                            </div><br>
                                            <div class="h3-dashboard">
                                                Nuevas Reservas &nbsp;&nbsp;
                                            </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('../../img/icons/book-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;padding-top:26px;padding-bottom:26px;">
                                        <div>
                                            <div class="h1-dashboard">
                                                <?php echo $scheduleCount  ?>
                                            </div><br>
                                            <div class="h3-dashboard" style="font-size: 15px">
                                                Sesiones Hoy
                                            </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../../img/icons/session-iceblue.svg');"></div>
                                    </div>
                                </td>

                            </tr>
                        </table>
                    </center>
                </td>
            </tr>






            <tr>
                <td colspan="4">
                    <table width="100%" border="0" class="dashbord-tables">
                        <tr>
                            <td>
                                <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                    Próximas citas hasta el próximo <?php
                                                                    echo date("l", strtotime("+1 week"));
                                                                    ?>
                                </p>
                                <p style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                    Aquí está el acceso rápido a las próximas citas hasta 7 días<br>
                                    Más detalles disponibles en la sección de @Citas.
                                </p>

                            </td>
                            <td>
                                <p style="text-align:right;padding:10px;padding-right:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                    Próximas sesiones hasta el próximo <?php
                                                                        echo date("l", strtotime("+1 week"));
                                                                        ?>
                                </p>
                                <p style="padding-bottom:19px;text-align:right;padding-right:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                    Aquí hay acceso rápido a las próximas sesiones programadas hasta 7 días<br>
                                    Agregar, quitar y muchas funciones disponibles en la sección @Calendario.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <center>
                                    <div class="abc scroll" style="height: 200px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin" style="font-size: 12px;">

                                                        Número de cita

                                                    </th>
                                                    <th class="table-headin">
                                                        Nombre de Paciente
                                                    </th>
                                                    <th class="table-headin">


                                                        Doctor

                                                    </th>
                                                    <th class="table-headin">


                                                        Sesión

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $nextweek = date("Y-m-d", strtotime("+1 week"));
                                                $sqlmain = "select appointment.appointment_id,schedule.scheduleid,schedule.title,medics.name_medic,patients.name,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patients on patient.id_patient=appointment.patient_id inner join medics on schedule.id_medic=medics.id_medic  where schedule.scheduledate>='$today'  and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc";

                                                $result = Conexion::conectar()->prepare($sqlmain);
                                                $result->execute();
                                                $num_rows = $result->rowCount();

                                                if ($num_rows == 0) {
                                                    echo '<tr>
                                                    <td colspan="3">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../../img/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todas las Citas &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                } else {
                                                    for ($x = 0; $x < $num_rows; $x++) {
                                                        $row = $result->fetchAll();
                                                        $appoid = $row["appointment_id"];
                                                        $scheduleid = $row["scheduleid"];
                                                        $title = $row["title"];
                                                        $docname = $row["name_medic"];
                                                        $scheduledate = $row["scheduledate"];
                                                        $scheduletime = $row["scheduletime"];
                                                        $pname = $row["name"];
                                                        $apponum = $row["apponum"];
                                                        $appodate = $row["appodate"];
                                                        echo '<tr>


                                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);padding:20px;">
                                                            ' . $apponum . '
                                                            
                                                        </td>

                                                        <td style="font-weight:600;"> &nbsp;' .

                                                            substr($pname, 0, 25)
                                                            . '</td >
                                                        <td style="font-weight:600;"> &nbsp;' .

                                                            substr($docname, 0, 25)
                                                            . '</td >
                                                        
                                                        <td>
                                                        ' . substr($title, 0, 15) . '
                                                        </td>

                                                    </tr>';
                                                    }
                                                }

                                                ?>

                                            </tbody>

                                        </table>
                                    </div>
                                </center>
                            </td>
                            <td width="50%" style="padding: 0;">
                                <center>
                                    <div class="abc scroll" style="height: 200px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin">


                                                        Nombre Sesión

                                                    </th>

                                                    <th class="table-headin">
                                                        Doctor
                                                    </th>
                                                    <th class="table-headin">

                                                        Fecha y Hora Cita

                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $nextweek = date("Y-m-d", strtotime("+1 week"));
                                                $sqlmain = "select schedule.scheduleid,schedule.title,medics.name_medic,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join medics on schedule.id_medic=medics.id_medic  where schedule.scheduledate>='$today' and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc";
                                                $result = Conexion::conectar()->prepare($sqlmain);
                                                $num_rows = $result->rowCount();

                                                if ($num_rows == 0) {
                                                    echo '<tr>
                                                    <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../../img/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todas las Sesiones &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                } else {
                                                    for ($x = 0; $x < $num_rows; $x++) {
                                                        $row = $result->fetchAll();
                                                        $scheduleid = $row["scheduleid"];
                                                        $title = $row["title"];
                                                        $docname = $row["name_medic"];
                                                        $scheduledate = $row["scheduledate"];
                                                        $scheduletime = $row["scheduletime"];
                                                        $nop = $row["nop"];
                                                        echo '<tr>
                                                        <td style="padding:20px;"> &nbsp;' .
                                                            substr($title, 0, 30)
                                                            . '</td>
                                                        <td>
                                                        ' . substr($docname, 0, 20) . '
                                                        </td>
                                                        <td style="text-align:center;">
                                                            ' . substr($scheduledate, 0, 10) . ' ' . substr($scheduletime, 0, 5) . '
                                                        </td>

                
                                                       
                                                    </tr>';
                                                    }
                                                }

                                                ?>

                                            </tbody>

                                        </table>
                                    </div>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                    <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Mostrar todas las Citas</button></a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a href="schedule.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Mostrar todas las Sesiones</button></a>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
        </center>
        </td>
        </tr>
        </table>
    </div>
    </div>


</body>

</html>