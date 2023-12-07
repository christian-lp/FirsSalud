<?php

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
    $database = Conexion::conectar();

    $sql = "select * from medics where email_medic ='$useremail'";
    // Prepara la consulta SQL
    $stmt = $database->prepare($sql);
    $stmt->bindParam(1, $useremail, PDO::PARAM_STR);

    // Si se está ejecutando la sentencia SQL
    if ($stmt->execute())
    {
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $userid = $resultado["id_medic"];
        $username = $resultado["name_medic"];
        // var_dump($userid);
        // exit();
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

    <title>Pacientes</title>
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
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu ">
                            <div>
                                <p class="menu-text">Inicio</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Mis Citas</p>
                            </div>
                        </a>
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
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Mis Pacientes</p>
                        </a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Configuración</p>
                            </div>
                        </a>
                    </td>
                </tr>
        </table>
    </div>
    <?php

    $selecttype = "Mis";
    $current = "Solo mis Pacientes";
    if ($_POST) {

        if (isset($_POST["search"])) {
            $keyword = $_POST["search12"];

            $sqlmain = "select * from patients where email='$keyword' or name='$keyword' or name like '$keyword%' or name like '%$keyword' or name like '%$keyword%' ";
            $selecttype = "my";
        }

        if (isset($_POST["filter"])) {
            if ($_POST["showonly"] == 'all') {
                $sqlmain = "select * from patients";
                $selecttype = "All";
                $current = "Todos los pacientes";
            } else {
                $sqlmain = "SELECT DISTINCT * 
                FROM appointment 
                INNER JOIN patients ON patients.id_patient=appointment.patient_id 
                INNER JOIN schedule ON schedule.scheduleid=appointment.schedule_id 
                WHERE schedule.id_medic=$userid;";
                $selecttype = "Mis";
                $current = "Solo mis Pacientes";
            }
        }
    } else {
        $sqlmain = "SELECT * FROM appointment
        INNER JOIN patients ON patients.id_patient=appointment.patient_id
        INNER JOIN schedule ON schedule.scheduleid=appointment.schedule_id
        WHERE schedule.id_medic=$userid;";

        $selecttype = "Mis";
    }



    ?>
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

                        <input type="search" name="search12" class="input-text header-searchbar" placeholder="Búsqueda Nombre de Paciente or Email" list="patient">&nbsp;&nbsp;

                        <?php
        
                        echo '<datalist id="patient">';
                        $list11 = $database->prepare($sqlmain);
                        $list11->execute();
                        // Obtiene los resultados
                        $stmt2 = $list11->fetchAll(PDO::FETCH_ASSOC);
                        // Cuenta el número de filas
                        $num_rows = count($stmt2);

                        // Verifica si la consulta está retornando datos
                        if ($num_rows > 0) {
                            for ($y = 0; $y < $num_rows; $y++) {
                                $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                                $d = $row00["name"];
                                $c = $row00["email"];
                                echo "<option value='$d'><br/>";
                                echo "<option value='$c'><br/>";
                            };
    
                            echo ' </datalist>';
                        } else {
                            // La consulta no retornó resultados
                            echo "No se encontraron resultados.";
                        }
                    
                        ?>


                        <input type="Submit" value="Búsqueda" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                    </form>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php
                        date_default_timezone_set('America/Bogota');

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
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype . " Pacientes (" . $num_rows . ")"; ?></p>
                </td>

            </tr>
            <tr>
                <td colspan="4" style="padding-top:0px;width: 100%;">
                    <center>
                        <table class="filter-container" border="0">

                            <form action="" method="post">

                                <td style="text-align: right;">
                                    Mostrar Información de: &nbsp;
                                </td>
                                <td width="30%">
                                    <select name="showonly" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;">
                                        <option value="" disabled selected hidden><?php echo $current   ?></option><br />
                                        <option value="my">Solo mis Pacientes</option><br />
                                        <option value="all">Todos los Pacientes</option><br />


                                    </select>
                                </td>
                                <td width="12%">
                                    <input type="submit" name="filter" value=" Filtro" class=" btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin :0;width:100%">
                            </form>
                </td>

            </tr>
        </table>

        </center>
        </td>

        </tr>

        <tr>
            <td colspan="4">
                <center>
                    <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                            <thead>
                                <tr>
                                    <th class="table-headin">


                                        Nombre

                                    </th>
                                    <th class="table-headin">


                                        DNI

                                    </th>
                                    <th class="table-headin">


                                        Teléfono

                                    </th>
                                    <th class="table-headin">
                                        Email
                                    </th>
                                    <th class="table-headin">

                                        Historia Clinica

                                    </th>
                                    <th class="table-headin">

                                        Eventos

                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $result = $database->prepare($sqlmain);
                                $result->execute();
                                $stmt = $result->fetchAll(PDO::FETCH_ASSOC);
                                // var_dump($stmt);
                                //         exit();
                                $num_rows = count($stmt); // Obtener el número de filas
                                // var_dump($num_rows);
                                // exit();
                                if ($num_rows == 0) {
                                    echo '<tr>
                                    <td colspan=s"4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Pacientes &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                } else {
                                    foreach ($stmt as $row) {
                                        $pid = $row["id_patient"];
                                        $name = $row["name"];
                                        $email = $row["email"];
                                        $dni = $row["dni"];
                                        $birth = $row["day_of_birth"];
                                        $tel = $row["phone"];
                                        $id_history =$row["id_clinic_history"];
                                        $clinic_history = $row["clinic_history"];

                                        echo '<tr>
                                        <td> &nbsp;' .
                                            substr($name, 0, 35)
                                            . '</td>
                                        <td>
                                        ' . substr($dni, 0, 12) . '
                                        </td>
                                        <td>
                                            ' . substr($tel, 0, 10) . '
                                        </td>
                                        <td>
                                        ' . substr($email, 0, 20) . '
                                        </td>
                                        <td style="display:flex;justify-content: center; margin-top: 18px;">
                                        ' . substr($id_history, 0, 255) . '
                                        </td>
                                        <td >
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <a href="?action=view&id=' . $pid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Historia Clinica</font></button></a>
                                    
                                        </div>
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



        </table>
    </div>
    </div>
    <?php
    if ($_GET) {

        $id = $_GET["id"];
        $action = $_GET["action"];
        $sqlmain = "SELECT 
        patients.id_patient,
        patients.name,
        clinic_history.*,
        symptoms.*
        FROM patients
        INNER JOIN clinic_history ON patients.id_patient = clinic_history.id_patient
        INNER JOIN clinic_history_symptoms ON clinic_history.id_clinic_history = clinic_history_symptoms.id_clinic_history
        INNER JOIN symptoms ON clinic_history_symptoms.code = symptoms.code
        WHERE patients.id_patient = '$id'
        LIMIT 0, 25;";
        $result = $database->prepare($sqlmain);
        $result->execute();
        
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $row2 = $result->fetchAll(PDO::FETCH_ASSOC);
        $name = $row["name"];
        $num_clinic_history = $row["id_clinic_history"];
        $clinic_history = $row["clinic_history"];
        $symptoms = $row["description"];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <div class="abc scroll" style="height: 500px;padding: 0;margin: 0;">
                            <table width="85%" class="sub-table scrolldown" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Ver Detalles</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <strong><label for="name" class="form-label">ID Paciente: </label></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    P-' . $id . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <strong><label for="name" class="form-label">Nombre: </label></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <strong><label for="Email" class="form-label">N° Historia Clinica: </label></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $num_clinic_history . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <strong><label for="nic" class="form-label">Historia Clinica: </label></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $clinic_history . '<br><br>
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <strong><label for="Tele" class="form-label">Síntomas: </label></strong>
                                </td>
                            </tr>
                            <td class="label-td" colspan="2">
                            ' . $symptoms . '<br><br>
                            </td>
                            
                            <tr>
                                <td colspan="2">
                                    <a href="patient.php"><input type="button" value="EDITAR" class="login-btn btn-primary-soft btn" ></a>
                                </td>
                                <td colspan="2">
                                    <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                </td>
                            </tr>


                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
    };

    ?>
    </div>

</body>

</html>