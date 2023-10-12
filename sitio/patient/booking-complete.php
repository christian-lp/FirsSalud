<?php
session_start();

if (isset($_SESSION["usr_rol"])) 
{
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '1') 
    {
        header("location: ../vistas/login/login.php");
    } 
    else
    {
        $useremail = $_SESSION["email"];
    }
} 
else
{
    header("location: ../vistas/login/login.php");
}

// Importar la conexión
include("../modelos/conexion.php");
$database = Conexion::conectar();
$userrow = $database->prepare("select * from patients where email='$useremail'");
$userrow->execute();
$userfetch = $userrow->fetch(PDO::FETCH_ASSOC);
$userid = $userfetch["id_patient"];
$username = $userfetch["name"];

if ($_POST) 
{
    if (isset($_POST["booknow"])) 
    {
        //print_r($_POST);
        $apponum = $_POST["apponum"];
        $scheduleid = $_POST["scheduleid"];
        $scheduledate = $_POST["scheduledate"];
        $scheduletime = $_POST["scheduletime"];
        $title = $_POST["title"];
        $docname = $_POST["name_medic"];
        $docemail = $_POST["email_medic"];
        $nop = $_POST["nop"];
        // var_dump($nop);
        // exit();

        try
        {
            if ($nop > 0) 
            {
                // Utiliza sentencias preparadas para evitar inyección SQL
                $sql2 = "INSERT INTO appointment (schedule_id, patient_id, appodate, apponum) VALUES (?, ?, ?, ?)";
                $stmt = $database->prepare($sql2);
                // var_dump($scheduleid);
                // exit();
        
                // Asocia los parámetros con los valores
                $stmt->bindParam(1, $scheduleid, PDO::PARAM_INT);
                $stmt->bindParam(2, $userid, PDO::PARAM_INT);
                $stmt->bindParam(3, $date, PDO::PARAM_STR);
                $stmt->bindParam(4, $apponum, PDO::PARAM_STR);
        
                if ($stmt->execute()) 
                {
                    include("../funciones/turnConf.php");
                    if (is_readable("../data/config.txt"))
                    {
                        $config_file=fopen('../data/config.txt','r+') or die ("Error de apertura de archivo, consulte con el administrador...");
                        while(!feof($config_file))
                        {

                            $linea=fgets($config_file);
                            if (!empty($linea)){
                                $datos=explode("|",$linea);
                                $site=$datos[0];
                                $sourcemail= $datos[1];
                                $passmail=$datos[2];
                            }
                        }
                        
                        enviar_mail($useremail,$username,$docemail,$docname,$apponum,$scheduledate,$scheduletime,$title,$site,$sourcemail,$passmail);

                        // Agregar JavaScript para ocultar el mensaje de éxito después de 3 segundos
                        // Ademas redirige al formulario de login
                        
                        // Actualiza el valor de nop en la base de datos
                        $sql = "UPDATE schedule SET schedule.nop = schedule.nop - 1 WHERE schedule.scheduleid = $scheduleid";
                        // var_dump($sql);
                        // exit();
                        $stmt2 = $database->prepare($sql);
                        $stmt2->execute();
            
                        // Redirige después de actualizar la base de datos
                        echo '<script>window.location.href = "appointment.php?action=booking-added&id=' . $apponum . '&titleget=none";</script>';
                        exit; // Importante salir del script después de redirigir
                    }else{
                        echo "Error al insertar la cita: " . $stmt->errorInfo()[2]; // Muestra detalles del error.
                    }
                }else{
                    echo "Error al insertar la cita: " . $stmt->errorInfo()[2]; // Muestra detalles del error.
                }
            } 
        }catch (PDOException $e){
                echo "Error de PDO: " . $e->getMessage(); // Muestra errores PDO.
            }
    }
}
?>
