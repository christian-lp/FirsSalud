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
        // Importar la conexión a la base de datos
        include("../modelos/conexion.php"); 
        $database = Conexion::conectar();
        $id=$_GET["id"];
        //$result001= $database->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["docemail"];
        $sql= $database->prepare("delete from schedule where scheduleid='$id';");
        $sql->execute();
        //$sql= $database->query("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: schedule.php");
    }


?>