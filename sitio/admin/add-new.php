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


include("../modelos/conexion.php");

$database = Conexion::conectar();

if ($_POST) {
    $result = $database->prepare("select * from medics");
    $result->execute();
    $name = $_POST['name_medic'];
    $surname = $_POST['surname_medic'];
    $spec = $_POST['specialty_medic'];
    $gen = $_POST['gender_medic'];
    $birth = $_POST['day_of_birth_medic'];
    $matri = $_POST['matricul_medic'];
    $email = $_POST['email_medic'];
    $tele = $_POST['phone_medic'];
    $password = $_POST['password_medic'];
    $cpassword = $_POST['cpassword_medic'];

    if ($password == $cpassword) {
        // Verifica si ya existe un médico con el mismo DNI
        $consultaDniExistente = "SELECT * FROM medics WHERE matricul_medic = :matri";
        $stmtDni = $database->prepare($consultaDniExistente);
        $stmtDni->bindParam(':matri', $matri);
        $stmtDni->execute();

        if ($stmtDni->rowCount() > 0) {
            // Muestra una alerta si ya existe un médico con el mismo DNI
            echo "<script>alert('Ya existe un médico con este DNI. Por favor, verifica el DNI e intenta de nuevo.');</script>";
        } else {
            // Codigo de insercion
            $sql1 = "INSERT INTO medics(matricul_medic, email_medic, name_medic, surname_medic, gender_medic, day_of_birth_medic, password_medic, phone_medic, specialty_medic) 
            VALUES ('$matri', '$email', '$name', '$password', '$tele', $spec);";
            $hola = $database->prepare($sql1);
            $hola->execute();
            
            if ($hola->execute()) {
                // Éxito en la inserción
                echo "<script>alert('Médico registrado con éxito.');</script>";
            } else {
                // Error en la inserción
                echo "<script>alert('Hubo un error al registrar al médico.');</script>";
            }
        }
    } else {
        // Error de confirmación de contraseña. Vuelve a confirmar la contraseña.
        echo "<script>alert('Error de confirmación de contraseña. Vuelve a confirmar la contraseña.');</script>";
    }

    // Redireccionanamiento
    header("location: doctors.php?action=add");
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
