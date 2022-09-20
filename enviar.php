
<!--CONFIGURACION GENERAL-->
<?php
//RECAPTCHA
define("SITE_KEY", '6Lf0NcccAAAAAKB2NJIVuuwoKtVAXDb0aoDJ9AUL');
define("SECRET_KEY", '6Lf0NcccAAAAAOfD-uTp7HjqfdauC9oUXxid02rT');
?>

<!--JQUERY-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/Exception.php';
require 'vendor/PHPMailer/PHPMailer.php';
require 'vendor/PHPMailer/SMTP.php';

//Instantiation and passing `true` enables exceptions

if ($_POST['token']){
    $gtoken = $_POST['token'];
    $secret = SECRET_KEY;
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$gtoken}");
    $response = json_decode($response);
    $response = (array) $response;
    if ($response['success'] && ($response['score'] > 0.5)){
        $name = $_POST['nombre'];
        $empresa = $_POST['empresa'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $msj = $_POST['mensaje'];
        $mail = new PHPMailer(true);
        $body = "<b>Este mensaje fue enviado por: </b>" . $name . "<br>". "<b>Este mensaje fue enviado por: </b>" . $empresa . "<br>" ."<br><b>Su e-mail es: </b>" . $email . "<br>". "<br><b>Teléfono de contacto: </b>" . $phone . "<br>". 
         "<br><b>Mensaje: </b>" . $msj . "<br>" .  "<br><b>Enviado el: </b>" . date('d/m/Y', time()) . "<br>";
        try {
            //Server settings
            $mail->SMTPDebug = false;                     
            $mail->isSMTP();                                            
            $mail->Host       = 'vps-1218735-x.dattaweb.com'; 
            $mail->SMTPAuth   = true;                                 
            $mail->Username   = 'no-reply-colorxpress@imperarweb.com.ar';               
            $mail->Password   = 'Imperar21*';                              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        //`PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Port       = 465; 
            //Recipients
            $mail->setFrom('no-reply@colorxpress.imperarweb.com.ar', 'Mensaje de Para obras');
            $mail->addAddress('javier_9333@hotmail.com');            
            //Content
            $mail->isHTML(true);                                  
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Mensaje de Para obras';
            $mail->Body    = $body;        
            $mail->send();
            echo "<script>window.location.href='index.html';</script>";
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        //header("Location:index.html");
    }
}  
?>