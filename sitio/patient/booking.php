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
    $database = Conexion::conectar();

    $sql = "SELECT * FROM patients WHERE email = :useremail";
    // Prepara la consulta SQL
    $stmt = $database->prepare($sql);
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

    date_default_timezone_set('America/Argentina/Buenos_Aires');

    $today = date('d-M-Y');

    //echo $userid;
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

    <title>Citas</title>
    <style>
        .popup {
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
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
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
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home ">
                        <a href="index.php" class="non-style-link-menu ">
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
                        <p class="menu-text">Doctores</p>
                </a>
    </div>
    </td>
    </tr>

    <tr class="menu-row">
        <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
            <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active">
                <div>
                    <p class="menu-text">Citas</p>
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

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="schedule.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Volver</font>
                        </button></a>
                </td>
                <td>
                <form action="schedule.php" method="post" class="header-search">
                    <input type="search" name="search" class="input-text header-searchbar" placeholder="Búsqueda Doctor, Nombre, Correo, Fecha (YYYY-MM-DD)" list="doctors">&nbsp;&nbsp;

                    <?php
                    echo '<datalist id="doctors">';
                    $list11 = $database->prepare("select DISTINCT * from  medics;");
                    $list11->execute();
                    $num_rows11 = $list11->rowCount();
                
                    $list12 = $database->prepare("select DISTINCT * from  schedule GROUP BY title;");
                    $list12->execute();
                    $num_rows12 = $list12->rowCount();
                    

                    for ($y = 0; $y < $num_rows11; $y++) {
                        $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                        $d = $row00["name_medic"];
                        echo "<option value='$d'>";
                    }

                    for ($y = 0; $y < $num_rows12; $y++) {
                        $row00 = $list12->fetch(PDO::FETCH_ASSOC);
                        $d = $row00["title"];
                        echo "<option value='$d'>";
                    }

                    echo '</datalist>';
                    ?>

                    <input type="submit" value="Búsqueda" class="login-btn btn-primary btn" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
                </form>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php

                        echo $today;

                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../../img/calendar.svg" width="100%"></button>
                </td>


            </tr>


            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <!-- <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49);font-weight:400;">Citas / Booking / <b>Review Booking</b></p> -->

                </td>

            </tr>



            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">

                                <tbody>

                                    <?php

                                    if (($_GET)) {

                                        if (isset($_GET["id"])) {
                                            $list12 = $database->prepare("select DISTINCT * from  schedule;");
                                            $list12->execute();
                                            $num_rows12 = $list12->rowCount();
                                            // var_dump($num_rows12);
                                            // exit();
                        

                                            $id = $_GET["id"];
                                            // var_dump($id);
                                            // exit;

                                            $sqlmain = "SELECT * FROM schedule
                                            INNER JOIN medics ON schedule.id_medic = medics.id_medic
                                            WHERE schedule.scheduleid = '$id'
                                            ORDER BY schedule.scheduledate DESC";
                                
                                            $result = $database->prepare($sqlmain);
                                            $result->execute();
                                            $row = $result->fetch(PDO::FETCH_ASSOC);
                                            // var_dump($row);
                                            // exit();
                                            $scheduleid = $row["scheduleid"];
                                            $title = $row["title"];
                                            $docname = $row["name_medic"];
                                            $docemail = $row["email_medic"];
                                            $scheduledate = $row["scheduledate"];
                                            $scheduletime = $row["scheduletime"];
                                            $nop = $row["nop"];
                                            //cho $nop;

                                            $sql2 = "select * from appointment where schedule_id=$id";
                                            // echo $sql2;
                                            $result12 = $database->prepare($sql2);
                                            $apponum = ($num_rows12);
                                            

                                            echo '
                                            <form action="booking-complete.php" method="post">
                                                <input type="hidden" name="scheduleid" value="' . $scheduleid . '" >
                                                <input type="hidden" name="apponum" value="' . $apponum . '" >
                                                <input type="hidden" name="date" value="' . $today . '" >
                                                <input type="hidden" name="nop" value="' . $nop . '" >
                                                <input type="hidden" name="scheduledate" value="' . $scheduledate . '" >
                                                <input type="hidden" name="scheduletime" value="' . $scheduletime . '" >
                                                <input type="hidden" name="title" value="' . $title . '" >
                                                <input type="hidden" name="name_medic" value="' . $docname . '" >
                                                <input type="hidden" name="email_medic" value="' . $docemail . '" >

                                                ';
                                            echo '
                                            <td style="width: 50%;" rowspan="2">
                                            <div  class="dashboard-items search-items"  >
                                            
                                                <div style="width:100%">
                                                        <div class="h1-search" style="font-size:25px;">
                                                            Información Citas
                                                        </div><br><br>
                                                        <div class="h3-search" style="font-size:18px;line-height:30px">
                                                            Nombre Doctor:  &nbsp;&nbsp;<b>' . $docname . '</b><br>
                                                            Correo Doctor:  &nbsp;&nbsp;<b>' . $docemail . '</b> 
                                                        </div>
                                                        <div class="h3-search" style="font-size:18px;">

                                                        </div><br>
                                                        <div class="h3-search" style="font-size:18px;">
                                                            Título Cita: ' . $title . '<br>
                                                            Fecha programada de la sesión: ' . $scheduledate . '<br>
                                                            Cita Empieza: ' . $scheduletime . '<br>
                                                            

                                                        </div>
                                                        <br>
                                                        
                                                </div>
                                                            
                                                </div>
                                            </td>
                                            
                                            <td style="width: 25%;">
                                                <div  class="dashboard-items search-items"  >
                                                
                                                <div style="width:100%;padding-top: 15px;padding-bottom: 15px;">
                                                        <div class="h1-search" style="font-size:20px;line-height: 35px;margin-left:8px;text-align:center;">
                                                        Tu número de cita
                                                        </div>
                                                        <center>
                                                        <div class=" dashboard-icons" style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">' . $apponum . '</div>
                                                    </center>
                                                        </div><br>
                                                        
                                                        <br>
                                                        <br>
                                                </div>
                                                        
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="Submit" class="login-btn btn-primary btn btn-book" style="margin-left:10px;padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;width:95%;text-align: center;" value="Reserva ya  " name="booknow"></button>
                                            </form>
                                            </td>
                                        </tr>
                                        ';
                                        }
                                    }

                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </center>
                </td>
            </tr>



        </table>
    </div>
    </div>



    </div>

</body>

</html>