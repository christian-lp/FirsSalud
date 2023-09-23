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
    
    if($_GET){
        $id=$_GET["id"];
        //$result001= $database->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["docemail"];
        $sql= $database->query("DELETE FROM appointment WHERE appointment_id='$id';");
        //$sql= $database->query("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: appointment.php");
    }


?>