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

// Importar la conexión
include("../modelos/conexion.php");
$database = Conexion::conectar();
$userrow = $database->prepare("select * from patients where email='$useremail'");
$userrow->execute();
$userfetch = $userrow->fetch(PDO::FETCH_ASSOC);
$userid = $userfetch["id_patient"];
$username = $userfetch["name"];

if ($_POST) {
    if (isset($_POST["booknow"])) {
        $apponum = $_POST["apponum"];
        $scheduleid = $_POST["scheduleid"];
        $nop = $_POST["nop"];
        // var_dump($nop);
        // exit();

        $date = date('Y-m-d', strtotime($_POST["date"]));

        try {
            if ($nop > 0) {
                // Utiliza sentencias preparadas para evitar inyección SQL
                $sql2 = "INSERT INTO appointment (schedule_id, patient_id, appodate, apponum) VALUES (?, ?, ?, ?)";
                $stmt = $database->prepare($sql2);
                // var_dump($scheduleid);
                // exit();
        
                // Asocia los parámetros con los valores
                $stmt->bindParam(1, $scheduleid, PDO::PARAM_INT);
                $stmt->bindParam(2, $userid, PDO::PARAM_INT);
                $stmt->bindParam(3, $date, PDO::PARAM_STR);
                $stmt->bindParam(4, $apponum, PDO::PARAM_STR);
        
                if ($stmt->execute()) {
                    // Actualiza el valor de nop en la base de datos
                    $sql = "UPDATE schedule SET schedule.nop = schedule.nop - 1 WHERE schedule.scheduleid = $scheduleid";
                    // var_dump($sql);
                    // exit();
                    $stmt2 = $database->prepare($sql);
                    $stmt2->execute();
        
                    // Redirige después de actualizar la base de datos
                    header("location: appointment.php?action=booking-added&id=" . $apponum . "&titleget=none");
                    exit; // Importante salir del script después de redirigir
                } else {
                    echo "Error al insertar la cita: " . $stmt->errorInfo()[2]; // Muestra detalles del error.
                }
            } else {
                echo "Error al insertar la cita: " . $stmt->errorInfo()[2]; // Muestra detalles del error.
            }
        } catch (PDOException $e) {
            echo "Error de PDO: " . $e->getMessage(); // Muestra errores PDO.
        }
        
    }
}
?>
