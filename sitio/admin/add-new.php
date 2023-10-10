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
    // Tu código de procesamiento de formulario aquí
    $result = $database->prepare("select * from medics");
    $result->execute();
    $name = $_POST['name_medic'];
    $surname = $_POST['surname_medic'];
    $spec = $_POST['specialty_medic'];
    $gen = $_POST['gender_medic'];
    $raw_birth = $_POST['day_of_birth_medic'];
    $timestamp = strtotime($raw_birth);
    $birth = date('Y-m-d', $timestamp);
    // var_dump($birth);
    // exit;
    $matri = $_POST['matricul_medic'];
    $email = $_POST['email_medic'];
    $tele = $_POST['phone_medic'];
    $password = $_POST['password_medic'];
    $cpassword = $_POST['cpassword_medic'];

    // Obtener la fecha actual
    $currentDate = new DateTime();
    $currentDate->modify('-24 years'); // Restar 24 años a la fecha actual

    if (new DateTime($birth) <= $currentDate) {
        // La fecha de nacimiento es mayor o igual a 24 años
        // Puedes continuar con el procesamiento
    } else {
        // La fecha de nacimiento es menor de 24 años
        // Muestra un mensaje de error o realiza la acción correspondiente
        echo "La fecha de nacimiento debe ser mayor o igual a 24 años.";
    }

    if ($password == $cpassword) {
        $error = '3';
        $result = $database->prepare("select * from medics where email_medic='$email'");
        $result->execute();
        $num_rows = $result->rowCount();
        if ($num_rows == 1) {
            // Ya existe una cuenta con esta dirección de correo electrónico.
            $error = '1';
        } else {
            $sql1 = "INSERT INTO medics(matricul_medic,name_medic,surname_medic,gender_medic, day_of_birth_medic,email_medic,phone_medic,specialty_medic,password_medic) 
            VALUES ('$matri','$name','$surname','$gen','$birth','$email','$tele','$spec','$password');";
            $stmt = $database->prepare($sql1);
            $stmt->execute();
            // Edición Exitosa
            $error = '4';
        }
    } else {
        // Error de confirmación de contraseña. Vuelve a confirmar la contraseña.
        $error = '2';
    }

    // Redirecciona después de procesar el formulario
    header("location: doctors.php?action=add&error=" . $error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tus encabezados HTML aquí -->
</head>
<body>
    <!-- El contenido HTML de tu página aquí -->
</body>
</html>
