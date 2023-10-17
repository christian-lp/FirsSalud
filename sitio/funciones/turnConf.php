<?php 
error_reporting(E_ALL);
include("class.phpmailer.php");
include("class.smtp.php");

function enviar_mail($useremail,$username,$docemail,$docname,$apponum,$scheduledate,$scheduletime,$title,$site,$sourcemail,$passmail)
{
$mail = new PHPMailer();

/// Envio el link de la activación a mi sitio, redirigido a un script en php que leera el archivo de usuarios
/// y cambiara el estado de activación de 0 a 1 en el caso de encontrarlo y que este en 0
/// el link de propio de cada equipo  

// utilizo la funcion de php base64_encode para enviar información medianamente segura sin que el usuario vea facilmente
//$linkactivacion=$site.'?tagged='.base64_encode($email);
//<h3><b> Enlace de activacion '.$linkactivacion.':</b></h3>


$body='<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="STYLESHEET" type="text/css" href="./css/style.css"> 
</head></head> 

<body style="margin: 0; padding: 0; background-color: white;">
    <center>
            <table class="contenido_tabla" width="700" style="background-color:black; color:white; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; padding: 0 25px; ">
                <thead>
                    <tr>
                        <td><left><b><img src="/var/www/html/FirsSalud/img/Logo.png" width="700px"></td>
                    </tr>
                    <tr><br>
                        <td><center><h2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Confirmaci&oacute;n de Turno</b></h2></center></td>
                    </tr>
                </thead>
                <tbody border="0"> 
                    <tr>
                        <td style="color:white;" colspan="2">
                            <h3><b>Estimad@ '.$username.':</b></h3>
                            Su turno ha sido confirmado.. Gracias por confiar en nosotros!
                            <td style="width: 50%;" rowspan="2">
                            <div  class="dashboard-items search-items"  >
                            
                                <div style="width:100%">
                                        <div class="h1-search" style="font-size:25px;">
                                            Informacion Citas
                                        </div><br><br>
                                        <div class="h3-search" style="font-size:18px;line-height:30px">
                                            Nombre Doctor:  &nbsp;&nbsp;<b>' . $docname . '</b><br>
                                            Correo Doctor:  &nbsp;&nbsp;<b>' . $docemail . '</b> 
                                        </div>
                                        <div class="h3-search" style="font-size:18px;">

                                        </div><br>
                                        <div class="h3-search" style="font-size:18px;">
                                            Titulo Cita: ' . $title . '<br>
                                            Fecha programada de la sesión: ' . $scheduledate . '<br>
                                            Cita Empieza: ' . $scheduletime . '<br>
                                            

                                        </div>
                                        <br>
                                        
                                </div>
                                            
                                </div>
                            </td>
                            
                            <td style="width: 25%;">
                                <div  class="dashboard-items search-items"  >
                                
                                <div style="width:100%;padding-top: 15px;padding-bottom: 15px;">
                                        <div class="h1-search" style="font-size:20px;line-height: 35px;margin-left:8px;text-align:center;">
                                        Tu numero de cita
                                        </div>
                                        <center>
                                        <div class=" dashboard-icons" style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">' . $apponum . '</div>
                                    </center>
                                        </div><br>
                                        
                                        <br>
                                        <br>
                                </div>
                                        
                                </div>
                            </td>
                        </tr>                     
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top:1px solid #cccccc; margin-top:2px; font-size:15px;"><br>
                            <left>
                                <strong> Medic </strong><br>
                                Contacto systemss2023@gmail.com<br><br>
                            </left>
                        </td>
                    </tr>
                </tbody>
            </table>
    </center>
</body> 
</html>';

// Atención para poder enviar a traves de gmail se debe permitir a google enviar mails desde otras aplicaciones
// para ello deberán entrar al link de abajo, se realiza por única vez
// https://myaccount.google.com/u/0/lesssecureapps?pli=1

$mail->IsSMTP(); // telling the class to use SMTP
// instrucciones de la funcion ///
//$mail->Host       = "mail.yourdomain.com"; // SMTP server
//$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
//$mail->SMTPAuth   = true;                  // enable SMTP authentication
//$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
//$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = '587';                   // set the SMTP port for the GMAIL server
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username   = $sourcemail;  // GMAIL username
$mail->Password   = $passmail;            // GMAIL password
$mail->SetFrom("systemmss2023@gmail.com", 'Medic');
$mail -> AddAddress($useremail,$username);
$mail->Subject    = "Confirmacion de Turno.... ";
$mail->AltBody    = "...---..."; // optional, comment out and test
$mail->MsgHTML($body);
//$Errrrror="";
//
// si deseo adjuntar algun archivo 
///$mail->AddAttachment("archivarchivivoivo.tar.xz");

if(!$mail->Send())
{
    $Errrrror="<br>.<br>Mailer Error: " . $mail->ErrorInfo;
}
else
{
    return true;
}
}
?> 