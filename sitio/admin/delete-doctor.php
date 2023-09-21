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

    
    if($_GET){
        //import database
        include("../conexion.php");
        $database = Conexion::conectar();
        $id=$_GET["id"];
        $result001= $database->prepare("select * from medics where id_medic=$id;");
        $email=($result001->fetch(PDO::FETCH_ASSOC))["email_medic"];
        // $sql= $database->query("delete from webuser where email='$email';");
        $sql= $database->prepare("delete from medics where email_medic='$email';");
        //print_r($email);
        header("location: doctors.php");
    }


?>