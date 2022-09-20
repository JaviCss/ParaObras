
<!--CONFIGURACION GENERAL-->
<?php
//RECAPTCHA
define("SITE_KEY", '6Lf0NcccAAAAAKB2NJIVuuwoKtVAXDb0aoDJ9AUL');
define("SECRET_KEY", '6Lf0NcccAAAAAOfD-uTp7HjqfdauC9oUXxid02rT');
?>

<!--JQUERY-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

</script>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/Exception.php';
require 'vendor/PHPMailer/PHPMailer.php';
require 'vendor/PHPMailer/SMTP.php';

$name = $_POST['nombre'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$msj = $_POST['mensaje'];
$rubro = $_POST¨['rubro']
$local = $_POST¨['local']
$ubication = $_POST¨['ubication']
$capacidad = $_POST¨['capacidad']
//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
    $body = "<b>Este mensaje fue enviado por: </b>" . $name . "<br>".
    "<br><b>Su e-mail es: </b>" . $email . "<br>".
    "<br><b>Teléfono de contacto: </b>" . $phone . "<br>".
    "<br><b>¿Formas parte del rubro? </b>" . $rubro . "<br>".
    "<br><b>¿Tenes local propio o alquilas? </b>" . $local . "<br>".
    "<br><b>¿En que zona esta ubicada? </b>" . $ubication . "<br>". 
    "<br><b>¿Tenes capacidad para invertir en tu propio negocio? </b>" . $capacidad . "<br>".
    "<br><b>Mensaje: </b>" . $msj . "<br>". 
    "<br><b>Enviado el: </b>" . date('d/m/Y', time()). "<br>";

if ($_POST['token']){

    $gtoken = $_POST['token'];
    $secret = SECRET_KEY;
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$gtoken}");
    $response = json_decode($response);
    $response = (array) $response;
    print_r($response);
    if ($response['success'] && ($response['score'] > 0.5)){
        
        try {
            //Server settings
            $mail->SMTPDebug = 2;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'vps-1218735-x.dattaweb.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'no-reply@colorxpress.imperarweb.com.ar';                     //SMTP username
            $mail->Password   = 'Imperar2021*';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('no-reply@colorxpress.imperarweb.com.ar', 'Color Xpress');
            $mail->addAddress('javier_9333@hotmail.com', $name);     //Add a recipient             //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addBCC('bcc@example.com');
        
            //Attachments
            if (false){
               
            $mail->addAttachment($archivo['tmp_name'], $archivo['name']); 
            }        //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Color express consulta';
            $mail->Body    = $body;        
            $mail->send();
            //$mail->ClearAttachments();
            header("Location:index.html"); 
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Message could not be sent. recaptcha error";
        // header("Location:index.html");
    }
}  
?>

