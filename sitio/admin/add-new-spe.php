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

// Importar la conexión a la base de datos
include("../modelos/conexion.php");

$database = Conexion::conectar();

if ($_POST) {
    $newSpe = $_POST["name_specialty"];
    $sqlsp = "INSERT INTO specialties (specialty_name)
    VALUE ('$newSpe')";
    $stmt = $database->prepare($sqlsp);
    $stmt->execute();
   // var_dump($stmt);

    $error = '4';
    header("location: doctors.php?action=add&error=" . $error);
    
}