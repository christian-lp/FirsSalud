<?php
//learn from w3schools.com
session_start();

if (isset($_SESSION["usr_rol"])) {
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '2') {
        header("location: ../vistas/login/login.php");
    } else {
        $useremail = $_SESSION["email_medic"];
    }
} else {
    header("location: ../vistas/login/login.php");
}


//import link
include("../modelos/conexion.php");

        $sql = "select * from medics where email_medic ='$useremail'";
		// Prepara la consulta SQL
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $useremail, PDO::PARAM_STR);
	
		// Si se está ejecutando la sentencia SQL
		if ($stmt->execute()) 
		{
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $userid = $resultado["id_medic"];
            $username = $resultado["name_medic"];
		}


// echo $userid;
// echo $username;

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
        .dashbord-tables,
        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table,
        #anim {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
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
                                    <p class="profile-title"><?php echo substr($username, 0, 13)  ?>..</p>
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
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Inicio</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-appoinment">
                <a href="appointment.php" class="non-style-link-menu">
                    <div>
                        <p class="menu-text">Mis Citas</p>
                </a>
                    </div>
        </td>
        </tr>

    <tr class="menu-row">
        <td class="menu-btn menu-icon-session">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Mis Sesiones</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-patient">
            <a href="patient.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Mis Pacientes</p>
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
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;"> Inicio</p>

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
                            $todayW = date('d-M-Y');
                            echo $todayW;
                            $today = date('Y-m-d');
                            

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
                        <table class="filter-container doctor-header" style="border: none;width:95%" border="0">
                            <tr>
                                <td>
                                    <h3>Hola de nuevo!</h3>
                                    <h1><?php echo $username  ?>.</h1>
                                    <p>Gracias por unirte a nosotros. Siempre estamos tratando de brindarle un servicio completo.<br>
                                        ¡Puede ver su horario diario, llegar a la cita de los pacientes!<br><br>
                                    </p>
                                    <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:30%">Ver Mis Citas</button></a>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </center>

                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table border="0" width="100%"">
                            <tr>
                                <td width=" 50%">


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
                <td>



                    <p id="anim" style="font-size: 20px;font-weight:600;padding-left: 40px;">Turnos reservados hasta la próxima semana</p>
                    <center>
                        <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                            <table width="85%" class="sub-table scrolldown" border="0">
                                <thead>

                                    <tr>
                                        <th class="table-headin">
                                            Nombre Sesión
                                        </th>

                                        <th class="table-headin">
                                            Fecha
                                        </th>
                                        <th class="table-headin">
                                            Hora
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    try {
                                        // Obtener la conexión utilizando la clase de conexión
                                        $conexion = Conexion::conectar();

                                        $nextweek = date("Y-m-d", strtotime("+1 week"));
                                        
                                        $sqlmain =  "SELECT schedule.scheduleid, schedule.title, schedule.scheduledate, schedule.scheduletime, appointment.schedule_id
                                        FROM schedule
                                        INNER JOIN medics ON schedule.id_medic = medics.id_medic
                                        INNER JOIN appointment ON appointment.schedule_id = schedule.scheduleid
                                        WHERE schedule.scheduledate >= '$today' AND schedule.scheduledate <= '$nextweek'
                                        ORDER BY schedule.scheduledate DESC";
                                    
                                        // var_dump($sqlmain);
                                        // exit();
                                        
                                        
                                        $stmt = $conexion->prepare($sqlmain);
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
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No se encontraron sesiones relacionadas con tus palabras clave.</p>
                                                    <a class="non-style-link" href="schedule.php"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">Mostrar todas las Sesiones</button></a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                </tr>';
                                        } else {
                                            foreach ($result as $row) {
                                                $scheduleid = $row["scheduleid"];
                                                $title = $row["title"];
                                                $docname = $row["name_medic"];
                                                $scheduledate = $row["scheduledate"];
                                                $scheduletime = $row["scheduletime"];
                                                $nop = $row["nop"];
                                                echo '<tr>
                                                        <td style="padding:20px;"> &nbsp;' . substr($title, 0, 30) . '</td>
                                                        <td style="padding:20px;font-size:18px;">' . substr($scheduledate, 0, 10) . '</td>
                                                        <td style="text-align:center;font-size:18px;">' . substr($scheduletime, 0, 5) . 'hs.'.'</td>
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