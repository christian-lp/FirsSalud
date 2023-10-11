<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
 
    if($_GET){
        //import database
        include("../modelos/conexion.php");
        $database = Conexion::conectar();
        $id=$_GET["id"];
        $id2=$_GET["scheduleid"];
        // var_dump($id2);
        // exit();
        //$result001= $database->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["docemail"];
        $sql2 = $database->prepare("UPDATE schedule SET nop = nop + 1 WHERE scheduleid = $id2");
        $sql2->execute();
        $sql= $database->prepare("DELETE FROM appointment WHERE appointment_id='$id';");
        $sql->execute();
        //$sql= $database->query("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: appointment.php");
    }


?>