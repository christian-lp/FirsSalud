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
    } else {
        // No se encontraron resultados
        // Puedes manejar esto según tus necesidades
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
    <?php
    //echo $userid;
    //echo $username;

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $today = date('d-M-Y');
    //echo $userid;
    ?>
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
                                    <a href="../logout.php"><input type="button" value="Cerrar Sesión" class="logout-btn btn-primary-soft btn"></a>
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
    <?php
    $sqlmain = "SELECT * FROM schedule INNER JOIN medics ON schedule.id_medic = medics.id_medic WHERE schedule.scheduledate >= :today ORDER BY schedule.scheduledate ASC";
    $sqlpt1 = "";
    $insertkey = "";
    $q = '';
    $searchtype = "Cantidad ";

    if ($_POST) {
        if (!empty($_POST["search"])) {
            $keyword = $_POST["search"];
            $sqlmain = "SELECT * FROM schedule INNER JOIN medics ON schedule.id_medic = medics.id_medic WHERE schedule.scheduledate >= :today AND (medics.name_medic = :keyword OR medics.name_medic LIKE :keywordLike OR schedule.title = :keyword OR schedule.title LIKE :keywordLike OR schedule.scheduledate LIKE :keywordLike) ORDER BY schedule.scheduledate ASC";
            $insertkey = $keyword;
            $searchtype = "Resultados de búsqueda: ";
            $q = '"';
        }
    }

    try {
        $pdo = Conexion::conectar(); // Crear una conexión PDO utilizando tu clase de conexión

        $stmt = $pdo->prepare($sqlmain);
        $stmt->bindParam(':today', $today, PDO::PARAM_STR);

        if (!empty($keyword)) {
            $keywordParam = "%$keyword%";
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->bindParam(':keywordLike', $keywordParam, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowCount = count($result); // Obtener el número de filas

        // Resto de tu código ...
    } catch (PDOException $e) {
        echo "Error en la conexión o consulta: " . $e->getMessage();
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

                    <input type="search" name="search" class="input-text header-searchbar" placeholder="Búsqueda por Nombre, Doctor o Correo or Date (YYYY-MM-DD)" list="doctors" value="<?php echo $insertkey ?>">&nbsp;&nbsp;

                    <?php
                    // Conexión a la base de datos utilizando tu clase de conexión
                    $database = Conexion::conectar();
                    $sqlMedics = "SELECT name_medic FROM medics";
                   
                    $stmtMedics = $database->prepare($sqlMedics);
                    $stmtMedics->execute();
                    $medicResults = $stmtMedics->fetchAll(PDO::FETCH_ASSOC);
                    // var_dump($medicResults);
                    // exit;
                    // Corrección de la consulta SQL

                    // $sqlSchedule = "SELECT DISTINCT title FROM schedule GROUP BY title";
                    // $stmtSchedule = $pdo->prepare($sqlSchedule);
                    // $stmtSchedule->execute();
                    // $scheduleResults = $stmtSchedule->fetchAll(PDO::FETCH_ASSOC);

                    echo '<datalist id="doctors">';

                    // Iterar a través de los resultados de médicos
                    foreach ($medicResults as $row00) {
                        $d = $row00["name_medic"];
                        echo "<option value='$d'><br/>";
                    }

                    // Iterar a través de los resultados de títulos de horarios
                    // foreach ($scheduleResults as $row00) {
                    //     $d = $row00["title"];
                    //     echo "<option value='$d'><br/>";
                    // }

                    // echo ' </datalist>';

                    // Cerrar la conexión a la base de datos
                    $database = null;
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
                <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype . " Citas" . "(" . $rowCount . ")"; ?> </p>
                <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q . $insertkey . $q; ?> </p>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <center>
                    <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">

                            <tbody>

                                <?php

                                if ($rowCount == 0) {
                                    echo '<tr>
                                <td colspan="4">
                                <br><br><br><br>
                                <center>
                                <img src="../../img/notfound.svg" width="25%">

                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No pudimos encontrar nada relacionado con tus palabras clave.</p>
                                <a class="non-style-link" href="schedule.php"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todas las sesiones &nbsp;</font></button>
                                </a>
                                </center>
                                <br><br><br><br>
                                </td>
                                </tr>';
                                } else {
                                    //echo $rowCount;
                                    for ($x = 0; $x < $rowCount; $x++) {
                                        echo "<tr>";
                                        for ($q = 0; $q < 3; $q++) {
                                            $row = $result[$x];
                                            $scheduleid = isset($row["scheduleid"]) ? $row["scheduleid"] : '';
                                            $title = isset($row["title"]) ? $row["title"] : '';
                                            $docname = isset($row["name_medic"]) ? $row["name_medic"] : '';
                                            $scheduledate = isset($row["scheduledate"]) ? $row["scheduledate"] : '';
                                            $scheduletime = isset($row["scheduletime"]) ? $row["scheduletime"] : '';

                                            if ($scheduleid == "") {
                                                break;
                                            }

                                            echo '
                                            <td style="width: 25%;">
                                                    <div class="dashboard-items search-items">

                                                        <div style="width:100%">
                                                                <div class="h1-search">
                                                                    ' . substr($title, 0, 21) . '
                                                                </div><br>
                                                                <div class="h3-search">
                                                                    ' . substr($docname, 0, 30) . '
                                                                </div>
                                                                <div class="h4-search">
                                                                    ' . $scheduledate . '<br>Empieza: <b>@' . substr($scheduletime, 0, 5) . '</b> (24h)
                                                                </div>
                                                                <br>
                                                                <a href="booking.php?id=' . $scheduleid . '" ><button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Reservar Ahora</font></button></a>
                                                        </div>

                                                    </div>
                                                </td>';
                                        }
                                        echo "</tr>";
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