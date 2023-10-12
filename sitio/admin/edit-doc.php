<?php

//import database
include("../modelos/conexion.php");
$database = Conexion::conectar();

if ($_POST) {
    //print_r($_POST);
    $result = $database->prepare("select * from medics");
    $result->execute();
    $name = $_POST['name_medic'];
    $oldemail = $_POST["oldemail"];
    $matri = $_POST['matricul_medic'];
    $spec = $_POST['specialty_id'];
    $email = $_POST['email_medic'];
    $tele = $_POST['phone_medic'];
    $password = $_POST['password_medic'];
    $cpassword = $_POST['cpassword_medic'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';
        $result = $database->prepare("Select from medics where medics.email_medic='$email';");
        $result->execute();
        $num_rows = $result->rowCount();
        //$resultqq= $database->query("select * from doctor where docid='$id';");
        if ($num_rows == 1) {
            $id2 = $result->fetch(PDO::FETCH_ASSOC)["id_medic"];
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
            $sql1 = "UPDATE medics SET email_medic='$email',name_medic='$name',password_medic='$password',matricul_medic='$matri',phone_medic='$tele',specialty_id=$spec 
            WHERE id_medic=$id ;";
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


header("location: doctors.php?action=edit&error=" . $error . "&id=" . $id);
?>



</body>

</html>
