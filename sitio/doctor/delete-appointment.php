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

    if($_GET){
    
        //import database
        include("../modelos/conexion.php");
        $database = Conexion::conectar();
        //$id=$_GET["id"];
        $id = $_GET["id"];
        $id2 = $_GET["scheduleid"];
        // var_dump($id2);
        // exit();
        
        $sql2 = $database->prepare("UPDATE schedule SET nop = nop + 1 WHERE scheduleid = $id2");
        $sql2->execute();
        $sql= $database->prepare("DELETE FROM appointment WHERE appointment_id='$id';");
        $sql->execute();
        //$sql= $database->prepare("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: appointment.php");
    }


?>