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

    
    if($_POST){
        //import database
        include("../modelos/conexion.php");
        $database = Conexion::conectar();
        $title=$_POST["title"];
        $docid=$_POST["id_medic"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        $sql = "INSERT INTO schedule (title, id_medic, scheduledate, scheduletime, nop) VALUES ('$title', '$docid', '$date', '$time', $nop);";
        $result= $database->prepare($sql);
        $result->execute();
        // var_dump($time);
        // exit;
        header("location: schedule.php?action=session-added&title=$title");
        
    }


?>