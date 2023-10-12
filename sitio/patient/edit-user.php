<?php

//import database
include("../modelos/conexion.php");
$database = Conexion::conectar();

if ($_POST) {
    //print_r($_POST);
    $result = $database->prepare("select * from patients");
    $result->execute();
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $tele = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $hashedPassword = md5($password); // Hashear la contraseña con MD5
        $error = '3';
        $result = $database->prepare("Select from patients where patients.email='$email';");
        $result->execute();
        $num_rows = $result->rowCount();
        //$resultqq= $database->query("select * from doctor where docid='$id';");
        if ($num_rows == 1) {
            $id2 = $result->fetch(PDO::FETCH_ASSOC)["id_patient"];
        } else {
            $id2 = $id;
        }

        // echo $id2 . "jdfjdfdh";
        if ($id2 != $id) {
            $error = '1';
            //$resultqq1= $database->query("select * from doctor where docemail='$email';");
            //$did= $resultqq1->fetch_assoc()["docid"];
            //if($resultqq1->num_rows==1){

        } else {

            //$sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
            $sql1 = "UPDATE patients SET email='$email', name ='$name', password ='$hashedPassword',dni='$dni',phone='$tele' 
            WHERE id_patient=$id ;";
            $result = $database->prepare($sql1);
            $result->execute();
            // $sql1 = "update webuser set email='$email' where email='$oldemail' ;";
            // $database->query($sql1);
            //echo $sql1;
            //echo $sql2;
            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    //header('location: signup.php');
    $error = '3';
}


header("location: settings.php?action=edit&error=" . $error . "&id=" . $id);
?>



</body>

</html>