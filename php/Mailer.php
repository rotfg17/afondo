<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};


class Mailer 
{

    function enviarCorreo($correo, $asunto, $cuerpo)
    {

        require_once __DIR__ . '/../php/config.php';
        require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
        require_once __DIR__ . '/../phpmailer/src/SMTP.php';
        require_once __DIR__ . '/../phpmailer/src/Exception.php';

        $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;  //SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            
    $mail->Host = MAIL_HOST;                                     //Configura el servidor SMTP para enviar
    $mail->SMTPAuth   = true;                                   //Habilita la autenticacion SMTP
    $mail->Username   = MAIL_USER;                             //Usuario SMTP
    $mail->Password   = MAIL_PASS;                            //Contrasena SMTP 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Habilita el cifrado TLS
    $mail->Port = MAIL_PORT;                                //Puerto TCP al que conectarse; si usas 587 configuralo con `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS `

    //Correo emisor y nombre
    $mail->setFrom(MAIL_USER, 'A fondo con Andreina');
    //Correo receptor y nombre
    $mail->addAddress($correo);
    

    //Contenido
    $mail->isHTML(true);    //Establecer el formato de correo electronico en HTML                            
    $mail->Subject = $asunto;   //Titulo del correo

    //Cuerpo del correo
    $mail->Body    = mb_convert_encoding($cuerpo, 'ISO-8859-1', 'UTF-8');
    $mail->setLanguage('es', '../phpmailer/languague/phpmailer.lang-es.php');

    //Enviar correo
  if($mail->send()){
    return true;
  } else {
    return false;
  }

        } catch (Exception $e) {
            echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
            return false;
        }
    }

}