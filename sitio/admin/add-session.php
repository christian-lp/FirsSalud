<?php

session_start();

if (isset($_SESSION["usr_rol"])) {
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '3') {
        header("location: ../vistas/login/login.php");
        exit; // Agregamos exit para detener la ejecución después de redireccionar
    } else {
        $useremail = $_SESSION["email"];
    }
} else {
    header("location: ../vistas/login/login.php");
    exit; // Agregamos exit para detener la ejecución después de redireccionar
}

if ($_POST) {
    // Importar la conexión a la base de datos
    include("../modelos/conexion.php");
    $database = Conexion::conectar();

    // Verificar la conexión
    // if ($database->connect_error) {
    //     die("Error en la conexión a la base de datos: " . $conn->connect_error);
    // }

    $title = $_POST["title"];
    $docid = $_POST["id_medic"];
    $fechaInicio = $_POST['start_date'];
    $fechaFin = $_POST['end_date'];
    $horaInicio = $_POST['start_time'];
    $horaFin = $_POST['end_time'];
    $duracion = $_POST['duration'];
    $nop = 1;
    // var_dump($fechaF);
    // exit(); 
    // Generar los registros de turno
    $fechaActual = new DateTime($fechaInicio);
    $fechaFin = new DateTime($fechaFin);
    
    while ($fechaActual <= $fechaFin) {
        $fecha = $fechaActual->format('Y-m-d');
        $horaActual = strtotime($horaInicio);
        
        while ($horaActual < strtotime($horaFin)) {
            $hora = date('H:i', $horaActual);
            // var_dump($hora);
            // exit();         
            // Insertar el registro de turno en la base de datos
            $sql = "INSERT INTO schedule (title, id_medic, scheduledate, scheduletime, nop) VALUES ('$title', '$docid', '$fecha', '$hora', '$nop')";
            $result = $database->prepare($sql);
            $result->execute();
            // var_dump($result);
            // exit();
    
            if ($result != TRUE) {
                echo "Error al agregar el turno: ";
            } else {    
                $nop++;
            
            }
    
            $horaActual += ($duracion * 60); // Añadir la duración en minutos al horario actual
        }
    
        // Incrementar la fecha para el siguiente día
        $fechaActual->modify('+1 day');
    }
    
    //echo "Turnos agregados exitosamente";
    // echo "<br>";
    // echo "Total de turnos agregados: " . $nop . "<br>";
    // echo "title: $title<br>";
    // echo "docid: $docid<br>";
    // echo "fecha: $fecha<br>";
    // echo "hora: $hora<br>";
    // echo "nop: $nop<br>";


    // No imprimas nada aquí, incluyendo espacios en blanco.

    header("location: schedule.php?action=session-added&title=$title");
    exit; // Agregamos exit para detener la ejecución después de redireccionar


}
?>
