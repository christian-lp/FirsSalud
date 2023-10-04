<?php

session_start();

if (isset($_SESSION["usr_rol"])) {
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '1') {
        header("location: ../vistas/login/login.php");
    } else {
        $useremail = $_SESSION["email"];
    }
} else {
    header("location: ../vistas/login/login.php");
}


//import link
include("../modelos/conexion.php");

$sql = "SELECT * FROM patients WHERE email = :useremail";
// Prepara la consulta SQL
$stmt = Conexion::conectar()->prepare($sql);
$stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);

// Si se está ejecutando la sentencia SQL
if ($stmt->execute()) {
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // Usar fetch en lugar de fetchAll
    if ($resultado) {
        $userid = $resultado["id_patient"];
        $username = $resultado["name"];
        // var_dump($userid);
        // var_dump($username);
        // exit();
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

        .sub-table,
        .anime {
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

                            <tr>
                                <td colspan="2">
                                    <a href="dashboard.php"><input type="button" value="Nosotros" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                                
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Inicio</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor">
                <a href="doctors.php" class="non-style-link-menu">
                    <div>
                        <p class="menu-text">Todos los Doctores</p>
                </a>
    </div>
    </td>
    </tr>

    <tr class="menu-row">
        <td class="menu-btn menu-icon-session">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Turnos</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment">
            <a href="appointment.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Mis Reservas</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-settings">
            <a href="settings.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Configuración</p>
            </a></div>
        </td>
    </tr>

    </table>
    </div>
    <div class="dash-body" style="margin-top: 15px">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">

            <tr>

                <td colspan="1" class="nav-bar">
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Inicio</p>

                </td>
                <td width="25%">

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                    <?php
                    try {
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $today = date('d-M-Y');
                        echo $today;

                        // Consulta de pacientes
                        $patientstmt = Conexion::conectar()->prepare("SELECT * FROM patients");
                        $patientstmt->execute();
                        $patientrow = $patientstmt->fetchAll(PDO::FETCH_ASSOC);

                        // Consulta de doctores
                        $doctorstmt = Conexion::conectar()->prepare("SELECT * FROM medics");
                        $doctorstmt->execute();
                        $doctorrow = $doctorstmt->fetchAll(PDO::FETCH_ASSOC);

                        // Consulta de citas
                        $appointmentstmt = Conexion::conectar()->prepare("SELECT * FROM appointment WHERE appodate >= :today");
                        $appointmentstmt->bindParam(':today', $today, PDO::PARAM_STR);
                        $appointmentstmt->execute();
                        $appointmentrow = $appointmentstmt->fetchAll(PDO::FETCH_ASSOC);

                        // Consulta de sesiones
                        $schedulestmt = Conexion::conectar()->prepare("SELECT * FROM schedule WHERE scheduledate = :today");
                        $schedulestmt->bindParam(':today', $today, PDO::PARAM_STR);
                        $schedulestmt->execute();
                        $schedulerow = $schedulestmt->fetchAll(PDO::FETCH_ASSOC);

                        // Obtener el número de filas en las matrices
                        $doctor_count = count($doctorrow);
                        $patient_count = count($patientrow);
                        $appointment_count = count($appointmentrow);
                        $schedule_count = count($schedulerow);

                        // Puedes usar $patientrow, $doctorrow, $appointmentrow y $schedulerow en tu código aquí
                    } catch (PDOException $e) {
                        echo "Error en la conexión o consulta: " . $e->getMessage();
                    }

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
            <table class="filter-container doctor-header patient-header" style="border: none;width:95%" border="0">
                <tr>
                    <td>
                        <h3>Bienvenido!</h3>
                        <h1><?php echo $username  ?>!</h1>
                        <p>¿No sabes como hacer el proceso? Puedes saltar directamente a la sección de
                            <a href="doctors.php" class="non-style-link"><b>"Todos los Doctores"</b></a> o verificar la sección de tus
                            <a href="schedule.php" class="non-style-link"><b>"Citas"</b> </a><br>
                            Puedes hacer un seguimiento de tu historial de citas pasadas y futuras. Infórmate también de la hora prevista de llegada de tu médico.<br><br>
                        </p>

                        <h3>Puedes buscar tu doctor aquí</h3>
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
                </tr>
            </table>
        </center>
    </td>
</tr>
<tr>
    <td colspan="4">
        <table border="0" width="100%">
            <tr>
                <td width="50%">

            <tr>
                <td colspan="4">
                <table border="0" width="100%">
    <tr>
        <td width="50%">
            <center>
                <table class="filter-container" style="border: none;" border="0">
                    <tr>
                        <td colspan="4">
                            <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Inicio</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;">
                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex">
                                <div>
                                    <div class="h1-dashboard">
                                        <?php echo count($doctorrow)?>
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
                                        <?php echo count($patientrow)  ?>
                                    </div><br>
                                    <div class="h3-dashboard">
                                        Pacientes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../../img/icons/patients-hover.svg');"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;">
                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex; ">
                                <div>
                                    <div class="h1-dashboard">
                                        <?php echo count($appointmentrow)  ?>
                                    </div><br>
                                    <div class="h3-dashboard">
                                        Nuevas Citas &nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('../../img/icons/book-hover.svg');"></div>
                            </div>
                        </td>
                        <td style="width: 25%;">
                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                <div>
                                    <div class="h1-dashboard">
                                        <?php echo count($schedulerow)  ?>
                                    </div><br>
                                    <div class="h3-dashboard" style="font-size: 15px">
                                        Sesiones de Hoy
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
</table>





                <td>



                    <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Tus reservas</p>
                    <center>
                        <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                            <table width="85%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Número de Citas
                                        </th>
                                        <th class="table-headin">
                                            Cita
                                        </th>
                                        <th class="table-headin">
                                            Doctor
                                        </th>
                                        <th class="table-headin">
                                            Fecha y Hora Programadas
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                try {
                                    $today = date("Y-m-d"); // Obtiene la fecha actual
                                    $nextweek = date("Y-m-d", strtotime("+1 week")); // Obtiene la fecha de una semana en el futuro
                                    
                                    // Prepara la consulta SQL utilizando parámetros preparados
                                    $sqlmain = "SELECT * FROM schedule 
                                                INNER JOIN appointment ON schedule.scheduleid = appointment.schedule_id
                                                INNER JOIN patients ON patients.id_patient = appointment.patient_id 
                                                INNER JOIN medics ON medics.id_medic = schedule.id_medic
                                                WHERE patients.id_patient = :userid 
                                                AND schedule.scheduledate >= :today 
                                                AND schedule.scheduledate <= :nextweek";
                                    
                                    $stmt = Conexion::conectar()->prepare($sqlmain);
                                    $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
                                    $stmt->bindParam(':today', $today, PDO::PARAM_STR);
                                    $stmt->bindParam(':nextweek', $nextweek, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    // var_dump($result);
                                    // exit();
                                    
                                    if (empty($result)) {
                                        echo '<tr>
                                                <td colspan="4">
                                                <br><br><br><br>
                                                <center>
                                                <img src="../../img/notfound.svg" width="25%">
                                                <br>
                                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Sin información que mostrar!</p>
                                                <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Doctor &nbsp;</font></button>
                                                </a>
                                                </center>
                                                <br><br><br><br>
                                                </td>
                                                </tr>';
                                    } else {
                                        foreach ($result as $row) {
                                            $scheduleid = $row["scheduleid"];
                                            $title = $row["title"];
                                            $apponum = $row["apponum"];
                                            $docname = $row["name_medic"];
                                            $scheduledate = $row["scheduledate"];
                                            $scheduletime = $row["scheduletime"];

                                            echo '<tr>
                                                    <td style="padding:30px;font-size:25px;font-weight:700;"> &nbsp;' .
                                                    $apponum
                                                    . '</td>
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
                                } catch (PDOException $e) {
                                    echo "Error en la conexión o consulta: " . $e->getMessage();
                                }
                                ?>


                                </tbody>

                            </table>
                        </div>
                    </center>







                </td>
            </tr>
        </table>
        </td>
        <tr>
            </table>
    </div>
    </div>


</body>

</html>