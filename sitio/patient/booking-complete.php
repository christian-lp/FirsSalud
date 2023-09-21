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
    $userrow = $database->prepare("select * from patients where email='$useremail'");
    $userfetch=$userrow->fetch(PDO::FETCH_ASSOC);
    $userid= $userfetch["id_patient"];
    $username=$userfetch["name"];


    if($_POST){
        if(isset($_POST["booknow"])){
            $apponum=$_POST["apponum"];
            $scheduleid=$_POST["scheduleid"];
            $date=$_POST["date"];
            $scheduleid=$_POST["scheduleid"];
            $sql2 = "INSERT INTO appointment (patient_id, apponum, scheduleid, appodate) VALUES ('$scheduleid', '$userid', '$date', '$apponum')";
            $result= $database->prepare($sql2);
            //echo $apponom;
            header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");

        }
    }
 ?>