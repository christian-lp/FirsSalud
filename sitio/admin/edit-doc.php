<?php
//import database
include("../modelos/conexion.php");

if ($_POST) {
    //print_r($_POST);
    $database = Conexion::conectar();
    $result = $database->prepare("select * from medics");
    $name = $_POST['name_medic'];
    $dni = $_POST['dni_medic'];
    $oldemail = $_POST["email_medic"];
    $spec = $_POST['specialty_medic'];
    $email = $_POST['email_medic'];
    $tele = $_POST['phone_medic'];
    $password = $_POST['password_medic'];
    $cpassword = $_POST['cpassword_medic'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';
        $result = $database->prepare("select from medics where id_medic='$id';");
        $result->execute();
        $num_rows = $result->rowCount();
        //$resultqq= $database->query("select * from doctor where docid='$id';");
        if ($num_rows == 1) {
            $id2 = $result->fetch(PDO::FETCH_ASSOC)["id_medic"];
        } else {
            $id2 = $id;
        }
            echo $id2 . "jdfjdfdh";
            if ($id2 != $id) {
                $error = '1';
        } else {

            //$sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
            $sql1 = "update medics set email_medic='$email',name_medic='$name',password_medic='$password',dni_medic='$dni',phone_medic='$tele',specialty_medic=$spec where id_medic=$id ;";
            $database->prepare($sql1);

            // $sql1 = "update webuser set email='$email' where email='$oldemail' ;";
            // $database->prepare($sql1);
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
header("location: doctors.php?action=edit&error=" . $error . "&id=" . $id);
?>



</body>

</html>
