<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../modelos/conexion.php");
    $database = Conexion::conectar();
    
    if($_GET){
        $id=$_GET["id"];
        //$result001= $database->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["docemail"];
        $sql= $database->prepare("DELETE FROM patients WHERE id_patient='$id';");
        $sql->execute();
        //$sql= $database->query("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: ../vistas/login/logout.php");
    }

?>