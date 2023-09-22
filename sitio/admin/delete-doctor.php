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
        include("../modelos/conexion.php");
        $database = Conexion::conectar();
        $id=$_GET["id"];
        //$result001= $database->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["docemail"];
        $sql = $database->prepare("UPDATE medics SET is_active = 0 WHERE id_medic = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        //$sql= $database->query("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: doctors.php");
    }

?>